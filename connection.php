<?php
$conn = new PDO('mysql: host=localhost; dbname=chat_app', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
?>
