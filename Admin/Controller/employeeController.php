<?php
require_once("../DB Operations/employeeOps.php");
require_once("../Model/employeeModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add' || $action === 'update') {
        $emp = new Employee();
        $emp->setName($_POST['name']);
        $emp->setDesignation($_POST['designation']);
        $emp->setContact($_POST['contact']);
        $emp->setEmail($_POST['email']);
        $emp->setAddress($_POST['address']); // ✅ NEW FIELD
        $emp->setDoj($_POST['doj']);
        $emp->setSalaryType($_POST['salary_type']);
        $emp->setSalaryAmount($_POST['salary_amount']);
        $emp->setWeeklyOffDay($_POST['weekly_off_day']);
        $emp->setNotes($_POST['notes']);
        $emp->setWorkingHours($_POST['working_hours'] ?? 8);
        // ✅ Hourly handling
        if (isset($_POST['is_hourly']) && $_POST['is_hourly'] == 'on') {
            $emp->setHourlyRate($_POST['hourly_rate'] ?? null);
        } else {
            $emp->setHourlyRate(null);
        }


        // ✅ Photo upload (unchanged)
        $photoPath = $_POST['old_photo'] ?? "";
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "../uploads/employee/";
            if (!file_exists($targetDir))
                mkdir($targetDir, 0777, true);
            $photoName = time() . "_" . basename($_FILES['photo']['name']);
            $targetFile = $targetDir . $photoName;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $photoPath = "uploads/employee/" . $photoName;
            }
        }
        $emp->setPhoto($photoPath);

        if ($action === 'add') {
            DBEmployee::insert($emp);
            header("Location: ../View/employee.php?success=1");
        } else {
            $emp->setId($_POST['id']);
            DBEmployee::update($emp);
            header("Location: ../View/employee.php?updated=1");
        }
    }
}

// Delete logic remains the same
if (isset($_GET['delete'])) {
    require_once("../DB Operations/monthlyReportOps.php");
    $emp_id = $_GET['delete'];
    $dueAmount = DBMonthlyReport::getDueAmountByEmployee($emp_id);

    if ($dueAmount > 0) {
        header("Location: ../View/employee.php?error=due_exists&amount=" . round($dueAmount, 2));
        exit;
    }

    DBEmployee::delete($emp_id);
    header("Location: ../View/employee.php?deleted=1");
    exit;
}
?>