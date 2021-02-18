<?php
include "connection.php";

$userid = $_POST['userid'];

// Retrieving message counts between two users
$stmt1 = $conn->prepare("SELECT msgCount FROM chats_count WHERE user1id IN (:sid, :rid) AND user2id IN (:sid, :rid)");
$stmt1->execute(array(
	":sid" => $_SESSION['userid'],
	":rid" => $userid
));
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

// Updating cleared chats in chats count table
$sql2 = "UPDATE chats_count SET user1ClrCount = CASE ";
$sql2 .= "WHEN user1id = :sid AND user2id = :rid THEN :msgCnt ELSE user1ClrCount END, ";
$sql2 .= "user2ClrCount = CASE ";
$sql2 .= "WHEN user1id = :rid AND user2id = :sid THEN :msgCnt ELSE user2ClrCount END;";

$stmt2 = $conn->prepare($sql2);
$stmt2->execute(array(
	":sid" => $_SESSION['userid'],
	":rid" => $userid,
	":msgCnt" => $row1['msgCount']
));
?>
