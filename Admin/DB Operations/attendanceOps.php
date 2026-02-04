<?php
require_once dirname(__FILE__, 2) . "/DB Operations/dbconnection.php";
require_once dirname(__FILE__, 2) . "/Model/attendanceModel.php";

class DBAttendance
{
    private static function getConn()
    {
        return ConnectDb::getInstance()->getConnection();
    }

    // ✅ INSERT Attendance
    public static function insert(Attendance $att)
    {
        $conn = self::getConn();
        $emp_id = $att->getEmpId();
        $date = $att->getDate();
        $status = $att->getStatus();
        $in_time = $att->getInTime();
        $out_time = $att->getOutTime();
        $remarks = $att->getRemarks();

        // --- OT CALCULATION ---
        $worked = 0;
        $ot = 0;
        $ot_pay = 0;

        if ($in_time && $out_time) {

            // Calculate worked hours for ALL (Present + Hourly)
            $worked = round((strtotime($out_time) - strtotime($in_time)) / 3600, 2);

            // Fetch employee details
            $empQ = $conn->prepare("
        SELECT salary_type, salary_amount, hourly_rate, working_hours 
        FROM employee 
        WHERE id=?
    ");
            $empQ->bind_param("i", $emp_id);
            $empQ->execute();
            $emp = $empQ->get_result()->fetch_assoc();

            if ($emp) {

                $isHourly = !empty($emp['hourly_rate']) && $emp['hourly_rate'] > 0;

                // ✅ HOURLY EMPLOYEE
                if ($status === 'Hourly' && $isHourly) {
                    $ot = 0;
                    $ot_pay = 0;
                }

                // ✅ NORMAL EMPLOYEE (Present)
                elseif ($status === 'Present') {
                    $working_hours = (float) $emp['working_hours'];
                    $ot = max(0, $worked - $working_hours);

                    // Hourly rate resolve
                    if ($isHourly) {
                        $hourly = $emp['hourly_rate'];
                    } else {
                        if ($emp['salary_type'] === 'Daily') {
                            $hourly = $emp['salary_amount'] / $working_hours;
                        } elseif ($emp['salary_type'] === 'Weekly') {
                            $hourly = $emp['salary_amount'] / (6 * $working_hours);
                        } elseif ($emp['salary_type'] === 'Monthly') {
                            $hourly = $emp['salary_amount'] / (26 * $working_hours);
                        } else {
                            $hourly = 0;
                        }
                    }

                    // OT multiplier
                    $settingsQ = $conn->query("SELECT ot_multiplier FROM settings LIMIT 1");
                    $settings = $settingsQ->fetch_assoc();
                    $multiplier = $settings ? (float) $settings['ot_multiplier'] : 1.5;

                    $ot_pay = round($ot * $hourly * $multiplier, 2);
                }
            }
        }


        $stmt = $conn->prepare("INSERT INTO attendance 
            (emp_id, date, status, in_time, out_time, remarks, worked_hours, ot_hours, ot_pay)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssddd", $emp_id, $date, $status, $in_time, $out_time, $remarks, $worked, $ot, $ot_pay);
        return $stmt->execute();
    }

    // ✅ UPDATE Attendance
    public static function update(Attendance $att)
    {
        $conn = self::getConn();
        $id = $att->getId();
        $emp_id = $att->getEmpId();
        $date = $att->getDate();
        $status = $att->getStatus();
        $in_time = $att->getInTime();
        $out_time = $att->getOutTime();
        $remarks = $att->getRemarks();

        // --- OT CALCULATION ---
        $worked = 0;
        $ot = 0;
        $ot_pay = 0;

        if ($in_time && $out_time) {

            // Calculate worked hours for ALL (Present + Hourly)
            $worked = round((strtotime($out_time) - strtotime($in_time)) / 3600, 2);

            // Fetch employee details
            $empQ = $conn->prepare("
        SELECT salary_type, salary_amount, hourly_rate, working_hours 
        FROM employee 
        WHERE id=?
    ");
            $empQ->bind_param("i", $emp_id);
            $empQ->execute();
            $emp = $empQ->get_result()->fetch_assoc();

            if ($emp) {

                $isHourly = !empty($emp['hourly_rate']) && $emp['hourly_rate'] > 0;

                // ✅ HOURLY EMPLOYEE
                if ($status === 'Hourly' && $isHourly) {
                    $ot = 0;
                    $ot_pay = 0;
                }

                // ✅ NORMAL EMPLOYEE (Present)
                elseif ($status === 'Present') {
                    $working_hours = (float) $emp['working_hours'];
                    $ot = max(0, $worked - $working_hours);

                    // Hourly rate resolve
                    if ($isHourly) {
                        $hourly = $emp['hourly_rate'];
                    } else {
                        if ($emp['salary_type'] === 'Daily') {
                            $hourly = $emp['salary_amount'] / $working_hours;
                        } elseif ($emp['salary_type'] === 'Weekly') {
                            $hourly = $emp['salary_amount'] / (6 * $working_hours);
                        } elseif ($emp['salary_type'] === 'Monthly') {
                            $hourly = $emp['salary_amount'] / (26 * $working_hours);
                        } else {
                            $hourly = 0;
                        }
                    }

                    // OT multiplier
                    $settingsQ = $conn->query("SELECT ot_multiplier FROM settings LIMIT 1");
                    $settings = $settingsQ->fetch_assoc();
                    $multiplier = $settings ? (float) $settings['ot_multiplier'] : 1.5;

                    $ot_pay = round($ot * $hourly * $multiplier, 2);
                }
            }
        }


        $stmt = $conn->prepare("UPDATE attendance SET 
            emp_id=?, 
            date=?, 
            status=?, 
            in_time=?, 
            out_time=?, 
            remarks=?, 
            worked_hours=?, 
            ot_hours=?, 
            ot_pay=? 
            WHERE id=?");

        $stmt->bind_param("isssssdddi", $emp_id, $date, $status, $in_time, $out_time, $remarks, $worked, $ot, $ot_pay, $id);
        return $stmt->execute();
    }

    // ✅ DELETE Attendance
    public static function delete($id)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("DELETE FROM attendance WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ✅ READ ALL Attendance
    public static function readAll()
    {
        $conn = self::getConn();
        $result = $conn->query("SELECT a.*, e.name AS emp_name 
                                FROM attendance a 
                                JOIN employee e ON a.emp_id = e.id 
                                ORDER BY a.date DESC");
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // ✅ READ Attendance by ID
    public static function readById($id)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("SELECT * FROM attendance WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ✅ DUPLICATE CHECK (NEW - Safe Addition)
    public static function isDuplicate($emp_id, $date, $excludeId = null)
    {
        $conn = self::getConn();
        $query = "SELECT COUNT(*) as count FROM attendance WHERE emp_id=? AND date=?";
        if ($excludeId) {
            $query .= " AND id != ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isi", $emp_id, $date, $excludeId);
        } else {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("is", $emp_id, $date);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }
}
?>