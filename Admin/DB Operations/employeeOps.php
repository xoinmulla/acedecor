<?php
require_once dirname(__FILE__, 2) . "/DB Operations/dbconnection.php";
require_once dirname(__FILE__, 2) . "/Model/employeeModel.php";

class DBEmployee
{
    private static function getConn()
    {
        $db = ConnectDb::getInstance();
        return $db->getConnection();
    }

    // ✅ Insert Employee (now includes Address)
    public static function insert(Employee $e)
    {
        $conn = self::getConn();

        $name = $e->getName();
        $designation = $e->getDesignation();
        $contact = $e->getContact();
        $email = $e->getEmail();
        $address = $e->getAddress();
        $doj = $e->getDoj();
        $salary_type = $e->getSalaryType();
        $salary_amount = $e->getSalaryAmount();
        $notes = $e->getNotes();
        $photo = $e->getPhoto();
        $weekly_off_day = $e->getWeeklyOffDay();

        $stmt = $conn->prepare("INSERT INTO employee 
            (name, designation, contact, email, address, doj, salary_type, salary_amount, notes, photo, weekly_off_day)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssssssdsss",
            $name,
            $designation,
            $contact,
            $email,
            $address,
            $doj,
            $salary_type,
            $salary_amount,
            $notes,
            $photo,
            $weekly_off_day
        );

        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // ✅ Update Employee (with Address)
    public static function update(Employee $e)
    {
        $conn = self::getConn();

        $id = $e->getId();
        $name = $e->getName();
        $designation = $e->getDesignation();
        $contact = $e->getContact();
        $email = $e->getEmail();
        $address = $e->getAddress();
        $doj = $e->getDoj();
        $salary_type = $e->getSalaryType();
        $salary_amount = $e->getSalaryAmount();
        $notes = $e->getNotes();
        $photo = $e->getPhoto();
        $weekly_off_day = $e->getWeeklyOffDay();

        $stmt = $conn->prepare("UPDATE employee SET 
            name=?, 
            designation=?, 
            contact=?, 
            email=?, 
            address=?, 
            doj=?, 
            salary_type=?, 
            salary_amount=?, 
            notes=?, 
            photo=?, 
            weekly_off_day=? 
            WHERE id=?");

        $stmt->bind_param(
            "sssssssdsssi",
            $name,
            $designation,
            $contact,
            $email,
            $address,
            $doj,
            $salary_type,
            $salary_amount,
            $notes,
            $photo,
            $weekly_off_day,
            $id
        );

        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // ✅ Delete Employee
    public static function delete($id)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("DELETE FROM employee WHERE id=?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // ✅ Read All
    public static function readAll()
    {
        $conn = self::getConn();
        $sql = "SELECT * FROM employee ORDER BY id DESC";
        $result = $conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // ✅ Read by ID
    public static function readById($id)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("SELECT * FROM employee WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $data = $res->fetch_assoc();
        $stmt->close();
        return $data;
    }
}
?>
