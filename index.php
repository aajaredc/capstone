<?php
	session_start();
	require_once 'header.php';
?>

<?php
	if (!isset($_SESSION['signedin'])) {
		// Redirect user if not signedin
		echo '<script>document.location.replace("signin.php");</script>';
		echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
	} else {
		// Message list variable
		$messagelist = '';

		// Select employee information
		$sqlselect = 'SELECT *
									FROM employee
									WHERE employeekey=:bvemployeekey';
		$result = $db->prepare($sqlselect);
		$result->bindValue('bvemployeekey', $_SESSION['employeekey']);
		$result->execute();
		$row = $result->fetch();

		if ($row['employeedefaultpassword'] == 0) {
			$messagelist .= '<div class="alert alert-warning" role="alert"><strong>Warning:</strong> you are still using your default password.
			Please update your password on the <a href="updatemyinformation">My Information</a> page.</div>';
		}
	}
?>

<div class="messagelist">
	<?php echo $messagelist; ?>
</div>

<?php
	require_once 'footer.php';
?>
