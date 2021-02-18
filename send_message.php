<?php
include "connection.php";

$userid = $_POST['userid'];
$msg = trim($_POST['msg']);


function insert($msg, $isFile, $conn, $userid) {
	// Inserting message into database table
	$stmt1 = $conn->prepare("INSERT INTO messages (senderid, recieverid, message, isFile, date_time) VALUES (:sid, :rid, :msg, :isFile, now())");
	$stmt1->execute(array(
		":sid" => $_SESSION['userid'],
		":rid" => $userid,
		":msg" => $msg,
		":isFile" => $isFile
	));

	// Inserting attached file name into database table and uploading file if present
	if($isFile == 1) {
		$msgid = $conn->lastInsertId();
		$target_dir = "attachments/";
		$file_name = $_FILES["attachedFile"]["name"];

		$tmp = explode(".", $file_name);
		$file_ext = end($tmp);
		$temp_name = "file_" . $msgid . "." . $file_ext;

		move_uploaded_file($_FILES["attachedFile"]["tmp_name"], $target_dir . $temp_name);

		$stmt5 = $conn->prepare("INSERT INTO attachments (msgid, filename, tempname) VALUES (:msgid, :filename, :tempname)");
		$stmt5->execute(array(
			":msgid" => $msgid,
			":filename" => $file_name,
			":tempname" => $temp_name
		));		
	}
}


// If message and attachment both are present
if(strlen($msg) > 0 && isset($_FILES["attachedFile"]))
	insert($msg, 1, $conn, $userid);

// If only message is present
elseif(strlen($msg) > 0 && !isset($_FILES["attachedFile"]))
	insert($msg, 0, $conn, $userid);

// If only attachment is present
elseif(strlen($msg) == 0 && isset($_FILES["attachedFile"]))
	insert("", 1, $conn, $userid);

if(strlen($msg) > 0 || isset($_FILES["attachedFile"])) {

	// Retrieving message counts between two users
	$stmt2 = $conn->prepare("SELECT chatid, msgCount FROM chats_count WHERE user1id IN (:sid, :rid) AND user2id IN (:sid, :rid)");
	$stmt2->execute(array(
		":sid" => $_SESSION['userid'],
		":rid" => $userid
	));

	// If it's first time that two users are chatting
	// then inserting message count as 1
	if($stmt2->rowCount() == 0) {
		$stmt3 = $conn->prepare("INSERT INTO chats_count (user1id, user2id, msgCount, user1ClrCount, user2ClrCount) VALUES (:sid, :rid, 1, 0, 0)");
		$stmt3->execute(array(
			":sid" => $_SESSION['userid'],
			":rid" => $userid
		));
	}

	// If the two users had a chat before
	// then updating message count by incrementing the current count by 1
	else {
		$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
		$stmt4 = $conn->prepare("UPDATE chats_count SET msgCount = :msgCount WHERE chatid = :chatid");
		$stmt4->execute(array(
			":chatid" => $row2['chatid'],
			":msgCount" => ($row2['msgCount'] + 1)
		));
	}
}
?>
