<?php 
session_start();
include '../includes/db_connection.php';

    $current_pass = mysqli_real_escape_string($con, $_POST['current-pass']);
    $new_pass = mysqli_real_escape_string($con, $_POST['new-pass']);
    $confirm_pass = mysqli_real_escape_string($con, $_POST['confirm-pass']);

    $stmt = $con->prepare("select * from users where role = 'admin' limit 1;");
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_array($result)){

            if(password_verify($current_pass, $row['password'])){

                $hashed = password_hash($new_pass, PASSWORD_DEFAULT);

                $stmt1 = $con->prepare("update users set password = ? where role = 'admin'");
                $stmt1->bind_param("s", $hashed);
                $stmt1->execute();
        
                if($stmt1) {
                    header("location:../admin/settings.php?return=success");  
                }
            } else {
                header("location:../admin/settings.php?return=warning");  
            }

        }

    }else {
        header("location:../admin/settings.php?return=error");   
    }
   
?>