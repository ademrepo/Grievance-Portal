<?php

class Grievance {
    private $name;
    private $department;
    private $grievance;

    //constructor
    public function __construct($name, $department, $grievance) {
        $this->name = $name;
        $this->department = $department;
        $this->grievance = $grievance;
    }
    //convert grievance to array to store in json
    public function toArray() {
        return [
            'name' => $this->name,
            'department' => $this->department,
            'grievance' => $this->grievance,
            'submitted_at' => date('d-m-y H:i:s')
        ];
    }
}
?>
