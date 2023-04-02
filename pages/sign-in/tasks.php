<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <title>Starter Template · Bootstrap v5.3</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/starter-template/">
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <link href="starter-template.css" rel="stylesheet">
  </head>
  <body>
 <script type="text/javascript">
$(document).on("click", "#send", function(){
         var text = $(".text").val();
         var date = $(".date").val();
          var msg = $('#sendform form').serialize();
          alert(msg);
        $.ajax({
            type: "GET", // метод отправки
            url: "handler.php", // путь к обработчику
            dаta: msg,
            success: function(data){
                console.log(data);
                $("#message").html(data); 
            },
            error: function(data){
                console.log(data); // выводим ошибку в консоль
            }
        });
        return false;
    })
</script>
    <script type="text/javascript">
 $(document).ready(function(){
 //alert(jQuery.fn.jquery);
 });
 </script>
<div id="sendform" class="col-lg-8 mx-auto p-4 py-md-5">
  <header>  
     <form id="form1"  method="GET">
      <span class="fs-4">Добавить задачу</span>
      <br><br>
      Текст<br>
      <input type="text" class="text" name="text" value="">
      <br><br>
      Дата<br>
      <input type="date" class="date" name="date" value="">
      <br><br>
      Важное<br>
      <input type="checkbox" class="imp" name="imp" value="">
      <br><br>
      <input type="submit" id="send" value="Добавить">
       <hr class="col-3 col-md-2 mb-5">
     </form>
  </header>
<br>
<div id="message"></div>

  <main>
    <h1>Список</h1>
    
   <?php
     $link = mysqli_connect("localhost", "grislandru", "33VCStMMR#K7Y8T8");
     mysqli_select_db($link, "grislandru");
     $sql = "SELECT text, date FROM records";
     $result = mysqli_query($link, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
     foreach ($rows as $row) { ?>
   <p class="fs-5 col-md-8"><?=$row["text"];?></p>
     <p class="fs-5 col-md-8"><?=$row["date"];?></p>
    <? }   ?>

    <hr class="col-3 col-md-2 mb-5">
  </main>



</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      
  </body>
</html>
