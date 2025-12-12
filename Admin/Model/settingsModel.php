<?php
class Settings {
    private $hours_per_day;
    private $ot_multiplier;
    private $half_day_threshold; // 0 = disabled
    private $weekly_off_paid;    // 0/1
    private $time_presets_json;  // JSON string

    public function getHoursPerDay(){ return $this->hours_per_day; }
    public function setHoursPerDay($v){ $this->hours_per_day = (float)$v; }

    public function getOtMultiplier(){ return $this->ot_multiplier; }
    public function setOtMultiplier($v){ $this->ot_multiplier = (float)$v; }

    public function getHalfDayThreshold(){ return $this->half_day_threshold; }
    public function setHalfDayThreshold($v){
        $this->half_day_threshold = ($v === '' || $v === null) ? 0.0 : (float)$v;
    }

    public function getWeeklyOffPaid(){ return $this->weekly_off_paid; }
    public function setWeeklyOffPaid($v){ $this->weekly_off_paid = (int)$v; }

    public function getTimePresetsJson(){ return $this->time_presets_json; }
    public function setTimePresetsJson($v){ $this->time_presets_json = (string)$v; }
}
