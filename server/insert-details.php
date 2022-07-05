<?php 
session_start();
include '../includes/db_connection.php';

    $user_id = $_SESSION['id'];

    $birthdate = mysqli_real_escape_string($con, date( $_POST['birthdate']));
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $civil = mysqli_real_escape_string($con, $_POST['civil']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $tel = mysqli_real_escape_string($con, $_POST['tel']);
    $house = mysqli_real_escape_string($con, $_POST['house']);
    $street = mysqli_real_escape_string($con, $_POST['street']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $zip = mysqli_real_escape_string($con, $_POST['zip']);
    $university = mysqli_real_escape_string($con, $_POST['university']);
    $degree = mysqli_real_escape_string($con, $_POST['degree']);
    $drive = mysqli_real_escape_string($con, $_POST['drive']);


    // UPDATE USER DETAILS
    $stmt = $con->prepare("update user_details set 
    birthdate = ?, 
    gender = ?, 
    civil_stat = ?, 
    email = ?, 
    mobile = ?, 
    tel = ?, 
    house = ?, 
    street = ?, 
    city = ?, 
    state = ?, 
    country = ?, 
    zip = ?, 
    university = ?, 
    degree = ?, 
    drive = ? 
    where user_id = ?;");

    $stmt->bind_param("sssssssssssssssi", $birthdate, $gender, $civil, $email, $mobile, $tel, $house, $street, $city, $state, $country, $zip, $university, $degree, $drive, $user_id);
    $stmt->execute();

    if($stmt){

        $stmt1 = $con->prepare("update users set status = 'application' where id = ?;");
        $stmt1->bind_param("i", $user_id);  
        $stmt1->execute();

        if($stmt1){
             echo '<script>alert("Success")</script>';
            header("location:../student/index.php");
        }
       
    }else{
        echo "Failed: " . mysqli_connect_error();
    }


    

    
?>