<?php
header("Content-Type: application/json");
include "config.php"; // koneksi DB project-streaming

$query = mysqli_query($conn, "SELECT * FROM admin");
$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);