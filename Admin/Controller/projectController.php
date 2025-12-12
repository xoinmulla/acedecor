<?php
require_once "../Model/projectModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../Utilities/Helper.php";
//require "../Admin/navbar.php";
require_once "../DB Operations/projectOps.php";
require_once "../Model/customerpaymentmodel.php";
require_once "../DB Operations/customerpaymentOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['projectId'])) {
      error_log($_POST['projectId']);
      $project = new Project();
      $project->set_projectId(Sanitization::test_input($_POST["projectId"]));
      // $project->set_custid(Sanitization::test_input($_POST["custid"]));
      // $project->set_quoteid(Sanitization::test_input($_POST["quoteid"]));
      $project->set_projectstatus(Sanitization::test_input($_POST["projectStatus"]));
      $project->set_progressNote(Sanitization::test_input($_POST["progressNote"])); 
      DBproject::update($project);
    } else if ($_POST["action"] =='delete') {
        DBproject::delete($_POST["id"]);
    } else {
        $project = new Project();

        $project->set_custid(Sanitization::test_input($_POST["projcustomerCode"]));
        $project->set_quoteid(Sanitization::test_input($_POST["projquoteCode"]));
        $project->set_quoteamt(Sanitization::test_input($_POST["projQuoteAmount"]));
        $project->set_custName(Sanitization::test_input($_POST["projCustomerName"]));
        // $project->set_projectstatus(Sanitization::test_input($_POST["projectstatus"]));
        $date = date('my h:i:s a', time());
        $custname=DBproject::selectcustomer($project->get_custid());
        $customername=$custname->get_customerName();
        $words = preg_split("/\s+/",$customername);
          $acronym = "";
          foreach ($words as $w) {
              $acronym .= $w[0];
          }
          $projectCode='AD-PROJ-'.substr((str_replace('-', '', $date)), 0, 5).'-'.$acronym;
          $project->set_projectCode($projectCode);
        DBproject::insert($project);
        
          $admit=new Payment();
          $admit->set_custid(Sanitization::test_input($_POST["projcustomerCode"]));
          $admit->set_totalamt(Sanitization::test_input($_POST["projQuoteAmount"]));
          $admit->set_paidamt(0);
          $admit->set_pendingamt(Sanitization::test_input($_POST["projQuoteAmount"]));
          $admit->set_receivedamt(0);
          $admit->set_paymentplan(0);
          $admit->set_paymentmode(0);
          $admit->set_paymentdescription(0);
          $admit->set_modifiedby(0);
          $admit->set_RTGSno(0);
          if (isset($_POST["duedate"])){
            $admit->set_duedate(0);
          }else{
            $admit->set_duedate(NULL); 
          }
          if (isset($_POST["chequeimg"])) {
              $filetoupload=$_FILES["chequeimg"];
              Helper::fileupload($filetoupload, "../../img/paymentimages/");
          }
          // $filename="". $admit->get_custname().date("Y-m-d").".pdf";
          // $admit->set_paymentreceipt($filename);
          DBpayment::insert($admit);
 
    }
    header("location:../View/projectView.php");
  }
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    DBproject::selectprojects();
    
  }