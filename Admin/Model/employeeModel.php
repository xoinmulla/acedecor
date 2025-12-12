<?php
class Employee implements JsonSerializable
{
    private $id;
    private $name;
    private $designation;
    private $contact;
    private $email;
    private $address; // ✅ NEW FIELD
    private $doj;
    private $salaryType;
    private $salaryAmount;
    private $notes;
    private $photo;
    private $createdOn;
    private $weekly_off_day;

    // --- Weekly Off Day ---
    public function getWeeklyOffDay() { return $this->weekly_off_day; }
    public function setWeeklyOffDay($weekly_off_day) { $this->weekly_off_day = $weekly_off_day; }

    // --- ID ---
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    // --- Name ---
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    // --- Designation ---
    public function getDesignation() { return $this->designation; }
    public function setDesignation($designation) { $this->designation = $designation; }

    // --- Contact ---
    public function getContact() { return $this->contact; }
    public function setContact($contact) { $this->contact = $contact; }

    // --- Email ---
    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    // --- ✅ Address ---
    public function getAddress() { return $this->address; }
    public function setAddress($address) { $this->address = $address; }

    // --- DOJ ---
    public function getDoj() { return $this->doj; }
    public function setDoj($doj) { $this->doj = $doj; }

    // --- Salary Type ---
    public function getSalaryType() { return $this->salaryType; }
    public function setSalaryType($salaryType) { $this->salaryType = $salaryType; }

    // --- Salary Amount ---
    public function getSalaryAmount() { return $this->salaryAmount; }
    public function setSalaryAmount($salaryAmount) { $this->salaryAmount = $salaryAmount; }

    // --- Notes ---
    public function getNotes() { return $this->notes; }
    public function setNotes($notes) { $this->notes = $notes; }

    // --- Photo ---
    public function getPhoto() { return $this->photo; }
    public function setPhoto($photo) { $this->photo = $photo; }

    // --- Created On ---
    public function getCreatedOn() { return $this->createdOn; }
    public function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'designation' => $this->designation,
            'contact' => $this->contact,
            'email' => $this->email,
            'address' => $this->address, // ✅ NEW FIELD
            'doj' => $this->doj,
            'salaryType' => $this->salaryType,
            'salaryAmount' => $this->salaryAmount,
            'notes' => $this->notes,
            'photo' => $this->photo,
            'createdOn' => $this->createdOn
        ];
    }
}
?>
