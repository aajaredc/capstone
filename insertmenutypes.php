<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Menu</a></li>
	<li class="breadcrumb-item"><a href="#">Menu Types</a></li>
	<li class="breadcrumb-item active">Insert</li>
</ol>
<div class="card">
	<div class="card-header">Insert Menu Types</div>
	<div class="card-body">
		<form class="was-validated" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div>
				<div class="row">
					<div class="col-3 col-md-3">
						<input name="name" type="text" class="form-control" placeholder="Name" required>
					</div>
					<div class="col-9 col-md-9">
						<input name="description" type="text" class="form-control" placeholder="Description" required>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-12">
						<button name="insert" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</form>

		<?php
		if (isset($_POST['insert'])) {
			// Data cleansing
			$formfield['name'] = $_POST['name'];
			$formfield['description'] = $_POST['description'];

			// If a field is empty...
			if (empty($formfield['name']) || empty($formfield['description'])) {
				// One or more fields are empty
				echo '<br /><p class="text-warning">Insert failed: one or more fields are empty.</p>';
			} else {
				// Attempt to insert
				try {
					$sqlnewtype = "INSERT into menutype(menutypename, menutypedescription)
					VALUES (:bvname, :bvdescription)";

					$result = $db->prepare($sqlnewtype);
					$result->bindValue('bvname', $formfield['name']);
					$result->bindValue('bvdescription', $formfield['description']);
					$result->execute();

					echo '<br /><p class="text-success font-weight-bold">Insert successful.</p>';
				} catch (Exception $e) {
					echo '<br /><p class="text-danger font-weight-bold">Insert failed.</p>';
				}
			}
		}
		?>
	</div>
</div>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
