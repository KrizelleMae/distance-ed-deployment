<?php
     session_start();
     include '../includes/db_connection.php';

     $otp_input = mysqli_real_escape_string($con, $_POST['otp']);
     $user_id = $_SESSION['temp_id'];


      
    $stmt = $con->prepare("select * from otp where user_id = ? limit 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

     if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)){
               if($otp_input == $row['otp']){

                    $stmt1 = $con->prepare("update users set verified = 1 where id = ?;");
                    $stmt1->bind_param("i", $user_id);
                    $stmt1->execute();

                    $stmt2 = $con->prepare("update otp set expired = 1 where user_id = ?;");
                    $stmt2->bind_param("i", $user_id);
                    $stmt2->execute();
                
                    if($stmt1 && $stmt2){
                         header("location: ../");
                         unset($_SESSION["temp_id"]);
                    } else {
                         echo 'Error';
                    }
               } else {
                    header("location: ../otp.php?message=error");
               }
          }
     }else{
          echo 'An OTP was not sent to your email.';
     }


?>