<?php 
$sName = "localhost";
$uName = "grislandru";
$pass = "";
$db_name = "grislandru";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Signin Template · Bootstrap v5.3</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
     <script src="js/jquery-3.2.1.min.js"></script>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <script language="javascript">
      $(document).ready(function() {
      $('.error').hide();
      $('#submit').click(function(){
        var email = $('#floatingInput').val();
        if (email === ''){
          $('#email').next().show();
          return false;
        }
        if(IsEmail(email)==false){
          $('#invalid_email').show();
          return false;
        }
        $.post("", $("#myform").serialize(),  function(response) {
          $('#myform').fadeOut('slow',function(){
          $('#correct').html(response);
          $('#correct').fadeIn('slow');
       });
     });
    return false;
  });
 });
 function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}
    </script>
     <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="sign-in.css" rel="stylesheet">
  </head>
  <body class="text-center">
 <?php
 if (isset($_SESSION['userid'])) {
      header("Location: tasks/index.php");
 }
    if (isset($_POST['email'])) {
      $email = $_POST['email'];
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $query = "SELECT * FROM users WHERE email='$email'";   //WHERE email='$email'
       $mysqli = new mysqli("localhost", "grislandru", "", "grislandru");
       $result = $mysqli->query($query);
      $user = mysqli_fetch_assoc($result);
      if(!empty($user))
      {
            session_start();
            $_SESSION['userid'] = $user["id"];
            header("Location: tasks/index.php");
      } else {
           $stmt = $conn->prepare("INSERT INTO users(email) VALUE(?)");
           $res = $stmt->execute([$email]);
          if($res){
            session_start();
            $_SESSION['userid'] = $res["id"];
            header("Location: tasks/index.php");
         } 
      }
    } else {
      print_r("Неверный Email!");
    }
  }
 ?>   
<main class="form-signin w-100 m-auto">
  <form action="#" method="POST">
    <h1 class="h3 mb-3 fw-normal">Авторизация</h1>

    <div class="form-floating">
      <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email</label>
    </div>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit" id="submit">Войти</button>
  </form>
</main> 
 <span class="error" id="invalid_email"></span>
  </body>
</html>
