<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/companyregistrationmodel.php";
class DBcompany
{
  public static function insert($companyObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "insert into company_details (`company_name`, `company_address`, `company_contact`,`company_tag`,`company_branches`,`company_email`,`password`,`company_GSTIN`, `company_BankName`, `company_BankAccountNumber`, `company_BankIFSC`) 
                values ('" . $companyObj->get_companyname() .
      "','" . $companyObj->get_companyaddress() .
      "','" . $companyObj->get_companycontact() .
      "','" . $companyObj->get_companytag() .
      "','" . $companyObj->get_companybranches() .
      "','" . $companyObj->get_companyemail() .
      "','" . $companyObj->get_companypassword() . 
      "','" . $companyObj->get_companyGSTIN() .
      "','" . $companyObj->get_companyBankName() .
      "','" . $companyObj->get_companyBankAccountNumber() .
      "','" . $companyObj->get_companyBankIFSC() .
      "')";

    if ($connectionObj->query($sql) === TRUE) {
      
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
}
