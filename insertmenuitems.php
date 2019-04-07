<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Menu</a></li>
	<li class="breadcrumb-item"><a href="#">Menu Items</a></li>
	<li class="breadcrumb-item active">Insert</li>
</ol>
<div class="card">
	<div class="card-header">Insert Menu Items</div>
	<div class="card-body">
		<form class="was-validated" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div>
				<div class="row">
					<div class="col-3 col-md-5">
						<input name="name" type="text" class="form-control" placeholder="Name" required>
					</div>
					<div class="col-3 col-md-3">
						<select name="type" class="form-control" required>
							<option disabled selected>Type</option>
							<?php
							$sqlselectt = "SELECT * FROM menutype";
							$resultt = $db->prepare($sqlselectt);
							$resultt->execute();

							while ($rowt = $resultt->fetch()) {
								echo '<option value="'. $rowt['menutypekey'] . '">' . $rowt['menutypename'] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="col-3 col-md-2">
						<input name="price" type="text" class="form-control" placeholder="Price" required>
					</div>
					<div class="col-3 col-md-2">
						<input name="count" type="text" class="form-control" placeholder="Count" required>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-12">
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
			// Insert button pressed
			if (isset($_POST['insert'])) {
				// Data cleansing
				$formfield['type'] = $_POST['type'];
				$formfield['name'] = $_POST['name'];
				$formfield['price'] = $_POST['price'];
				$formfield['count'] = $_POST['count'];

				// If a field is empty...
				if (empty($formfield['type']) || empty($formfield['name']) ||
						empty($formfield['price']) || empty($formfield['count'])) {
							// One or more fields are empty
							echo '<br /><p class="text-warning">Insert failed: one or more fields are empty.</p>';
				} else {
					// Attempt to insert
					try {
						$sqlnewitem = "INSERT into menuitem(menutypekey, menuitemname, menuitemprice, menuitemcount, menuitemdesc)
						VALUES (:bvtype, :bvname, :bvprice, :bvcount, :bvdescription)";

						$result = $db->prepare($sqlnewitem);
						$result->bindValue('bvtype', $formfield['type']);
						$result->bindValue('bvname', $formfield['name']);
						$result->bindValue('bvprice', $formfield['price']);
						$result->bindValue('bvcount', $formfield['count']);
						$result->bindValue('bvdescription', $_POST['description']);
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
