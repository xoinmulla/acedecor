<?php
require_once dirname(__FILE__, 2) . "/DB Operations/dbconnection.php";
require_once dirname(__FILE__, 2) . "/Model/attendanceReportModel.php";

class DBAttendanceReport
{
    private static function getConn()
    {
        return ConnectDb::getInstance()->getConnection();
    }

    // ================= MONTHLY =================
    public static function getReport($month)
    {
        $conn = self::getConn();
        $employees = $conn->query("SELECT id, name FROM employee")->fetch_all(MYSQLI_ASSOC);
        $reports = [];

        foreach ($employees as $emp) {
            $stmt = $conn->prepare("
                SELECT status, worked_hours, ot_hours
                FROM attendance
                WHERE emp_id=? AND DATE_FORMAT(date,'%Y-%m')=?
            ");
            $stmt->bind_param("is", $emp['id'], $month);
            $stmt->execute();
            $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            $absent = $half = $full = 0;
            $ot_hours = 0;
            $one_five = $two = 0;
            $hourly = 0;        // existing (total worked hours)
            $hourly_only = 0;   // NEW - only hourly status

            foreach ($rows as $r) {
                if ($r['status'] === 'Absent')
                    $absent++;
                elseif ($r['status'] === 'Half-day')
                    $half++;
                elseif ($r['status'] === 'Present')
                    $full++;

                $ot_hours += (float) $r['ot_hours'];
                $hourly += (float) $r['worked_hours']; // keep existing logic

                if ($r['status'] === 'Hourly') {
                    $hourly_only += (float) $r['worked_hours'];
                }

                if ($r['worked_hours'] >= 12 && $r['worked_hours'] < 16)
                    $one_five++;
                if ($r['worked_hours'] >= 16)
                    $two++;
            }

            $rep = new AttendanceReport();
            $rep->emp_id = $emp['id'];
            $rep->name = $emp['name'];
            $rep->absent = $absent;
            $rep->half_days = $half;
            $rep->full_days = $full;
            $rep->ot_hours = $ot_hours;
            $rep->one_point_five_days = $one_five;
            $rep->two_days = $two;
            $rep->hourly_hours = $hourly;
            $rep->hourly_only = $hourly_only;

            $reports[] = $rep;
        }

        return $reports;
    }

    // ================= QUARTERLY =================
    public static function getQuarterlyReport($year, $quarter)
    {
        $start = ($quarter - 1) * 3 + 1;
        $end = $start + 2;
        $final = [];

        for ($m = $start; $m <= $end; $m++) {
            $month = sprintf("%04d-%02d", $year, $m);
            foreach (self::getReport($month) as $r) {
                $id = $r->emp_id;
                if (!isset($final[$id]))
                    $final[$id] = $r;
                else {
                    $final[$id]->absent += $r->absent;
                    $final[$id]->half_days += $r->half_days;
                    $final[$id]->full_days += $r->full_days;
                    $final[$id]->ot_hours += $r->ot_hours;
                    $final[$id]->one_point_five_days += $r->one_point_five_days;
                    $final[$id]->two_days += $r->two_days;
                    $final[$id]->hourly_hours += $r->hourly_hours;
                }
            }
        }

        return array_values($final);
    }

    // ================= YEARLY =================
    public static function getYearlyReport($year)
    {
        $final = [];
        for ($m = 1; $m <= 12; $m++) {
            $month = sprintf("%04d-%02d", $year, $m);
            foreach (self::getReport($month) as $r) {
                $id = $r->emp_id;
                if (!isset($final[$id]))
                    $final[$id] = $r;
                else {
                    $final[$id]->absent += $r->absent;
                    $final[$id]->half_days += $r->half_days;
                    $final[$id]->full_days += $r->full_days;
                    $final[$id]->ot_hours += $r->ot_hours;
                    $final[$id]->one_point_five_days += $r->one_point_five_days;
                    $final[$id]->two_days += $r->two_days;
                    $final[$id]->hourly_hours += $r->hourly_hours;
                }
            }
        }

        return array_values($final);
    }
}
