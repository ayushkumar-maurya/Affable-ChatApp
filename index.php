<?php
include "connection.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Chat App</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet">
</head>
<body>
<?php if(isset($_SESSION['user'])) { ?>

	<h2>Welcome <?= $_SESSION['user'] ?></h2>
	<input type="button" value="Log Out" onclick="logout();">
	<br><br><br><hr><br><br><br>
	<h4>Other Users:</h4>

	<?php
		$stmt = $conn->prepare("SELECT userid, username FROM users WHERE username <> :user");
		$stmt->execute(array(":user" => $_SESSION['user']));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$userid = $row['userid'];
			$user = $row['username'];
	?>

	<br>
	<input type="button" value="<?= $user ?>" onclick="chat('<?= $userid ?>', '<?= $user ?>');">
	<br>

	<?php } ?>
<?php } else { ?>

	<form>
		<input type="text" id="user" placeholder="User Name">
		<br><br>
		<input type="text" id="pwd" placeholder="Password">
		<br><br>
		<input type="button" value="Log In" onclick="login();">
	</form>

<?php } ?>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="chatModalLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="chats"></div>
			<hr>
			<center>
				<form>
					<input type="text" id="msg">
					<input type="button" id="send-msg" value="Send">
					<br><br>
					<input type="file" name="attachedFile" id="attachedFile">
					<input type="button" id="clr-msgs" value="Clear Chats">
				</form>
			</center>
			<br>
		</div>
	</div>
</div>

<!-- Clear chats Modal -->
<div class="modal fade" id="clrChatsModal" tabindex="-1" aria-labelledby="clrChatsModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="clrChatsModalLabel">Clear Chats</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-clr-modal"></button>
			</div>
			<div class="modal-body">
				<b>Are you sure you want to clear chats?</b>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="confirm-clr-msgs">Clear</button>
			</div>
		</div>
	</div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
