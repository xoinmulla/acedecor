<?php
class Expense {
    private $id;
    private $category;
    private $amount;
    private $expense_date;
    private $payment_type;
    private $notes;

    // Getters & Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getCategory() { return $this->category; }
    public function setCategory($category) { $this->category = $category; }

    public function getAmount() { return $this->amount; }
    public function setAmount($amount) { $this->amount = $amount; }

    public function getExpenseDate() { return $this->expense_date; }
    public function setExpenseDate($expense_date) { $this->expense_date = $expense_date; }

    public function getPaymentType() { return $this->payment_type; }
    public function setPaymentType($payment_type) { $this->payment_type = $payment_type; }

    public function getNotes() { return $this->notes; }
    public function setNotes($notes) { $this->notes = $notes; }
}
?>
