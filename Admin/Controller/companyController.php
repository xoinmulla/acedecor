<?php 
require "../Model/companyregistrationmodel.php";
require "../Utilities/Sanitization.php";
require "../DB Operations/companyOps.php";
require_once ("../Model/usermodel.php");
require_once ("../DB Operations/userOps.php");

if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $company=new Company();
    $company->set_companyname(Sanitization::test_input($_POST["companyname"]));
    $company->set_companycontact(Sanitization::test_input($_POST["companycontact"]));
    $company->set_companyemail(Sanitization::test_input($_POST["companyemail"]));
    $company->set_companypassword(Sanitization::test_input($_POST["companypassword"]));
    $company->set_companytag(Sanitization::test_input($_POST["companytag"]));
    $company-> set_companyaddress(Sanitization::test_input($_POST["companyaddress"]));
    $company-> set_companyGSTIN(Sanitization::test_input($_POST["companyGSTIN"]));
    $company-> set_companyBankName(Sanitization::test_input($_POST["companyBankName"]));
    $company-> set_companyBankAccountNumber(Sanitization::test_input($_POST["companyBankAccountNumber"]));
    $company-> set_companyBankIFSC(Sanitization::test_input($_POST["companyBankIFSC"]));
    DBcompany::insert($company);
    $user=new User();
    $user->set_username(Sanitization::test_input($_POST["companyemail"]));
    $user->set_usercontact(Sanitization::test_input($_POST["companycontact"]));
    $user->set_useremail(Sanitization::test_input($_POST["companyemail"]));
    $user->set_userpassword(Sanitization::test_input($_POST["companypassword"]));
    $user->set_usertype(Sanitization::test_input("Admin"));
    DBuser::insert($user);
  } else if($_SERVER["REQUEST_METHOD"] == "GET"){
    //DBcompany::getAll();
  }
  ?>
<html>

<head>
    <title> Login </title>
</head>

<body>
    <?php 
header("location:../View/login.php");
?>


</body>

</html>