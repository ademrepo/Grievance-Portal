

<?php
include 'grievance.html';
// require the class
require_once 'grievance.class.php';

// if submited get data and putit in array
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $department = htmlspecialchars($_POST['department']);
    $grievance = htmlspecialchars($_POST['grievance']);

    $newGrievance = new Grievance($name, $department, $grievance);

    // if file exists add new grievance and save
    $file = 'data.json';
    $grievances = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $grievances[] = $newGrievance->toArray();
    file_put_contents($file, json_encode($grievances, JSON_PRETTY_PRINT));

    header("Location: thank.html");
    exit();

}
?>
