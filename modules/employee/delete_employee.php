<?php
require_once(__DIR__ . '/../../config/db.php');
session_start();

header('Content-Type: text/plain');  /* Since, i am sending Plain Text back to employee_list.php by echo */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    $id = intval($_POST['id'] ?? 0);

    if ($csrf_token !== $_SESSION['csrf_token']) {
        http_response_code(403); echo 'csrf_fail'; exit;
    }

    $stmt = $conn->prepare("DELETE FROM employee_info WHERE employee_id=?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        http_response_code(500); echo 'fail';
    }
} else {
    http_response_code(405);
    echo 'method_not_allowed';
}
