<?php
session_start();
include '../includes/db_connection.php';

$user_id = mysqli_real_escape_string($con, $_GET["id"]);

$sql = "update application SET status = 'approved' WHERE user_id = $user_id;";

$stmt = $con->prepare("update application SET status = 'approved' WHERE user_id = ?;");
$stmt->bind_param("i", $user_id);
$stmt->execute();

    if ($stmt) {
      
      $stmt = $con->prepare("update users SET status = 'approved' WHERE id = ?;");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();

      header("location: ../admin/view-answers.php?id=$user_id&message=success");
    } else {
      echo "Error updating record: " . mysqli_error($con);
    }
?>