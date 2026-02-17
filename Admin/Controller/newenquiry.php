<?php
require "../Model/enquirymodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/enquiryOps.php";

// ==================== FETCH SINGLE ENQUIRY (for Edit Modal) ====================
if (isset($_GET['action']) && $_GET['action'] == 'fetch' && isset($_GET['id'])) {
    header('Content-Type: application/json');

    $id = (int) $_GET['id'];
    $enq = DBenq::readById($id);

    if ($enq) {
        echo json_encode([
            "enqid" => $enq->get_id(),
            "name" => $enq->get_enqname(),
            "email" => $enq->get_enqemail(),
            "phone" => $enq->get_enqphone(),
            "address" => $enq->get_enqaddress(),
            "city" => $enq->get_enqcity(),
            "state" => $enq->getEnq_State(),
            "country" => $enq->getEnq_Country(),
            "created_date" => $enq->getCreatedDate(),
            "interests" => $enq->get_interestList()
        ]);
    } else {
        echo json_encode(["error" => "No record found"]);
    }
    exit();
}

// ==================== DELETE ENQUIRY ====================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    DBenq::delete($_POST['id']);
    exit();
}

// ==================== UPDATE ENQUIRY ====================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update') {
    $enq = new Enquiry();
    $enq->set_id($_POST["enqid"]);
    $enq->set_enqname(Sanitization::test_input($_POST["name"]));
    $enq->set_enqemail(Sanitization::test_input($_POST["email"]));
    $enq->set_enqphone(Sanitization::test_input($_POST["phone"]));
    $enq->set_enqaddress(Sanitization::test_input($_POST["address"]));
    $enq->set_enqcity(Sanitization::test_input($_POST["city"]));
    $enq->setEnq_State(Sanitization::test_input($_POST["SelectState"]));
    $enq->setEnq_Country(Sanitization::test_input($_POST["SelectCountry"]));

    if (!empty($_POST['interest_list'])) {
        $enq->set_interestList($_POST['interest_list']);
    }

    DBenq::update($enq);
    header("Location: ../View/enquiry.php?updated=1");
    exit();
}

// ==================== INSERT ENQUIRY (Default) ====================
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    $enq = new Enquiry();
    $enq->set_enqname(Sanitization::test_input($_POST["name"]));
    $enq->set_enqemail(Sanitization::test_input($_POST["email"]));
    $enq->set_enqphone(Sanitization::test_input($_POST["phone"]));
    $enq->set_enqaddress(Sanitization::test_input($_POST["address"]));
    $enq->set_enqcity(Sanitization::test_input($_POST["city"]));
    $enq->setEnq_State(Sanitization::test_input($_POST["SelectState"]));
    $enq->setEnq_Country(Sanitization::test_input($_POST["SelectCountry"]));

    if (!empty($_POST['interest_list'])) {
        $enq->set_interestList($_POST['interest_list']);
    }

    DBenq::insert($enq);

    if (isset($_POST['isAdmin'])) {
        header("Location: ../View/enquiry.php");
    } elseif (isset($_POST['front'])) {
        header("Location: ../../views/contact.php?success=1");
    }
    exit();
}
