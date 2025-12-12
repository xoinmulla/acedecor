<?php
require_once("../DB Operations/settingsOps.php");
require_once("../Model/settingsModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = new Settings();
    $s->setHoursPerDay($_POST['hours_per_day'] ?? 8);
    $s->setOtMultiplier($_POST['ot_multiplier'] ?? 1.5);
    $s->setHalfDayThreshold($_POST['half_day_threshold'] ?? 0);
    $s->setWeeklyOffPaid(isset($_POST['weekly_off_paid']) ? 1 : 0);
    $s->setTimePresetsJson($_POST['time_presets_json'] ?? '[]');

    DBSettings::update($s);
    header("Location: ../View/settings.php?saved=1");
    exit;
}
