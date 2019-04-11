<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Schedules</li>
	<li class="breadcrumb-item active">Insert</li>
</ol>
<div class="card">
	<div class="card-header">Insert Schedules</div>
	<div class="card-body">
		<?php if (isset($_POST['selectsubmit']) || isset($_POST['insertschedule'])) { ?>
			<form class="was-validated" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div class="row">
					<!-- Date -->
					<div class="col-12 col-md-6 mb-3">
						<input name="date" type="date" class="form-control" required>
						<div class="valid-feedback">Valid date</div>
						<div class="invalid-feedback">Invalid date</div>
					</div>
				</div>
				<div class="row">
					<!-- Start time -->
					<div class="col-12 col-md-6 col-sm-12 mb-3">
						<input name="starttime" type="time" class="form-control" required>
						<div class="valid-feedback">Valid start time</div>
						<div class="invalid-feedback">Invalid start time</div>
					</div>
					<!-- End time -->
					<div class="col-12 col-md-6 col-sm-12 mb-3">
						<input name="endtime" type="time" class="form-control" required>
						<div class="valid-feedback">Valid end time</div>
						<div class="invalid-feedback">Invalid end time</div>
					</div>
				</div>
				<div class="row">
					<!-- repeat 7 days -->
					<div class="col-12 col-sm-auto col-md-auto mb-3">
						<input name="repeat" type="checkbox" value="1">
						<label>Repeat for 7 days</label>
					</div>
				</div>
				<div class="row">
					<!-- Submission -->
					<div class="col-12 col-md-12 mb-3">
						<input type="hidden" name="employeekey" value="<?php echo $_POST['employeekey']; ?>"/>
						<button name="insertschedule" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
			<?php
			if (isset($_POST['insertschedule'])) {
				// Data cleansing
				$formfield['date'] = $_POST['date'];
				$formfield['starttime'] = $_POST['starttime'];
				$formfield['endtime'] = $_POST['endtime'];
				$formfield['repeat'] = $_POST['repeat'];
				$formfield['employeekey'] = $_POST['employeekey'];

				// If a field is empty...
				if (empty($formfield['date']) || empty($formfield['starttime']) ||
				 		empty($formfield['endtime']) || empty($formfield['employeekey'])){
					// One or more fields are empty
					echo '<br /><p class="text-warning">Insert failed: one or more fields are empty.</p>';
				} else {
					// Attempt to insert
					try {
						$sqlnewtype = "INSERT into schedules(scheduledate, schedulestart,
							scheduleend, employeekey)
						VALUES (:bvdate, :bvstart, :bvend, :bvemployee)";

						$result = $db->prepare($sqlnewtype);
						$result->bindValue('bvdate', $formfield['date']);
						$result->bindValue('bvstart', $formfield['starttime']);
						$result->bindValue('bvend', $formfield['endtime']);
						$result->bindValue('bvemployee', $formfield['employeekey']);

						if (empty($formfield['repeat'])) {
							$result->execute();
						} else {
							$date = $formfield['date'];
							for ($i = 0; $i < 7; $i++) {
								$result->bindValue('bvdate', $date);
								$result->execute();
								$date = date('Y-m-d', strtotime($date . ' +1 day'));
							}
						}

						echo '
						<br />
						<p class="text-success font-weight-bold">Insert successful.</p>
						<p><a href="insertschedules.php">Back</a></p>';
					} catch (Exception $e) {
						echo '<br /><p class="text-danger font-weight-bold">Insert failed.</p>';
						echo '<p class="text-danger font-weight-bold">' . $e->getMessage() . '</p>';
					}
				}
			}
			?>

		<?php } else { ?>
			<div class="table-responsive">
				<table class="table table-bordered" id="selectemployeesTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Username</th>
							<th>Type</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sqlselecti = "SELECT * FROM employee INNER JOIN employeetype ON employee.employeetypekey = employeetype.employeetypekey ORDER BY employeekey ASC";
						$result = $db->prepare($sqlselecti);
						$result->execute();
							while ( $row = $result-> fetch() )
								{
									echo '<tr><td>' . $row['employeeusername'] . '</td><td> ' . $row['employeetypename'] .
									'</td><td> ' . $row['employeefirstname'] . '</td><td> ' . $row['employeelastname'] . '</td>
									<td>
										<form name="selectcustomer" method="post" action=' . $_SERVER['PHP_SELF'] . '>
											<input type="hidden" name="employeekey" value="' . $row['employeekey'] . '"/>
											<input type="submit" name="selectsubmit" value="Select"/>
										</form>
									</td>';
								}
								echo '</tr>';
						?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
</div>
<script>
$(document).ready( function () {
    $('#selectemployeesTable').DataTable();
} );
</script>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
