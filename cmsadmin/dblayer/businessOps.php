<?php
require_once "dbconnection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/acedecor/cmsadmin/model/businessModel.php";

class DBbusiness
{
    public static function insert($businessObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "INSERT INTO businessdetails (
            businessName,
            businessAddress,
            businessContact,
            businessContact2,
            businessTagLine,
            businessEmail,
            businessGSTIN,
            logoImage,
            aboutBusiness,
            aboutHeader,
            aboutSubheading,
            aboutTitle,
            aboutImage
        ) VALUES (
            '".$businessObj->getBusinessName()."',
            '".$businessObj->getBusinessAddress()."',
            '".$businessObj->getBusinessContact()."',
            '".$businessObj->getBusinessContact2()."',
            '".$businessObj->getBusinessTag()."',
            '".$businessObj->getBusinessEmail()."',
            '".$businessObj->getBusinessGSTIN()."',
            '".$businessObj->getBusinessLogoImage()."',
            '".$businessObj->getBusinessAboutBusiness()."',
            '".$businessObj->getAboutHeader()."',
            '".$businessObj->getAboutSubheading()."',
            '".$businessObj->getAboutTitle()."',
            '".$businessObj->getAboutImage()."'
        )";

        if ($connectionObj->query($sql) === TRUE) {
            // success
        } else {
            error_log("Insert Error: " . $connectionObj->error);
        }
    }

    public static function update($businessObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "UPDATE businessdetails SET 
            businessName='".$businessObj->getBusinessName()."',
            businessAddress='".$businessObj->getBusinessAddress()."',
            businessContact='".$businessObj->getBusinessContact()."',
            businessContact2='".$businessObj->getBusinessContact2()."',
            businessTagLine='".$businessObj->getBusinessTag()."',
            businessEmail='".$businessObj->getBusinessEmail()."',
            businessGSTIN='".$businessObj->getBusinessGSTIN()."',
            aboutBusiness='".$businessObj->getBusinessAboutBusiness()."',
            aboutHeader='".$businessObj->getAboutHeader()."',
            aboutSubheading='".$businessObj->getAboutSubheading()."',
            aboutTitle='".$businessObj->getAboutTitle()."'";

        if (!empty($businessObj->getBusinessLogoImage())) {
            $sql .= ", logoImage='".$businessObj->getBusinessLogoImage()."'";
        }
        if (!empty($businessObj->getAboutImage())) {
            $sql .= ", aboutImage='".$businessObj->getAboutImage()."'";
        }

        $sql .= " WHERE businessId=".$businessObj->getBusinessId();

        error_log("Update SQL: ".$sql);

        if ($connectionObj->query($sql) === TRUE) {
            // success
        } else {
            error_log("Update Error: " . $connectionObj->error);
        }
    }

    public static function getBusinessDetails()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "SELECT * FROM businessdetails LIMIT 1";
        $result = $connectionObj->query($sql);

        $business = new Business();

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $business->setBusinessId($row["businessId"]);
            $business->setBusinessName($row["businessName"]);
            $business->setBusinessLogoImage($row["logoImage"]);
            $business->setBusinessTag($row["businessTagLine"]);
            $business->setBusinessAddress($row["businessAddress"]);
            $business->setBusinessContact($row["businessContact"]);
            $business->setBusinessContact2($row["businessContact2"]);
            $business->setBusinessEmail($row["businessEmail"]);
            $business->setBusinessAboutBusiness($row["aboutBusiness"]);
            $business->setBusinessGSTIN($row["businessGSTIN"]);

            // New fields
            $business->setAboutHeader($row["aboutHeader"]);
            $business->setAboutSubheading($row["aboutSubheading"]);
            $business->setAboutTitle($row["aboutTitle"]);
            $business->setAboutImage($row["aboutImage"]);
        }

        return $business;
    }
    // ================= BUSINESS MEDIA =================
public static function addBusinessMedia($businessId, $type, $fileName, $videoUrl, $caption)
{
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("INSERT INTO business_media (businessId, mediaType, fileName, videoUrl, caption) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $businessId, $type, $fileName, $videoUrl, $caption);
    $stmt->execute();
    $stmt->close();
}

public static function getBusinessMedia($businessId)
{
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM business_media WHERE businessId = ? ORDER BY id DESC");
    $stmt->bind_param("i", $businessId);
    $stmt->execute();
    $result = $stmt->get_result();
    $media = [];
    while ($row = $result->fetch_assoc()) {
        $media[] = $row;
    }
    $stmt->close();
    return $media;
}

public static function deleteBusinessMedia($id)
{
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("DELETE FROM business_media WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

}
