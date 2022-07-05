<?php
  
     include '../includes/db_connection.php';

     use PHPMailer\PHPMailer\PHPMailer;
     use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

     $user_id = rand(1000000,9999999);
     $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
     $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
     $email = mysqli_real_escape_string($con, $_POST['email']);
     $password = mysqli_real_escape_string($con, $_POST['password']);
     $confirm_pass = mysqli_real_escape_string($con, $_POST['confirm-pass']);


     $hashed = password_hash($password, PASSWORD_DEFAULT);

     $generate_otp = rand(10000,99999);
    
    if($password == $confirm_pass) {
         
         $stmt = $con->prepare("select * from users where id = ? or email = ?;");
         $stmt->bind_param("is", $user_id, $email);
         $stmt->execute();
         $sql = $stmt->get_result();

            if(mysqli_num_rows($sql) > 0){
                header("location: ../signup.php?message=warning");   
            }else {

               $student = mysqli_real_escape_string($con, "student");

              $insert_user = $con->prepare("insert into users(id, email, password, role)
              values(?, ?, ?, ?)");
              $insert_user->bind_param("isss", $user_id, $email, $hashed, $student);
              $insert_user->execute();
              $user = $insert_user->get_result();

              $insert_details = $con->prepare("insert into user_details(user_id, first_name, last_name, email) 
              values(?, ?, ?, ?);");
              $insert_details->bind_param("isss", $user_id, $first_name, $last_name, $email);
              $insert_details->execute();
              $user = $insert_details->get_result();
         
         
              if($insert_user && $insert_details) {
                   include './send_otp.php';
              } else {
                   echo 'failed';
              }
            }
    } else {
          header("location: ../signup.php?message=error");
    }

   


    

    
?>