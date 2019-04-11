<?php
	session_start();
	require_once 'header.php';
?>

<?php
	if (!isset($_SESSION['signedin'])) {
		echo '<script>document.location.replace("signin.php");</script>';
		echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
	}
?>

<?php
	require_once 'footer.php';
?>
