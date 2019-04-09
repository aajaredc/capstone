<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
		// Only view this page if it came from the according pages
		if (isset($_POST['updatelocationselection']) || isset($_POST['update'])) {
			// Define table key
			$formfield['locationkey'] = $_POST['locationkey'];
			// Data cleansing
			$formfield['name'] = trim($_POST['name']);
			$formfield['address'] = trim($_POST['address']);
			$formfield['description'] = trim($_POST['description']);
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Locations</a></li>
	<li class="breadcrumb-item active">Update</li>
</ol>
<div class="card">
	<div class="card-header">Update Locations</div>
	<div class="card-body">
		<form class="was-validated" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div>
				<div class="row">
					<!-- Name field -->
					<div class="col-6 col-md-4">
						<input name="name" type="text" class="form-control" placeholder="Name" value="<?php echo $formfield['name']; ?>" required>
						<div class="valid-feedback">Valid name</div>
						<div class="invalid-feedback">Invalid name</div>
					</div>
					<!-- Address field -->
					<div class="col-6 col-md-8">
						<input name="address" type="text" class="form-control" placeholder="Address" value="<?php echo $formfield['address']; ?>" required>
						<div class="valid-feedback">Valid address</div>
						<div class="invalid-feedback">Invalid address</div>
					</div>
				</div>
				<br />
				<div class="row">
					<!-- Description field -->
					<div class="col-12">
						<input name="description" type="text" class="form-control" placeholder="Description" value="<?php echo $formfield['description']; ?>" required>
						<div class="valid-feedback">Valid description</div>
						<div class="invalid-feedback">Invalid description</div>
					</div>
				</div>
				<br />
				<div class="row">
					<!-- Submit button -->
					<div class="col-12">
						<input type="hidden" name="locationkey" value="<?php echo $formfield['locationkey']; ?>"/>
						<button name="update" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</form>
		<?php
			// Insert button pressed
			if (isset($_POST['update'])) {
				// If a field is empty...
				if (empty($formfield['name']) || empty($formfield['address']) ||
						empty($formfield['description'])) {
							// One or more fields are empty
							echo '<br /><p class="text-warning">Update failed: one or more fields are empty.</p>';
				} else {
					// Attempt to Update
					try {
						// statement
						$sqlupdate = 'UPDATE locations
													SET locationname=:bvname, locationaddress=:bvaddress,
															locationdescription=:bvdescription
													WHERE locationkey=:bvlocationkey';

						// Prepare and execute
						$result = $db->prepare($sqlupdate);
						$result->bindValue('bvname', $formfield['name']);
						$result->bindValue('bvaddress', $formfield['address']);
						$result->bindValue('bvdescription', $formfield['description']);
						$result->bindValue('bvlocationkey', $formfield['locationkey']);
						$result->execute();

						// Success
						echo '<br /><p class="text-success font-weight-bold">Update successful.</p>';
					} catch (Exception $e) {
						// An error occured
						echo '<br /><p class="text-danger font-weight-bold">Update failed.</p>';
					}
				}
			}
		?>
	</div>
</div>
<?php
} else {
	echo '<p>not today</p>'; // page can not be viewed
}
} else {
		echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
