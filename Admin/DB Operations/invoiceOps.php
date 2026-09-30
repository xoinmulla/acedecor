<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/invoiceModel.php";

class DBInvoice
{
    private static function esc($conn, $value)
    {
        return $conn->real_escape_string(trim((string) ($value ?? '')));
    }

    private static function normaliseItems($items)
    {
        if (!is_array($items)) {
            return [];
        }

        $result = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $description = trim((string) ($item['description'] ?? ''));
            $qty = (float) ($item['qty'] ?? 0);
            $hsn = trim((string) ($item['hsn'] ?? ''));
            $unitPrice = (float) ($item['unitPrice'] ?? 0);

            if ($description === '' && $qty <= 0 && $hsn === '' && $unitPrice <= 0) {
                continue;
            }

            $result[] = [
                'description' => $description,
                'qty' => $qty,
                'hsn' => $hsn,
                'unitPrice' => $unitPrice,
                'amount' => round($qty * $unitPrice, 2)
            ];
        }

        return $result;
    }
    private static function calculateInvoiceTax($items, $gst, $igst)
    {
        $subTotal = 0;

        foreach ($items as $item) {
            $subTotal += (float) $item['amount'];
        }

        $subTotal = round($subTotal, 2);

        $gstRate = ($gst !== '' && $gst !== null) ? (float) $gst : null;
        $igstRate = ($igst !== '' && $igst !== null) ? (float) $igst : null;

        $sgstAmount = 0;
        $cgstAmount = 0;
        $igstAmount = 0;

        $sgstRate = 0;
        $cgstRate = 0;

        /*
         * GST and IGST are mutually exclusive.
         */

        if ($gstRate !== null) {

            // GST 18% => CGST 9% + SGST 9%
            $sgstRate = $gstRate / 2;
            $cgstRate = $gstRate / 2;

            $sgstAmount = round(
                $subTotal * ($sgstRate / 100),
                2
            );

            $cgstAmount = round(
                $subTotal * ($cgstRate / 100),
                2
            );

        } elseif ($igstRate !== null) {

            // IGST 18%
            $igstAmount = round(
                $subTotal * ($igstRate / 100),
                2
            );
        }

        $total = round(
            $subTotal +
            $sgstAmount +
            $cgstAmount +
            $igstAmount,
            2
        );

        return [
            'subTotal' => $subTotal,
            'sgstRate' => $sgstRate,
            'cgstRate' => $cgstRate,
            'igstRate' => $igstRate ?? 0,
            'sgstAmount' => $sgstAmount,
            'cgstAmount' => $cgstAmount,
            'igstAmount' => $igstAmount,
            'total' => $total
        ];
    }
    public static function insert($invoiceData)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $items = self::normaliseItems($invoiceData['items'] ?? []);
        if (empty($items)) {
            throw new Exception("At least one invoice item is required.");
        }

        $invoiceDate = self::esc($conn, $invoiceData['invoiceDate'] ?? '');
        $invoiceNumber = self::esc($conn, $invoiceData['invoiceNumber'] ?? '');
        $dispatchThrough = self::esc($conn, $invoiceData['dispatchThrough'] ?? '');
        $destination = self::esc($conn, $invoiceData['destination'] ?? '');
        $clientName = self::esc($conn, $invoiceData['clientName'] ?? '');
        $address = self::esc($conn, $invoiceData['address'] ?? '');
        $location = self::esc($conn, $invoiceData['location'] ?? '');
        $contact = self::esc($conn, $invoiceData['contact'] ?? '');
        $vehicleNo = self::esc($conn, $invoiceData['vehicleNo'] ?? '');
        $gst = self::esc($conn, $invoiceData['gst'] ?? '');
        $igst = self::esc($conn, $invoiceData['igst'] ?? '');

        $taxCalculation = self::calculateInvoiceTax(
            $items,
            $invoiceData['gst'] ?? '',
            $invoiceData['igst'] ?? ''
        );

        $total = $taxCalculation['total'];

        $conn->begin_transaction();

        try {
            $sql = "INSERT INTO invoices
        (invoice_date, invoice_number, dispatch_through, destination,
         client_name, address, location, contact, vehicle_no, gst, igst, total_amount)
        VALUES
        ('$invoiceDate', '$invoiceNumber', '$dispatchThrough', '$destination',
         '$clientName', '$address', '$location', '$contact', '$vehicleNo', '$gst', '$igst', '$total')";

            if (!$conn->query($sql)) {
                throw new Exception($conn->error);
            }

            $invoiceId = $conn->insert_id;

            foreach ($items as $item) {
                $description = self::esc($conn, $item['description']);
                $qty = (float) $item['qty'];
                $hsn = self::esc($conn, $item['hsn']);
                $unitPrice = (float) $item['unitPrice'];
                $amount = (float) $item['amount'];

                $itemSql = "INSERT INTO invoice_items
                            (invoice_id, description, qty, hsn, unit_price, amount)
                            VALUES
                            ($invoiceId, '$description', $qty, '$hsn', $unitPrice, $amount)";

                if (!$conn->query($itemSql)) {
                    throw new Exception($conn->error);
                }
            }

            $conn->commit();
            return $invoiceId;
        } catch (Throwable $e) {
            $conn->rollback();
            throw $e;
        }
    }

    public static function update($invoiceId, $invoiceData)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $invoiceId = intval($invoiceId);
        if ($invoiceId <= 0) {
            throw new Exception("Invalid invoice id.");
        }

        $items = self::normaliseItems($invoiceData['items'] ?? []);
        if (empty($items)) {
            throw new Exception("At least one invoice item is required.");
        }

        $taxCalculation = self::calculateInvoiceTax(
            $items,
            $invoiceData['gst'] ?? '',
            $invoiceData['igst'] ?? ''
        );

        $total = $taxCalculation['total'];

        $invoiceDate = self::esc($conn, $invoiceData['invoiceDate'] ?? '');
        $invoiceNumber = self::esc($conn, $invoiceData['invoiceNumber'] ?? '');
        $dispatchThrough = self::esc($conn, $invoiceData['dispatchThrough'] ?? '');
        $destination = self::esc($conn, $invoiceData['destination'] ?? '');
        $clientName = self::esc($conn, $invoiceData['clientName'] ?? '');
        $address = self::esc($conn, $invoiceData['address'] ?? '');
        $location = self::esc($conn, $invoiceData['location'] ?? '');
        $contact = self::esc($conn, $invoiceData['contact'] ?? '');
        $vehicleNo = self::esc($conn, $invoiceData['vehicleNo'] ?? '');
        $gst = self::esc($conn, $invoiceData['gst'] ?? '');
        $igst = self::esc($conn, $invoiceData['igst'] ?? '');

        $conn->begin_transaction();

        try {
            $sql = "UPDATE invoices SET
                        invoice_date = '$invoiceDate',
                        invoice_number = '$invoiceNumber',
                        dispatch_through = '$dispatchThrough',
                        destination = '$destination',
                        client_name = '$clientName',
                        address = '$address',
                        location = '$location',
                        contact = '$contact',
                        vehicle_no = '$vehicleNo',
                        gst = '$gst',
                        igst = '$igst',
                        total_amount = '$total'
                    WHERE invoice_id = $invoiceId";

            if (!$conn->query($sql)) {
                throw new Exception($conn->error);
            }

            if (!$conn->query("DELETE FROM invoice_items WHERE invoice_id = $invoiceId")) {
                throw new Exception($conn->error);
            }

            foreach ($items as $item) {
                $description = self::esc($conn, $item['description']);
                $qty = (float) $item['qty'];
                $hsn = self::esc($conn, $item['hsn']);
                $unitPrice = (float) $item['unitPrice'];
                $amount = (float) $item['amount'];

                $itemSql = "INSERT INTO invoice_items
                            (invoice_id, description, qty, hsn, unit_price, amount)
                            VALUES
                            ($invoiceId, '$description', $qty, '$hsn', $unitPrice, $amount)";

                if (!$conn->query($itemSql)) {
                    throw new Exception($conn->error);
                }
            }

            $conn->commit();
            return true;
        } catch (Throwable $e) {
            $conn->rollback();
            throw $e;
        }
    }

    public static function delete($invoiceId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $invoiceId = intval($invoiceId);
        if ($invoiceId <= 0) {
            return false;
        }

        $conn->begin_transaction();

        try {
            if (!$conn->query("DELETE FROM invoice_items WHERE invoice_id = $invoiceId")) {
                throw new Exception($conn->error);
            }

            if (!$conn->query("DELETE FROM invoices WHERE invoice_id = $invoiceId")) {
                throw new Exception($conn->error);
            }

            $deleted = $conn->affected_rows > 0;
            $conn->commit();
            return $deleted;
        } catch (Throwable $e) {
            $conn->rollback();
            throw $e;
        }
    }

    public static function getAll()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $sql = "SELECT * FROM invoices ORDER BY invoice_id DESC";
        $result = $conn->query($sql);

        $list = [];

        if ($result) {

            while ($row = $result->fetch_assoc()) {

                // Get all items for this invoice
                $itemStmt = $conn->prepare(
                    "SELECT qty, unit_price, amount
                 FROM invoice_items
                 WHERE invoice_id = ?"
                );

                $itemStmt->bind_param("i", $row['invoice_id']);
                $itemStmt->execute();

                $itemsResult = $itemStmt->get_result();

                $subTotal = 0;

                while ($item = $itemsResult->fetch_assoc()) {
                    $subTotal += (float) $item['amount'];
                }

                $subTotal = round($subTotal, 2);

                // Tax rates
                $gst = $row['gst'];
                $igst = $row['igst'];

                $gstRate = ($gst !== null && $gst !== '')
                    ? (float) $gst
                    : null;

                $igstRate = ($igst !== null && $igst !== '')
                    ? (float) $igst
                    : null;

                $sgstAmount = 0;
                $cgstAmount = 0;
                $igstAmount = 0;

                /*
                 * GST and IGST are mutually exclusive.
                 */

                if ($gstRate !== null) {

                    // GST 18% = CGST 9% + SGST 9%
                    $sgstRate = $gstRate / 2;
                    $cgstRate = $gstRate / 2;

                    $sgstAmount = round(
                        $subTotal * ($sgstRate / 100),
                        2
                    );

                    $cgstAmount = round(
                        $subTotal * ($cgstRate / 100),
                        2
                    );

                } elseif ($igstRate !== null) {

                    // IGST 18%
                    $igstAmount = round(
                        $subTotal * ($igstRate / 100),
                        2
                    );
                }

                // Final invoice amount
                $finalTotal = round(
                    $subTotal +
                    $sgstAmount +
                    $cgstAmount +
                    $igstAmount,
                    2
                );

                // Override only the value used by the main table
                $row['total_amount'] = $finalTotal;

                $list[] = $row;
            }
        }

        return $list;
    }

    public static function getById($invoiceId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $invoiceId = intval($invoiceId);

        $stmt = $conn->prepare("SELECT * FROM invoices WHERE invoice_id = ? LIMIT 1");
        $stmt->bind_param("i", $invoiceId);
        $stmt->execute();

        $invoiceResult = $stmt->get_result();
        $invoice = $invoiceResult->fetch_assoc();

        if (!$invoice) {
            return null;
        }

        $itemStmt = $conn->prepare(
            "SELECT invoice_item_id, description, qty, hsn, unit_price, amount
             FROM invoice_items
             WHERE invoice_id = ?
             ORDER BY invoice_item_id ASC"
        );
        $itemStmt->bind_param("i", $invoiceId);
        $itemStmt->execute();

        $itemsResult = $itemStmt->get_result();
        $invoice['items'] = [];

        while ($item = $itemsResult->fetch_assoc()) {
            $invoice['items'][] = $item;
        }

        return $invoice;
    }
}
?>