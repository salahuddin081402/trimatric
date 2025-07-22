<?php
require_once 'db.php';
$role_type_id = intval($_GET['role_type_id'] ?? 0);
$roles = [];
if ($role_type_id) {
    $stmt = $conn->prepare("SELECT role_id, role_name FROM role WHERE role_type_id = ? ORDER BY role_name");
    $stmt->bind_param("i", $role_type_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $roles[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($roles);
?>