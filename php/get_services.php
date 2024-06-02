<?php
// php/get_services.php

include 'config.php';

$sql = "SELECT * FROM Laboratoires";
$result = $conn->query($sql);

$services = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($services);

$conn->close();
?>
