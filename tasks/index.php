<?php 
require 'db_conn.php';
session_start();

$userid = $_SESSION['userid'];
if ($userid === null) {
   header("Location: ../index.php");
}
$todos = $conn->query("SELECT * FROM todos WHERE user_id=$userid ORDER BY date1 DESC");

$data = range(1, $todos->rowCount());
$per_page = 5;

$total = count($data);
$count_pages = ceil($total / $per_page);
$page = $_GET['page'] ?? 1;

$page = (int) $page;
if (!$page || $page < 1) {
    $page = 1;
 }
if ($page > $count_pages) {
    $page = $count_page;
}

$start = ($page - 1) * $per_page;
 //print_r(array_slice($data, $start, $per_page));

 if (isset($_GET['logout'])) {
        unset($_SESSION['userid']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Тестовое задание</title>
<link rel="stylesheet" href="css/style.css"> 
</head>
<body>
 
    <div class="main-section">
       <div class="add-section">    
          <form class="form1" action="app/add.php" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <p>Текст</p>
                <input type="text" 
                     name="text"  value=""
                     style="border-color: #ff6666"
                     placeholder="Обязательное поле" />
                <br>
                <p align="center">Дата</p>
                <input type="date" 
                     name="date"  value=""
                     style="border-color: #ff6666"
                     placeholder="Обязательное поле" />
                <br>
                <p align="center">Важное</p>
                <input type="checkbox" 
                     name="important"  value=""
                     style="border-color: #ff6666"
                     placeholder="" />
              <button type="submit" id="send">Добавить</span></button>
             <?php } else { ?>
               <p align="center">Текст</p>
              <input type="text" 
                     name="text" value=""
                     placeholder="" />
                <br>
                <p align="center">Дата</p>
                <br>
                <input type="date" 
                     name="date"  value=""
                     placeholder="Обязательное поле" />
                 <p align="center">Важное</p>
                <input type="checkbox" 
                     name="important"  value="1"
                     placeholder="" />
              <button type="submit" id="send">Добавить</span></button>
             <?php } ?>
          </form>
          <div id="message"></div>
       </div>
       <?php 
          $userid = $_SESSION['userid'];
          if ($userid === null) {
            header("Location: ../index.php");
          }
 $todos = $conn->query("SELECT * FROM todos WHERE user_id=$userid ORDER BY date1 DESC LIMIT $start, $per_page");
       ?>
       <div class="show-todo-section">
            <?php if($todos->rowCount() <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>" title="<?php echo $todo['title']; ?>" date1="<?php echo $todo['date1']; ?>"
                          class="remove-to-do">Удалить</span>
                    <span id="<?php echo $todo['id']; ?>"  title="<?php echo $todo['title'];?>"  date1="<?php echo $todo['date1']; ?>"
                          class="edit-to-do">Редактировать</span>
                      <span id="<?php echo $todo['id']; ?>"  title="<?php echo $todo['title'];?>"  date1="<?php echo $todo['date1']; ?>"
                          class="check-box">Выполнено</span>
                   
                   
                     <input type="text" name="edit-title" class="edit-title" style="display: none" value="<?php echo $todo['title']; ?>">
                    <?php if($todo['checked']){ ?> 
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               checked />
                        <label for="checkbox">
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>   
                    <?php }else { ?>
                        <input type="checkbox"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               class="check-box" />

    <?php if ($todo['important'] === '1') { 
        echo '<h2><b>'.$todo['title'].'</b></h2>'; 
    } 
    else { 
        echo '<small>'.$todo['title'].'</small>'; 
    }; ?>

                    <?php } ?>
                    <br>
                    <small>Дата: <?php echo $todo['date1'] ?></small> 
                </div>
            <?php } ?>

             <?php echo '<p align=center>';     
  for ($i = 1; $i <= $count_pages; $i++) {
     echo "<a href='?page={$i}'>$i</a>";
   }
   echo '</p>';
?>
       </div>
            <a  href="index.php?logout=1">Выйти</a>
    </div>
    
    <script src="js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                var del=confirm("Вы хотите удалить запись?");
                if (del === true) {
                    $.post("app/remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                    );
                }
            });

             $('.edit-to-do').click(function(){
                const id = $(this).attr('id');
                const title = $('.edit-title').val();
                const date1 = $('.edit-date1').val();
                const style1 = $('.edit-title').attr('style');
                if (style1 === 'display: block;') {
                    $.post("app/edit.php", 
                      {
                          id: id,
                          title: title,
                          date1: date1
                      },
                      (data)  => {
                        if (data){
                            $(this).parent().show();
                            location.reload();
                        }
                      }
                  );

                }
                $(".edit-title").css("display", "block");
                $(".edit-date1").css("display", "block");
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>
</body>
</html>