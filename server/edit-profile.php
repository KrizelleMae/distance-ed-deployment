<?php

include '../includes/db_connection.php';

$id = mysqli_real_escape_string($con, $_POST['id']);
$new_mobile = mysqli_real_escape_string($con, $_POST['new_mobile']);
$new_email = mysqli_real_escape_string($con, $_POST['new_email']);


$stmt = $con->prepare("update user_details set email = ?, mobile = ? where user_id = ?;");
$stmt->bind_param("ssi", $new_email, $new_mobile, $id);
$stmt->execute();

if($stmt){
    header("location: ../student/profile.php?return=success");
} else {
    header("location: ../student/profile.php?return=error");
}


?>