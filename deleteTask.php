<?php
include 'db-connection.php';
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    $sql = "DELETE FROM task WHERE task_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
