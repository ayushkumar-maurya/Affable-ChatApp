<?php
include "connection.php";

$user = $_POST['user'];
$pwd = $_POST['pwd'];

$stmt = $conn->prepare("SELECT userid FROM users WHERE username = :user AND password = :pwd");
$stmt->execute(array(
	":user" => $user,
	":pwd" => $pwd
));
$cnt = $stmt->rowCount();

if($cnt != 0) {
	$_SESSION['user'] = $user;
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$_SESSION['userid'] = $row['userid'];
}

echo $cnt;
?>
