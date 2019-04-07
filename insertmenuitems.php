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
					<div class="col-3 col-md-2" required>
						<input name="price" type="text" class="form-control" placeholder="Price">
					</div>
					<div class="col-3 col-md-2" required>
						<input name="count" type="text" class="form-control" placeholder="Count">
					</div>
				</div>
				<br />
				<div class="row" required>
					<div class="col-12">
						<input name="description" type="text" class="form-control" placeholder="Description">
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
		<?php if (isset($_POST['insert'])) {
			try {
				$sqlnewitem = "INSERT into menuitem(menutypekey, menuitemname, menuitemprice, menuitemcount, menuitemdesc)
				VALUES (:bvtype, :bvname, :bvprice, :bvcount, :bvdescription)";

				$result = $db->prepare($sqlnewitem);
				$result->bindValue('bvtype', $_POST['type']);
				$result->bindValue('bvname', $_POST['name']);
				$result->bindValue('bvprice', $_POST['price']);
				$result->bindValue('bvcount', $_POST['count']);
				$result->bindValue('bvdescription', $_POST['description']);
				$result->execute();

				echo '<br /><p class="text-success font-weight-bold">Insert successful.</p>';
			} catch (Exception $e) {
				echo '<br /><p class="text-danger font-weight-bold">Insert failed.</p>';
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
