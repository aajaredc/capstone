<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Locations</a></li>
	<li class="breadcrumb-item active">Insert</li>
</ol>
<div class="card">
	<div class="card-header">Insert Locations</div>
	<div class="card-body">
		<?php
			// Insert button pressed
			if (isset($_POST['insert'])) {
				// Data cleansing
				$formfield['name'] = trim($_POST['name']);
				$formfield['address'] = trim($_POST['address']);
				$formfield['description'] = trim($_POST['description']);
				$formfield['locationopen'] = $_POST['locationopen'];
				$formfield['locationclose'] = $_POST['locationclose'];

				// If a field is empty...
				if (empty($formfield['name']) || empty($formfield['address']) ||
						empty($formfield['description']) || empty($formfield['locationopen']) ||
						empty($formfield['locationclose'])) {
							// One or more fields are empty
							echo '<br /><p class="text-warning">Insert failed: one or more fields are empty.</p>';
				} else {
					// Attempt to insert
					try {
						// statement
						$sqlinsert = 'INSERT INTO locations(locationname, locationaddress, locationdescription, locationopen, locationclose)
													VALUES(:bvname, :bvaddress, :bvdescription, :bvopen, :bvclose)';

						// Prepare and execute
						$result = $db->prepare($sqlinsert);
						$result->bindValue('bvname', $formfield['name']);
						$result->bindValue('bvaddress', $formfield['address']);
						$result->bindValue('bvdescription', $formfield['description']);
						$result->bindValue('bvopen', $formfield['locationopen']);
						$result->bindValue('bvclose', $formfield['locationclose']);
						$result->execute();

						// Success
						echo '<div class="alert alert-success" role="alert">Insert successful</div>';
					} catch (Exception $e) {
						// An error occured
						echo '<div class="alert alert-warning" role="alert"><strong>Insert failed: </strong>' . $e->getMessage() . '</div>';
					}
				}
			}
		?>
		<form class="was-validated" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div>
				<div class="row">
					<!-- Name field -->
					<div class="col-6 col-md-4 mb-4">
						<input name="name" type="text" class="form-control" placeholder="Name" required>
						<div class="valid-feedback">Valid name</div>
						<div class="invalid-feedback">Invalid name</div>
					</div>
					<!-- Address field -->
					<div class="col-6 col-md-8 mb-4">
						<input name="address" type="text" class="form-control" placeholder="Address" required>
						<div class="valid-feedback">Valid address</div>
						<div class="invalid-feedback">Invalid address</div>
					</div>
				</div>
				<div class="row">
					<!-- Description field -->
					<div class="col-12 mb-4">
						<input name="description" type="text" class="form-control" placeholder="Description" required>
						<div class="valid-feedback">Valid description</div>
						<div class="invalid-feedback">Invalid description</div>
					</div>
				</div>
				<div class="row">
					<!-- Time fields -->
					<div class="col-6 mb-4">
						<input name="locationopen" type="time" class="form-control" required>
						<div class="valid-feedback">Valid open time</div>
						<div class="invalid-feedback">Invalid open time</div>
					</div>
					<div class="col-6 mb-4">
						<input name="locationclose" type="time" class="form-control" required>
						<div class="valid-feedback">Valid close time</div>
						<div class="invalid-feedback">Invalid close time</div>
					</div>
				</div>
				<div class="row">
					<!-- Submit button -->
					<div class="col-12">
						<button name="insert" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
