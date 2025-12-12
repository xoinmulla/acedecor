<?php
class ExpenseCategory {
    private $id;
    private $name;
    private $type;

    public function __construct($id = null, $name = "", $type = "") {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getType() { return $this->type; }

    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setType($type) { $this->type = $type; }
}
?>
