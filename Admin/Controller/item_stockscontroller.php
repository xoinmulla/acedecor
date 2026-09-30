<?php
require "../Model/item_stocksmodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/item_stocksOps.php";

/*
 * STEP 2:
 * Controller now returns a consistent JSON response for POST CRUD operations.
 *
 * Existing CRUD calls, parameters and business logic are preserved.
 * Only response handling has been added so the frontend can display
 * success/error messages.
 */

function stockJsonResponse($status, $message, $extra = [])
{
    header('Content-Type: application/json');
    echo json_encode(array_merge([
        'status' => $status,
        'message' => $message
    ], $extra));
    exit;
}


/* ============================================================
 * INLINE EDIT
 * ============================================================ */
if (isset($_POST['inlineEdit'])) {

    $stockId = $_POST['StockId'];
    $qty = $_POST['ReceivedQty'];
    $amt = $_POST['ReceivedQtyAmt'];
    $balance = $_POST['BalanceQty'];
    $type = $_POST['inventoryType'] ?? 'item';

    if ($type === 'item') {

        $result = DBitemstock::updateItemInwardRow(
            $stockId,
            $qty,
            $amt,
            $balance
        );

    } else if ($type === 'material') {

        $result = DBitemstock::updateMaterialInwardRow(
            $stockId,
            $qty,
            $amt,
            $balance
        );

    } else {
        stockJsonResponse(
            'error',
            'Invalid inventory type.'
        );
    }

    if (is_array($result) && isset($result['success']) && $result['success']) {

        stockJsonResponse(
            'success',
            'Inward entry updated successfully.',
            [
                'affected_rows' => $result['affected_rows'] ?? 0
            ]
        );

    } else if ($result === true) {

        stockJsonResponse(
            'success',
            'Inward entry updated successfully.'
        );

    } else {

        stockJsonResponse(
            'error',
            'Failed to update inward entry.'
        );
    }
}


