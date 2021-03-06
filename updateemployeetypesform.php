<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
		// Define employee type key
		$formfield['employeetypekey'] = $_POST['employeetypekey'];

		// Only view this page if it came from the according pages
		if (isset($_POST['updateemployeetypeselection']) || isset($_POST['updateemployeetype'])) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Employees</li>
	<li class="breadcrumb-item">Employee Types</li>
	<li class="breadcrumb-item active">Update</li>
</ol>
<div class="card">
	<div class="card-header">Update Employee Types</div>
	<div class="card-body">
		<?php
		// If update button is pressed
		if (isset($_POST['updateemployeetype'])) {
			// feedback
			$feedback = '';

			// Data cleansing
			$formfield['name'] = $_POST['name'];
			$formfield['description'] = $_POST['description'];
			$formfield['defaultpay'] = $_POST['defaultpay'];

			// Generate permission
			$permission = '';
			// Selects
			if (empty($_POST['selectmenuitems'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selectmenutypes'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selectemployees'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selectemployeetypes'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selectcustomers'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selectorders'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selecttickets'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selectlocations'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selecttables'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['selectschedules'])) { $permission .= '0'; } else { $permission .= '1'; }
			// Inserts
			if (empty($_POST['insertmenuitems'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['insertmenutypes'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['insertemployees'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['insertemployeetypes'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['insertcustomers'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['insertorders'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['inserttickets'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['insertlocations'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['inserttables'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['insertschedules'])) { $permission .= '0'; } else { $permission .= '1'; }
			// Updates
			if (empty($_POST['updatemenuitems'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updatemenutypes'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updateemployees'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updateemployeetypes'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updatecustomers'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updateorders'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updatetickets'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updatelocations'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updatetables'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['updateschedules'])) { $permission .= '0'; } else { $permission .= '1'; }
			// Deletes
			if (empty($_POST['deletemenuitems'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deletemenutypes'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deleteemployees'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deleteemployeetypes'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deletecustomers'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deleteorders'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deletetickets'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deletelocations'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deletetables'])) { $permission .= '0'; } else { $permission .= '1'; }
			if (empty($_POST['deleteschedules'])) { $permission .= '0'; } else { $permission .= '1'; }
			$permission = trim($permission);

			// If a field is empty...
			if (empty($formfield['name']) || empty($formfield['description'])) {
				// One or more fields are empty
				echo '<br /><p class="text-warning">Update failed: one or more fields are empty.</p>';
			} else {
				// Attempt to insert
				try {
					$sqlupdate = 'UPDATE employeetype
												SET employeetypename=:bvname, employeetypedescription=:bvdescription,
														employeetypepermission=:bvpermission, defaultpay=:bvpay
												WHERE employeetypekey=:bvemployeetypekey';

					$result = $db->prepare($sqlupdate);
					$result->bindValue('bvname', $formfield['name']);
					$result->bindValue('bvdescription', $formfield['description']);
					$result->bindValue('bvpermission', $permission);
					$result->bindValue('bvpay', $formfield['defaultpay']);
					$result->bindValue('bvemployeetypekey', $formfield['employeetypekey']);
					$result->execute();

					echo '<div class="alert alert-success" role="alert">Update successful. <a href="updateemployeetypes.php">Back</a></div>';
				} catch (Exception $e) {
					$feedback .= '<br /><p class="text-danger font-weight-bold">Update failed.</p>';
					$feedback .= '<p class="text-danger">' . $e->getMessage() . '</p>';
				}
			}
		}

		// Get information from schedule
		$sqlselects = 'SELECT *
									 FROM employeetype
									 WHERE employeetypekey=:bvkey';
		$result = $db->prepare($sqlselects);
		$result->bindValue(':bvkey', $formfield['employeetypekey']);
		$result->execute();
		$row = $result->fetch();
		?>
		<form class="was-validated" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div>
				<div class="row">
					<div class="col-12 col-md-3 mb-3">
						<input name="name" type="text" class="form-control" placeholder="Name" value="<?php echo $row['employeetypename']; ?>" required>
						<div class="valid-feedback">Valid name</div>
						<div class="invalid-feedback">Invalid name</div>
					</div>
					<div class="col-12 col-md-7 mb-3">
						<input name="description" type="text" class="form-control" placeholder="Description" value="<?php echo $row['employeetypedescription']; ?>" required>
						<div class="valid-feedback">Valid description</div>
						<div class="invalid-feedback">Invalid description</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-4 mb-3">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">$</div>
							</div>
							<input name="defaultpay" type="text" class="form-control" placeholder="Default Pay" value="<?php echo $row['defaultpay']; ?>" required>
							<div class="valid-feedback">Valid default pay</div>
							<div class="invalid-feedback">Invalid default pay</div>
						</div>
					</div>
				</div>
				<div class="card-header">Select Permissions</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<th></th>
								<th>Menu Items</th>
								<th>Menu Types</th>
								<th>Employees</th>
								<th>Employee Types</th>
								<th>Customers</th>
								<th>Orders</th>
								<th>Tickets</th>
								<th>Locations</th>
								<th>Tables</th>
								<th>Schedules</th>
							</thead>
							<tbody>
								<tr>
									<th>Select</th>
									<td><input name="selectmenuitems" type="checkbox" value="1" <?php if (preg_match('/1......................................./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selectmenutypes" type="checkbox" value="1" <?php if (preg_match('/.1....................................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selectemployees" type="checkbox" value="1" <?php if (preg_match('/..1...................................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selectemployeetypes" type="checkbox" value="1" <?php if (preg_match('/...1..................................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selectcustomers" type="checkbox" value="1" <?php if (preg_match('/....1.................................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selectorders" type="checkbox" value="1" <?php if (preg_match('/.....1................................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selecttickets" type="checkbox" value="1" <?php if (preg_match('/......1................................./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selectlocations" type="checkbox" value="1" <?php if (preg_match('/.......1................................/', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selecttables" type="checkbox" value="1" <?php if (preg_match('/........1.............................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="selectschedules" type="checkbox" value="1" <?php if (preg_match('/.........1............................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
								</tr>
								<tr>
									<th>Insert</th>
									<td><input name="insertmenuitems" type="checkbox" value="1" <?php if (preg_match('/..........1............................./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="insertmenutypes" type="checkbox" value="1" <?php if (preg_match('/...........1............................/', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="insertemployees" type="checkbox" value="1" <?php if (preg_match('/............1.........................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="insertemployeetypes" type="checkbox" value="1" <?php if (preg_match('/.............1........................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="insertcustomers" type="checkbox" value="1" <?php if (preg_match('/..............1........................./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="insertorders" type="checkbox" value="1" <?php if (preg_match('/...............1......................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="inserttickets" type="checkbox" value="1" <?php if (preg_match('/................1......................./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="insertlocations" type="checkbox" value="1" <?php if (preg_match('/.................1....................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="inserttables" type="checkbox" value="1" <?php if (preg_match('/..................1...................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="insertschedules" type="checkbox" value="1" <?php if (preg_match('/...................1..................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
								</tr>
								<tr>
									<th>Update</th>
									<td><input name="updatemenuitems" type="checkbox" value="1" <?php if (preg_match('/....................1.................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updatemenutypes" type="checkbox" value="1" <?php if (preg_match('/.....................1................../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updateemployees" type="checkbox" value="1" <?php if (preg_match('/......................1................./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updateemployeetypes" type="checkbox" value="1" <?php if (preg_match('/.......................1................/', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updatecustomers" type="checkbox" value="1" <?php if (preg_match('/........................1.............../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updateorders" type="checkbox" value="1" <?php if (preg_match('/.........................1............../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updatetickets" type="checkbox" value="1" <?php if (preg_match('/..........................1............./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updatelocations" type="checkbox" value="1" <?php if (preg_match('/...........................1............/', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updatetables" type="checkbox" value="1" <?php if (preg_match('/............................1.........../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="updateschedules" type="checkbox" value="1" <?php if (preg_match('/.............................1........../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
								</tr>
								<tr>
									<th>Delete</th>
									<td><input name="deletemenuitems" type="checkbox" value="1" <?php if (preg_match('/..............................1........./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deletemenutypes" type="checkbox" value="1" <?php if (preg_match('/...............................1......../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deleteemployees" type="checkbox" value="1" <?php if (preg_match('/................................1......./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deleteemployeetypes" type="checkbox" value="1" <?php if (preg_match('/.................................1....../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deletecustomers" type="checkbox" value="1" <?php if (preg_match('/..................................1...../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deleteorders" type="checkbox" value="1" <?php if (preg_match('/...................................1..../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deletetickets" type="checkbox" value="1" <?php if (preg_match('/....................................1.../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deletelocations" type="checkbox" value="1" <?php if (preg_match('/.....................................1../', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deletetables" type="checkbox" value="1" <?php if (preg_match('/......................................1./', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
									<td><input name="deleteschedules" type="checkbox" value="1" <?php if (preg_match('/.......................................1/', $row['employeetypepermission'])) { echo ' checked'; } ?>></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input type="hidden" value="<?php echo $formfield['employeetypekey']; ?>" name="employeetypekey"/>
						<button name="updateemployeetype" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</form>
		<?php if (isset($_POST['updateemployeetype'])) { echo $feedback; } ?>
	</div>
</div>
<?php
} else {
	echo '<p>not this time</p>'; // page can not be viewed
}
} else {
		echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
