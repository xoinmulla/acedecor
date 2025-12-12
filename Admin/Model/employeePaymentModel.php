<?php
class EmployeePayment {
    private $id;
    private $emp_id;
    private $payment_date;
    private $amount;
    private $payment_type;
    private $status;
    private $remarks;

    // Getters & Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getEmpId() { return $this->emp_id; }
    public function setEmpId($emp_id) { $this->emp_id = $emp_id; }

    public function getPaymentDate() { return $this->payment_date; }
    public function setPaymentDate($payment_date) { $this->payment_date = $payment_date; }

    public function getAmount() { return $this->amount; }
    public function setAmount($amount) { $this->amount = $amount; }

    public function getPaymentType() { return $this->payment_type; }
    public function setPaymentType($payment_type) { $this->payment_type = $payment_type; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getRemarks() { return $this->remarks; }
    public function setRemarks($remarks) { $this->remarks = $remarks; }
}
?>