/* ============================================================
 * POST CRUD OPERATIONS
 * ============================================================ */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    error_log("hiii");

    if (isset($_POST['StockId']) && $_POST['StockId'] != '') {

        // Existing UPDATE logic - unchanged.
        $stock = new Item_Stock();

        $stock->set_POID(
            Sanitization::test_input($_POST["POID"])
        );

        $stock->set_StockId(
            Sanitization::test_input($_POST["StockId"])
        );

        $stock->set_InvoiceNo(
            Sanitization::test_input($_POST["InvoiceNo"])
        );

        $stock->set_quantity(
            Sanitization::test_input($_POST["quantity"])
        );

        $stock->set_itemid(
            Sanitization::test_input($_POST["itemid"])
        );

        $stock->set_price(
            Sanitization::test_input($_POST["price"])
        );

        $stock->set_unit(
            Sanitization::test_input($_POST["unit"])
        );

        $stock->set_totalamt(
            Sanitization::test_input($_POST["totalamt"])
        );

        $stock->setItemCode(
            Sanitization::test_input($_POST["ItemCode"])
        );

        $stock->setItemname(
            Sanitization::test_input($_POST["ItemName"])
        );

        $stock->set_ReceivedQty(
            Sanitization::test_input($_POST["ReceivedQty"])
        );

        $stock->set_ReceivedQtyAmt(
            Sanitization::test_input($_POST["ReceivedQtyAmt"])
        );

        $stock->set_GST(
            Sanitization::test_input($_POST["GST"])
        );

        $stock->set_BalanceQty(
            Sanitization::test_input($_POST["BalanceQty"])
        );

        $result = DBitemstock::update($stock);

        if (is_array($result) && isset($result['success']) && $result['success']) {

            stockJsonResponse(
                'success',
                'Inward entry updated successfully.',
                [
                    'affected_rows' => $result['affected_rows'] ?? 0
                ]
            );

        } else if ($result === true) {

            stockJsonResponse(
                'success',
                'Inward entry updated successfully.'
            );

        } else {

            stockJsonResponse(
                'error',
                'Failed to update inward entry.'
            );
        }

    } elseif (isset($_POST["action"]) && $_POST["action"] == 'delete') {

        $result = DBitemstock::delete(
            $_POST["id"]
        );

        if (is_array($result) && isset($result['success']) && $result['success']) {

            stockJsonResponse(
                'success',
                'Inward entry deleted successfully.',
                [
                    'affected_rows' => $result['affected_rows'] ?? 0
                ]
            );

        } else if ($result === true) {

            stockJsonResponse(
                'success',
                'Inward entry deleted successfully.'
            );

        } else {

            stockJsonResponse(
                'error',
                'Failed to delete inward entry.'
            );
        }

    } else {

        // Existing INSERT logic - unchanged.
        $stock = new Item_Stock();

        $stock->set_POID(
            Sanitization::test_input($_POST["POID"])
        );

        $stock->set_StockId(
            Sanitization::test_input($_POST["StockId"])
        );

        $stock->set_InvoiceNo(
            Sanitization::test_input($_POST["InvoiceNo"])
        );

        $stock->set_quantity(
            Sanitization::test_input($_POST["quantity"])
        );

        $stock->set_itemid(
            Sanitization::test_input($_POST["itemid"])
        );

        $stock->set_price(
            Sanitization::test_input($_POST["price"])
        );

        $stock->set_unit(
            Sanitization::test_input($_POST["unit"])
        );

        $stock->set_totalamt(
            Sanitization::test_input($_POST["totalamt"])
        );

        $stock->setItemCode(
            Sanitization::test_input($_POST["ItemCode"])
        );

        $stock->setItemname(
            Sanitization::test_input($_POST["ItemName"])
        );

        $stock->set_ReceivedQty(
            Sanitization::test_input($_POST["ReceivedQty"])
        );

        $stock->set_ReceivedQtyAmt(
            Sanitization::test_input($_POST["ReceivedQtyAmt"])
        );

        $stock->set_GST(
            Sanitization::test_input($_POST["GST"])
        );

        $stock->set_BalanceQty(
            Sanitization::test_input($_POST["BalanceQty"])
        );

        $result = DBitemstock::insert($stock);

        if (is_array($result) && isset($result['success']) && $result['success']) {

            stockJsonResponse(
                'success',
                'Inward entry added successfully.',
                [
                    'affected_rows' => $result['affected_rows'] ?? 0
                ]
            );

        } else if ($result === true) {

            stockJsonResponse(
                'success',
                'Inward entry added successfully.'
            );

        } else {

            stockJsonResponse(
                'error',
                'Failed to add inward entry.'
            );
        }
    }
}


/* ============================================================
 * GET - GST
 * ============================================================ */
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['getGST'], $_GET['id'], $_GET['inventoryType'])) {

        $id = Sanitization::test_input($_GET['id']);
        $type = Sanitization::test_input($_GET['inventoryType']);

        header('Content-Type: application/json');

        if ($type === 'item') {

            $gst = DBitemstock::getItemGSTById($id);

        } else if ($type === 'material') {

            $gst = DBitemstock::getMaterialGSTById($id);

        } else {

            echo json_encode(['GST' => 0]);
            exit;
        }

        echo json_encode(['GST' => $gst]);
        exit;
    }
}


/* ============================================================
 * GET - INWARD DETAILS
 * ============================================================ */
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET["id"]) && !isset($_GET["POID"])) {

        $ItemId = Sanitization::test_input($_GET['id']);
        DBitemstock::viewinwarddetails($ItemId);

    } else if (isset($_GET["ItemCode"])) {

        $ItemCode = Sanitization::test_input($_GET['ItemCode']);
        DBitemstock::getStockListbasedonItemCode($ItemCode);

    } else {

        $PurchaseId = Sanitization::test_input($_GET["POID"]);

        DBitemstock::viewinwarddetailsbasedonID(
            $_GET["id"],
            $PurchaseId,
            $_GET["inventoryType"] ?? 'item'
        );
    }
}
?>