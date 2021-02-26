<?php
include "connectDB.php";
$request = $_POST["value"];
class Post{
public $postTitle = array();
public $postComment = array();
}
$dto = new Post; $temp = array(); $comments = array();
$id = array(); $i=0; $buf = 0; $key="";
$sql="SELECT `commentBody`, `postId` FROM `comments` WHERE `commentBody` LIKE '%$request%'";
$stmt = $pdo->query($sql);
//т.к использование вложенного запроса для получения id вызывает ошибку
//"#1242 - Подзапрос возвращает более одной записи" собираем id в массив
while ($row = $stmt->fetch()){
if($row["postId"] != $buf){$id[] = $row["postId"]; $buf = $row["postId"];}
$comments[] = [$row["postId"],$row["commentBody"]]; 	
}
for($inc=0; $inc<count($id); $inc++){//перебираем все загруженные id
$buf = $id[$inc];	
for($i=0; $i<count($comments); $i++){//ищем все комментарии привязанные к данному id
if($comments[$i][0]==$buf){
$temp[] = $comments[$i][1];//заносим найденные комментарии в временный массив	
}
}
$dto->postComment[] = $temp;//присваиваем временный массив, собираем таблицу
$temp=array();
}
for($i=0; $i<count($id); $i++){
$sql = "SELECT *  FROM `posts` WHERE `postId` = $id[$i]";
$stmt = $pdo->query($sql);
$row = $stmt->fetch();
$dto->postTitle[] = $row["postTitle"];
}
echo json_encode($dto);
?>