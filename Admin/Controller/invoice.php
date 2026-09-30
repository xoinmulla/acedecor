    <?php
    require_once "../Model/invoiceModel.php";
    require_once "../DB Operations/invoiceOps.php";
    require_once "../Utilities/Sanitization.php";

    function invoiceJson($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET') {
        invoiceJson(['success' => false, 'message' => 'Invalid request method.']);
    }

    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    try {
        if ($action === 'list') {
            invoiceJson([
                'success' => true,
                'data' => DBInvoice::getAll()
            ]);
        }

        if ($action === 'get') {
            $id = intval($_POST['id'] ?? $_GET['id'] ?? 0);
            $invoice = DBInvoice::getById($id);

            if (!$invoice) {
                invoiceJson(['success' => false, 'message' => 'Invoice not found.']);
            }

            invoiceJson(['success' => true, 'data' => $invoice]);
        }

        if ($action === 'add' || $action === 'update') {
            $invoiceData = [
                'invoiceDate' => Sanitization::test_input($_POST['invoiceDate'] ?? ''),
                'invoiceNumber' => Sanitization::test_input($_POST['invoiceNumber'] ?? ''),
                'dispatchThrough' => Sanitization::test_input($_POST['dispatchThrough'] ?? ''),
                'destination' => Sanitization::test_input($_POST['destination'] ?? ''),
                'clientName' => Sanitization::test_input($_POST['clientName'] ?? ''),
                'address' => Sanitization::test_input($_POST['address'] ?? ''),
                'location' => Sanitization::test_input($_POST['location'] ?? ''),
                'contact' => Sanitization::test_input($_POST['contact'] ?? ''),
                'vehicleNo' => Sanitization::test_input($_POST['vehicleNo'] ?? ''),
                'gst' => Sanitization::test_input($_POST['gst'] ?? ''),
                'igst' => Sanitization::test_input($_POST['igst'] ?? ''),
                'items' => json_decode($_POST['items'] ?? '[]', true)
            ];

            if (
                $invoiceData['invoiceDate'] === '' ||
                $invoiceData['invoiceNumber'] === '' ||
                $invoiceData['clientName'] === ''
            ) {
                invoiceJson([
                    'success' => false,
                    'message' => 'Date, Invoice No. and Client Name are required.'
                ]);
            }

            if ($action === 'add') {
                $id = DBInvoice::insert($invoiceData);

                invoiceJson([
                    'success' => true,
                    'message' => 'Invoice created successfully.',
                    'id' => $id
                ]);
            }

            $id = intval($_POST['invoiceId'] ?? 0);
            DBInvoice::update($id, $invoiceData);

            invoiceJson([
                'success' => true,
                'message' => 'Invoice updated successfully.',
                'id' => $id
            ]);
        }

        if ($action === 'delete') {
            $id = intval($_POST['id'] ?? 0);

            if ($id <= 0) {
                invoiceJson(['success' => false, 'message' => 'Invalid invoice id.']);
            }

            $deleted = DBInvoice::delete($id);

            invoiceJson([
                'success' => $deleted,
                'message' => $deleted ? 'Invoice deleted successfully.' : 'Invoice not found.'
            ]);
        }

        invoiceJson(['success' => false, 'message' => 'Unknown action.']);
    } catch (Throwable $e) {
        error_log("Invoice Controller Error: " . $e->getMessage());

        invoiceJson([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    ?>