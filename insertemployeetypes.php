<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Employees</a></li>
	<li class="breadcrumb-item"><a href="#">Employee Types</a></li>
	<li class="breadcrumb-item active">Insert</li>
</ol>
<div class="card">
	<div class="card-header">Insert Employee Types</div>
	<div class="card-body">
		<form class="was-validated" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div>
				<div class="row">
					<div class="col-3 col-md-3">
						<input name="name" type="text" class="form-control" placeholder="Name" required>
						<div class="valid-feedback">Valid name</div>
						<div class="invalid-feedback">Invalid name</div>
					</div>
					<div class="col-9 col-md-9">
						<input name="description" type="text" class="form-control" placeholder="Description" required>
						<div class="valid-feedback">Valid description</div>
						<div class="invalid-feedback">Invalid description</div>
					</div>
				</div>
				<br />
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
							</thead>
							<tbody>
								<tr>
									<th>Select</th>
									<td><input name="selectmenuitems" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="selectmenutypes" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="selectemployees" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="selectemployeetypes" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="selectcustomers" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="selectorders" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="selecttickets" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="selectlocations" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="selecttables" class="form-check-input" type="checkbox" value="1"></td>
								</tr>
								<tr>
									<th>Insert</th>
									<td><input name="insertmenuitems" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="insertmenutypes" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="insertemployees" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="insertemployeetypes" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="insertcustomers" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="insertorders" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="inserttickets" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="insertlocations" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="inserttables" class="form-check-input" type="checkbox" value="1"></td>
								</tr>
								<tr>
									<th>Update</th>
									<td><input name="updatemenuitems" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="updatemenutypes" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="updateemployees" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="updateemployeetypes" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="updatecustomers" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="updateorders" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="updatetickets" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="updatelocations" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="updatetables" class="form-check-input" type="checkbox" value="1"></td>
								</tr>
								<tr>
									<th>Delete</th>
									<td><input name="deletemenuitems" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="deletemenutypes" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="deleteemployees" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="deleteemployeetypes" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="deletecustomers" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="deleteorders" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="deletetickets" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="deletelocations" class="form-check-input" type="checkbox" value="1"></td>
									<td><input name="deletetables" class="form-check-input" type="checkbox" value="1"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<button name="insert" type="submit" class="btn btn-primary">Submit</button>
					</div>
					<div class="col-12">
						<button name="permissiontest" type="submit" class="btn btn-primary">test permissions</button>
					</div>
				</div>
			</div>
		</form>
		<?php
		if (isset($_POST['permissiontest'])) {
			// Create permission
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

			// Echo for testing
			$permission = trim($permission);
			echo '<p>' .$permission. '</p>';
			if (preg_match('/.1................................../', $permission)) {
					echo '<p>true</p>';
			} else {
				echo '<p>false</p>';
			}
		}

		if (isset($_POST['insert'])) {
			// Data cleansing
			$formfield['name'] = $_POST['name'];
			$formfield['description'] = $_POST['description'];

			// If a field is empty...
			if (empty($formfield['n$permissioname']) || empty($formfield['description'])) {
				// One or more fields are empty
				echo '<br /><p class="text-warning">Insert failed: one or more fields are empty.</p>';
			} else {
				// Attempt to insert
				try {
					$sqlnewtype = "INSERT into employeetype(employeetypename, employeetypedescription)
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
