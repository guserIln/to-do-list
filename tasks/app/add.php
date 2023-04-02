<?php
session_start();
if (isset($_POST['text'])  && isset($_POST['date'])){
    require '../db_conn.php';

    $userid = $_SESSION['userid'];

    $text = $_POST['text'];
    $date = $_POST['date'];
    $imp = 1;

    if (isset($_POST['important'])) {
       $imp = 1;
    } else {
        $imp = 0;
    }

    if(empty($text)){
        header("Location: ../index.php?mess=error");
    }else {
        $stmt = $conn->prepare("INSERT INTO todos(title, date1, important, checked, user_id) VALUE(?,?,?,?,?)");
        $res = $stmt->execute([$text, $date, $imp, 0, $userid]);

        if($res){
            header("Location: ../index.php?mess=success"); 
        }else {
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}