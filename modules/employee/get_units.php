<?php
require_once(__DIR__ . '/../../config/db.php');
$department_id = intval($_POST['department_id'] ?? 0);
$units = [];
if ($department_id > 0) {
    $stmt = $conn->prepare("SELECT unit_id, unit_name FROM unit WHERE department_id=? ORDER BY unit_name");
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $units = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
header('Content-Type: application/json');
echo json_encode($units);
