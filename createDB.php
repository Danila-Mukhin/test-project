<?php
$root="root"; 
$root_password="";
$host = 'localhost';
$pdo = new PDO("mysql:host=$host", $root, $root_password);
$pdo->exec("CREATE DATABASE `myDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci");
$stmt = $pdo->query("CREATE TABLE `myDB`.`posts` ( `userId` INT(5) NOT NULL , `postId` INT(5) NOT NULL , `postTitle` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `postBody` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci");
$stmt = $pdo->query("CREATE TABLE `myDB`.`comments` ( `postId` INT(5) NOT NULL , `commentId` INT(5) NOT NULL , `userName` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `userMail` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `commentBody` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci");
//-------------------------------------------------
function set_data($url, $sql,$flag){
include "connectDB.php";
$data = file_get_contents($url);
$buf = $sql;
if (! empty($data)){//проверяем наличие данных
$data = json_decode($data, true);
//-------------------------------
for($i=0; $i<count($data); $i++){//заполнение БД
$temp = $data[$i];
foreach ($temp as $key=>$value){//формируем запрос
$sql.="'$value', ";	
}
$sql.=")";
$sql = str_replace(", )",")",$sql);//убираем лишние символы созданные циклом
$stmt = $pdo->query($sql);
$sql = $buf;
}
if($flag==1){
$stmt = $pdo->query("ALTER TABLE `posts` ADD PRIMARY KEY(`postId`)");
}else{
$stmt = $pdo->query("ALTER TABLE `comments` ADD PRIMARY KEY(`commentId`)");	
}
}
}
set_data("https://jsonplaceholder.typicode.com/posts","INSERT INTO `posts` (`userId`, `postId`, `postTitle`, `postBody`) VALUES (",1);
set_data("https://jsonplaceholder.typicode.com/comments","INSERT INTO `comments` (`postId`, `commentId`, `userName`, `userMail`, `commentBody`) VALUES (",2);
?>