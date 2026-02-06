<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/customerModel.php";
require_once "../Model/enq_cat_mappingmodel.php";
require_once "../DB Operations/enq_cat_mappingOps.php";
require_once "../DB Operations/enquiryOps.php";
class DBcustomer
{
    public static function insert($customer)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO customer (`customerName`, 
    `customerCode`,
    `customerContactNumber`,
    `customerEmail`,
    `customerAddress`,
    `customerState`,
    `customerCountry`,
    `customerCity`,
    `customerDOV`,
    `enq_Id`,
    `createdBy`,
    `modifiedBy`) 
                values ('" . $customer->get_customerName() .
            "','" . $customer->getCustomerCode() .
            "','" . $customer->get_customerPhone() .
            "','" . $customer->get_customerEmail() .
            "','" . $customer->get_customerAddress() .
            "','" . $customer->get_customerState() .
            "','" . $customer->getCustomerCountry() .
            "','" . $customer->get_customerCity() .
            "','" . $customer->get_customerDov() .
            "','" . $customer->get_enqId() .
            "','" . $customer->get_CreatedBy() .
            "','" . $customer->get_ModifiedBy() .
            "')";

        if ($connectionObj->query($sql) === true) {
            $lastInsertedId = $connectionObj->insert_id;
            $sql = "UPDATE customer SET customerCode='" . $customer->getCustomerCode() . $lastInsertedId . "' WHERE customerId=" . $lastInsertedId;
            $connectionObj->query($sql);
            $sql = "UPDATE enquiry_details SET isCustomerCreated=true , enqStatus='Attended' WHERE enqid=" . $customer->get_enqId();
            $connectionObj->query($sql);
            error_log($sql);
        } else {
            error_log("Error: " . $sql . "<br>" . $connectionObj->error);
        }
    }

    public static function getAllcustomer()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT C.customerId  as customerId ,
        C.customerCode as customerCode,
        C.customerName as customerName,
        C.customerContactNumber as customerContactNumber,
        C.customerEmail as customerEmail,
        C.customerAddress as customerAddress,
        C.customerState as customerState,
        C.customerCity as customerCity,
        C.customerDOV as customerDOV,
        C.customerCountry as customerCountry,
        C.enq_id  as enq_id,
        Count(Q.quoteId) as QuotationCount
        FROM customer C
        Left Join quotation_details Q on Q.customerId=C.customerId 
        group by customerId ";
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $customerList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $customer = new customer();
                $customer->set_customerId($row['customerId']);
                $customer->setCustomerCode($row['customerCode']);
                $customer->set_customerName($row['customerName']);
                $customer->set_customerPhone($row["customerContactNumber"]);
                $customer->set_customerEmail($row["customerEmail"]);
                $customer->set_customerAddress($row["customerAddress"]);
                $customer->set_customerState($row["customerState"]);
                $customer->set_customerCity($row["customerCity"]);
                $customer->setCustomerCountry($row["customerCountry"]);
                $customer->set_customerDov(date('Y-m-d', strtotime($row["customerDOV"])));
                $customer->set_enqId($row["enq_id"]);
                $customer->setListOfEnq(DBenqCatMapping::getCategoryForEnq($row["enq_id"]));
                $customer->setQuotationCount($row["QuotationCount"]);

