<?php
// auth so only the IT/Admin can see the grievances
session_start();
$allowed_users = [
    'admin' => 'admin1'
];

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($allowed_users[$username]) && $allowed_users[$username] === $password) {
            $_SESSION['authenticated'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Invalid username or password";
        }
    }
    echo '<form method="post">
            <label>Username: <input type="text" name="username" required></label><br>
            <label>Password: <input type="password" name="password" required></label><br>
            <input type="submit" value="Login">
          </form>';
    exit;
}

// Load JSON data
$jsonFile = 'data.json';
$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true);

// i found the code snippet online
if (isset($_GET['download']) && $_GET['download'] === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="grievances_data.xls"');

    echo '<table border="1">';
    if (is_array($data)) {
        // Headers
        echo '<tr>';
        foreach (array_keys($data[0]) as $header) {
            echo '<th>' . htmlspecialchars($header) . '</th>';
        }
        echo '</tr>';

        // Rows
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>' . htmlspecialchars($cell) . '</td>';
            }
            echo '</tr>';
        }
    }
    echo '</table>';
    exit;
}

// this one is for thetable
echo '<html><body>';
echo '<h2>Grievances Data</h2>';
echo '<table border="1" id="data-table">';
if (is_array($data)) {
    echo '<tr>';
    foreach (array_keys($data[0]) as $header) {
        echo '<th>' . htmlspecialchars($header) . '</th>';
    }
    echo '</tr>';

    foreach ($data as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . htmlspecialchars($cell) . '</td>';
        }
        echo '</tr>';
    }
}
echo '</table>';

// xlx download button
echo '<form method="get">
        <button type="submit" name="download" value="excel">Download for excel</button>
      </form>';

echo '</body></html>';
?>
