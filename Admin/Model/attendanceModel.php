<?php
class Attendance {
    private $id;
    private $emp_id;
    private $date;
    private $status;
    private $in_time;
    private $out_time;
    private $remarks;
    private $worked_hours;
    private $ot_hours;
    private $ot_pay;

    public function getWorkedHours() { return $this->worked_hours; }
    public function setWorkedHours($v) { $this->worked_hours = $v; }

    public function getOtHours() { return $this->ot_hours; }
    public function setOtHours($v) { $this->ot_hours = $v; }

    public function getOtPay() { return $this->ot_pay; }
    public function setOtPay($v) { $this->ot_pay = $v; }

    // Getters and setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getEmpId() { return $this->emp_id; }
    public function setEmpId($emp_id) { $this->emp_id = $emp_id; }

    public function getDate() { return $this->date; }
    public function setDate($date) { $this->date = $date; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getInTime() { return $this->in_time; }
    public function setInTime($in_time) { $this->in_time = $in_time; }

    public function getOutTime() { return $this->out_time; }
    public function setOutTime($out_time) { $this->out_time = $out_time; }

    public function getRemarks() { return $this->remarks; }
    public function setRemarks($remarks) { $this->remarks = $remarks; }
}
?>