                array_push($customerList, $customer);
            }
        } else {
            // echo "0 results";
        }
        return $customerList;
    }

    public static function update($customer)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $enqId = DBcustomer::selectenqbasedonId($customer->get_customerId());
        $sql = "UPDATE customer SET customerCode='" . $customer->getCustomerCode() .
            "', customerName='" . $customer->get_customerName() .
            "', customerContactNumber='" . $customer->get_customerPhone() .
            "', customerEmail='" . $customer->get_customerEmail() .
            "', customerAddress='" . $customer->get_customerAddress() .
            "', customerState='" . $customer->get_customerState() .
            "', customerCountry='" . $customer->getCustomerCountry() .
            "', customerCity='" . $customer->get_customerCity() .
            "',customerDOV='" . $customer->get_customerDov() .
            "', createdBy='" . $customer->get_CreatedBy() .
            "', modifiedBy='" . $customer->get_ModifiedBy() .
            "' WHERE customerId=" . $customer->get_customerId();
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
            $sql = "UPDATE enquiry_details SET enq_name='" . $customer->get_customerName() . "',
            enq_email='" . $customer->get_customerEmail() . "',
            enq_address='" . $customer->get_customerAddress() . "',
            enq_phone='" . $customer->get_customerPhone() . "',
            enq_name='" . $customer->get_customerName() . "'
             where enqid='" . $enqId->get_enqId() . "'";
            error_log($sql);
            if ($connectionObj->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $connectionObj->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function selectcustomer()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = 'SELECT customerId,customerName FROM customer';
        $result = mysqli_query($db->getConnection(), $sql);
        $customerList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $customer = new customer();
                $customer->set_customerId($row['customerId']);
                $customer->set_customerName($row['customerName']);
                array_push($customerList, $customer);
            }
        } else {
            echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($customerList);
    }

    public static function selectcustomerbasedonId($id)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT customerId,customerName,customerContactNumber,customerAddress,customerCode,customerCountry FROM customer where customerId='$id'";
        $result = mysqli_query($db->getConnection(), $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $customer = new customer();
                $customer->setCustomerCode($row['customerCode']);
                $customer->set_customerPhone($row['customerContactNumber']);
                $customer->set_customerAddress($row['customerAddress']);
                $customer->set_customerName($row['customerName']);
                $customer->setCustomerCountry($row['customerCountry']);

            }
        } else {
            echo "0 results";
        }

        return ($customer);
    }

    public static function selectenqbasedonId($id)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT enq_id FROM customer where customerId='$id'";
        $result = mysqli_query($db->getConnection(), $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $customer = new customer();
                $customer->set_enqId($row["enq_id"]);
            }
        } else {
            echo "0 results";
        }

        return ($customer);
    }

    public static function selectquoteIdbasedonId($id)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT 	quoid FROM quotation_details where customerId='$id'";
        $result = mysqli_query($db->getConnection(), $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $customer = new customer();
                $customer->setQuoteId($row["quoid"]);
            }
        } else {
            echo "0 results";
        }
        return ($customer);
    }
    public static function getQuotationSummaryByCustomer($customerId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "
        SELECT 
            EC.enq_cat_name AS quotationName,
            COUNT(Q.quoteId) AS total
        FROM quotation_details Q
        JOIN enquiry_category EC 
            ON EC.enq_catid = Q.enqCatId
        WHERE Q.customerId = $customerId
        GROUP BY EC.enq_catid
    ";

        $result = $connectionObj->query($sql);
        $data = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = [
                    'name' => $row['quotationName'],
                    'count' => $row['total']
                ];
            }
        }

        return $data;
    }



    public static function delete($customerId)
    {
        // ❌ BLOCK deletion if quotation exists
        if (self::hasQuotation($customerId)) {
            error_log("Delete blocked: Customer $customerId has quotations");
            return false;
        }
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $custcode = DBcustomer::selectcustomerbasedonId($customerId);
        $enqId = DBcustomer::selectenqbasedonId($customerId);
        $quoteId = DBcustomer::selectquoteIdbasedonId($customerId);
        $sql = "DELETE from customer where customerId=" . $customerId;
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
            $sql = "Delete from projects where custId='" . $custcode->getCustomerCode() . "'";
            error_log($sql);
            if ($connectionObj->query($sql) === TRUE) {
                $sql = "UPDATE enquiry_details SET isCustomerCreated=0 where enqid='" . $enqId->get_enqId() . "'";
                error_log($sql);
                if ($connectionObj->query($sql) === TRUE) {
                    $sql = "Delete from designimages where customerId='$customerId'";
                    error_log($sql);
                    if ($connectionObj->query($sql) === TRUE) {
                        $sql = "DELETE from quotation_details where customerId=" . $customerId;
                        error_log($sql);
                        if ($connectionObj->query($sql) === TRUE) {
                            $sql = "DELETE from quotelineitem where quoteId='" . $quoteId->getQuoteId() . "'";
                            error_log($sql);
                            if ($connectionObj->query($sql) === true) {
                                $sql = "DELETE from customerpaymentinfo where customer_id ='" . $custcode->getCustomerCode() . "'";

                            } else {
                                echo "Error: " . $sql . "<br>" . $connectionObj->error;
                            }
                        } else {
                            echo "Error: " . $sql . "<br>" . $connectionObj->error;
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . $connectionObj->error;
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $connectionObj->error;
                }
            } else {
                echo "Error: " . $sql . "<br>" . $connectionObj->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
        error_log($sql);
    }

    public static function hasQuotation($customerId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $sql = "SELECT COUNT(*) as total FROM quotation_details WHERE customerId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        return ($res['total'] > 0);
    }

}