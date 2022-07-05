<?php 
session_start();
include '../includes/db_connection.php';

    $user_id = $_SESSION['id'];
    $answer1 = mysqli_real_escape_string($con, $_POST['answer1']);
    $answer2 = mysqli_real_escape_string($con, $_POST['answer2']);
    $answer3 = mysqli_real_escape_string($con, $_POST['answer3']);
    $answer4 = mysqli_real_escape_string($con, $_POST['answer4']);
    $answer5 = mysqli_real_escape_string($con, $_POST['answer5']);
    $program = $_SESSION['program'];
    $date = date('Y-m-d');

    $stmt = $con->prepare("insert into answers(answer1, answer2, answer3, answer4, answer5, user_id) values (?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("sssssi", $answer1, $answer2, $answer3, $answer4, $answer5, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($stmt){
        
        $date_approved =  mysqli_real_escape_string($con, '------');
        
        $sql = $con->prepare("insert into application(program, date_applied, date_approved, user_id) values (?, ?, ?, ?);");
        $sql->bind_param("sssi", $program, $date, $date_approved, $user_id);
        $sql->execute();
        $query = $sql->get_result();
    
        if($sql){

            $stmt = $con->prepare("update users set status = 'pending' where id = ?;");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            
            header("location:../student/index.php?message=success");
        }
    }else{
        echo "Failed: " . mysqli_connect_error();
    }

?>