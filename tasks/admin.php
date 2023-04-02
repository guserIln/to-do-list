<?php 
require 'db_conn.php';
session_start();

$userid = $_SESSION['userid'];
if ($userid === null) {
   header("Location: ../index.php");
}
$todos = $conn->query("SELECT u.email as mail, count(t.id) as c  FROM users u LEFT JOIN todos t ON u.id = t.user_id GROUP BY u.email");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Тестовое задание 2</title>
<link rel="stylesheet" href="css/style.css"> 
 <link href="../sign-in.css" rel="stylesheet">


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

 
</head>

<body class="center">
<?php
    if (isset($_GET['logout'])) {
        unset($_SESSION['userid']);
    }
    if (isset($_POST['pass'])) {
        $pass = $_POST['pass'];
        if ($pass === 'admin') {
            $_SESSION['userid'] = 9;
        } else {
      print_r("Неверный пароль!");
       } 
    }
 ?>   
    <?php 
    if (isset($_SESSION['userid']) && $_SESSION['userid'] === 9) { ?>
    <div class="main-section">
       <div class="show-todo-section">
              <?php if($todos->rowCount() <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <small>Email: <?php echo $todo['mail'] ?></small> 
                    <small>Количество: <?php echo $todo['c'] ?></small> 
                </div>
            <?php } ?>
       </div>
       <a href="admin.php?logout=1">Выйти</a>
    </div>
     <?php } ?>
    
  <?php if ((!isset($_SESSION['userid'])) || (isset($_SESSION['userid']) && ($_SESSION['userid'] !== 9))) { ?>
   <main class="form-signin w-100 m-auto"> 
     <form action="#" method="POST">
    <h1 class="h3 mb-3 fw-normal">Авторизация</h1>

    <div class="form-floating">
      <input type="password" class="form-control" name="pass" id="floatingInput" placeholder="">
      <label for="floatingInput"></label>
    </div>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Вход</button>
  </form>
</main>
<?php
  }
?>

    <script src="js/jquery-3.2.1.min.js"></script>

   
</body>
</html>