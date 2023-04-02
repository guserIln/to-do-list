<?php

if(isset($_POST['id'])){
    require '../db_conn.php';

    $id = $_POST['id'];
    $title = $_POST['title'];
    $date1 = $_POST['date1'];
    $imp = $_POST['imp'];
    if(empty($id)){
       echo 0;
    }else {
        $stmt = $conn->prepare("UPDATE todos set title = ? WHERE id=?");
        $res = $stmt->execute([$title, $id]);

        if($res){
            echo 1;
        }else {
            echo 0;
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}