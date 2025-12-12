<?php
require_once dirname(__FILE__, 2) . "/DB Operations/dbconnection.php";
require_once dirname(__FILE__, 2) . "/Model/settingsModel.php";

class DBSettings {
    private static function getConn() {
        return ConnectDb::getInstance()->getConnection();
    }

    public static function read() {
        $conn = self::getConn();
        $rs = $conn->query("SELECT * FROM settings LIMIT 1");
        $row = $rs ? $rs->fetch_assoc() : null;

        // Ensure defaults if row missing or fields empty
        if (!$row) {
            $row = [
                'hours_per_day'      => 8.0,
                'ot_multiplier'      => 1.5,
                'half_day_threshold' => 4.0,
                'weekly_off_paid'    => 0,
                'time_presets'       => json_encode([
                    ["desc"=>"2 Days","hours"=>16,"type"=>"preset"],
                    ["desc"=>"1.5 Day","hours"=>12,"type"=>"preset"],
                    ["desc"=>"Present","hours"=>8,"type"=>"preset"],
                    ["desc"=>"Half Day","hours"=>4,"type"=>"preset"],
                    ["desc"=>"OT","hours"=>"Present+OT","type"=>"input"],
                ])
            ];
            // if your table always has an id=1 row, you can insert here if needed
            // $stmt = $conn->prepare("INSERT INTO settings (id, hours_per_day, ot_multiplier, half_day_threshold, weekly_off_paid, time_presets) VALUES (1,?,?,?,?,?)");
            // $stmt->bind_param("dddis", $row['hours_per_day'], $row['ot_multiplier'], $row['half_day_threshold'], $row['weekly_off_paid'], $row['time_presets']);
            // $stmt->execute();
        } else {
            // backfill missing time_presets with sane defaults
            if (empty($row['time_presets'])) {
                $row['time_presets'] = json_encode([
                    ["desc"=>"2 Days","hours"=>16,"type"=>"preset"],
                    ["desc"=>"1.5 Day","hours"=>12,"type"=>"preset"],
                    ["desc"=>"Present","hours"=>8,"type"=>"preset"],
                    ["desc"=>"Half Day","hours"=>4,"type"=>"preset"],
                    ["desc"=>"OT","hours"=>"Present+OT","type"=>"input"],
                ]);
            }
        }
        return $row;
    }

    public static function update(Settings $s) {
        $conn = self::getConn();

        $hours_per_day       = $s->getHoursPerDay();
        $ot_multiplier       = $s->getOtMultiplier();
        $half_day_threshold  = $s->getHalfDayThreshold();
        $weekly_off_paid     = $s->getWeeklyOffPaid();
        $time_presets        = $s->getTimePresetsJson();

        $stmt = $conn->prepare("
            UPDATE settings SET
                hours_per_day=?,
                ot_multiplier=?,
                half_day_threshold=?,
                weekly_off_paid=?,
                time_presets=?
            WHERE id=1
        ");
        // types: d d d i s
        $stmt->bind_param("dddis",
            $hours_per_day,
            $ot_multiplier,
            $half_day_threshold,
            $weekly_off_paid,
            $time_presets
        );
        return $stmt->execute();
    }
}
