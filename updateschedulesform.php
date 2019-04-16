<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
		// Define schedule key
		$formfield['schedulekey'] = $_POST['schedulekey'];
		$feedback = '';

		// This function gets the weekdate of a given date
		function getWeekday($date) {
			return date('w', strtotime($date));
		}

		// If update button is pressed
		if (isset($_POST['updateschedule'])) {
			// Data cleansing
			$formfield['start'] = $_POST['start'];
			$formfield['employeekey'] = $_POST['employeekey'];

			$formfield['sundaystart'] = $_POST['sundaystart'];
			$formfield['sundayend'] = $_POST['sundayend'];

			$formfield['mondaystart'] = $_POST['mondaystart'];
			$formfield['mondayend'] = $_POST['mondayend'];

			$formfield['tuesdaystart'] = $_POST['tuesdaystart'];
			$formfield['tuesdayend'] = $_POST['tuesdayend'];

			$formfield['wednesdaystart'] = $_POST['wednesdaystart'];
			$formfield['wednesdayend'] = $_POST['wednesdayend'];

			$formfield['thursdaystart'] = $_POST['thursdaystart'];
			$formfield['thursdayend'] = $_POST['thursdayend'];

			$formfield['fridaystart'] = $_POST['fridaystart'];
			$formfield['fridayend'] = $_POST['fridayend'];

			$formfield['saturdaystart'] = $_POST['saturdaystart'];
			$formfield['saturdayend'] = $_POST['saturdayend'];

			// Check if the weekday is 0 (sunday)
			if (getWeekday($formfield['start']) != 0) {
				// If the week day is not sunday, then make it sunday
				$startdate = date('Y-m-d', (strtotime('-' . getWeekday($formfield['start']) . ' day', strtotime($formfield['start']))));
			} else {
				// The day the schedule starts is already sunday
				$startdate = $formfield['start'];
			}

			// Check if that week has not yet been used for this employee
			try {
				$sql = 'SELECT *
								FROM schedules
								WHERE schedulestart=:bvschedulestart
								AND employeekey=:bvemployeekey';

				$s = $db->prepare($sql);
				$s->bindValue(':bvschedulestart', $startdate);
				$s->bindValue(':bvemployeekey', $formfield['employeekey']);
				$s->execute();
				$count = $s->rowCount();
			} catch (PDOException $e) {
				echo $e->getMessage();
				exit();
			}

			// Proceed only if this employee already has a schedule for this week
			if ($count < 1) {
				// Attempt to insert
				try {
					// statement
					$sqlupdate = 'UPDATE schedules
												SET employeekey=:bvemployeekey, schedulestart=:bvschedulestart,
														sundaystart=:bvsundaystart, sundayend=:bvsundayend,
														mondaystart=:bvmondaystart, mondayend=:bvmondayend,
														tuesdaystart=:bvtuesdaystart, tuesdayend=:bvtuesdayend,
														wednesdaystart=:bvwednesdaystart, wednesdayend=:bvwednesdayend,
														thursdaystart=:bvthursdaystart, thursdayend=:bvthursdayend,
														fridaystart=:bvfridaystart, fridayend=:bvfridayend,
														saturdaystart=:bvsaturdaystart, saturdayend=:bvsaturdayend
												WHERE schedulekey=:bvschedulekey';

					// Prepare and execute
					$result = $db->prepare($sqlupdate);
					$result->bindValue('bvemployeekey', $formfield['employeekey']);
					$result->bindValue('bvschedulestart', $startdate);
					$result->bindValue('bvsundaystart', $formfield['sundaystart']);
					$result->bindValue('bvsundayend', $formfield['sundayend']);
					$result->bindValue('bvmondaystart', $formfield['mondaystart']);
					$result->bindValue('bvmondayend', $formfield['mondayend']);
					$result->bindValue('bvtuesdaystart', $formfield['tuesdaystart']);
					$result->bindValue('bvtuesdayend', $formfield['tuesdayend']);
					$result->bindValue('bvwednesdaystart', $formfield['wednesdaystart']);
					$result->bindValue('bvwednesdayend', $formfield['wednesdayend']);
					$result->bindValue('bvthursdaystart', $formfield['thursdaystart']);
					$result->bindValue('bvthursdayend', $formfield['thursdayend']);
					$result->bindValue('bvfridaystart', $formfield['fridaystart']);
					$result->bindValue('bvfridayend', $formfield['fridayend']);
					$result->bindValue('bvsaturdaystart', $formfield['saturdaystart']);
					$result->bindValue('bvsaturdayend', $formfield['saturdayend']);
					$result->bindValue('bvschedulekey', $formfield['schedulekey']);
					$result->execute();

					// Success
					$feedback .= '<br /><p class="text-success font-weight-bold">Update successful.</p>';
				} catch (Exception $e) {
					// An error occured
					$feedback .= '<br />
								<p class="text-danger font-weight-bold">Update failed.</p>
								<p class="text-danger">' . $e->getMessage() . '</p>';
				}
			} else {
				// An employee already has a schedule for this week
				$feedback .= '<br />
							<p class="text-danger">A schedule for this week already exists.</p>';
			}
		}

		// Only view this page if it came from the according pages
		if (isset($_POST['selectschedulesubmit']) || isset($_POST['updateschedule'])) {
			// Get information from schedule
			$sqlselects = 'SELECT *
										 FROM schedules
										 WHERE schedulekey=:bvkey';
			$result = $db->prepare($sqlselects);
			$result->bindValue(':bvkey', $formfield['schedulekey']);
			$result->execute();
			$row = $result->fetch();
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Schedules</li>
	<li class="breadcrumb-item active">Update</li>
</ol>
<div class="card">
	<div class="card-header">Update Schedules</div>
	<div class="card-body">
		<form class="was-validated" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<!-- Week -->
			<p class="mb-1">Select Week</p>
			<div class="row">
				<div class="col-12 col-md-6 mb-3">
					<input name="start" type="date" class="form-control" value="<?php echo $row['schedulestart']; ?>" required>
					<div class="valid-feedback">Valid week</div>
					<div class="invalid-feedback">Invalid week</div>
				</div>
			</div>
			<!-- sunday -->
			<p class="mb-1">Sunday</p>
			<div class="row">
				<!-- Start time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="sundaystart" type="time" class="form-control" value="<?php echo $row['sundaystart']; ?>">
					<div class="valid-feedback">Valid start time</div>
					<div class="invalid-feedback">Invalid start time</div>
				</div>
				<!-- End time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="sundayend" type="time" class="form-control" value="<?php echo $row['sundayend']; ?>">
					<div class="valid-feedback">Valid end time</div>
					<div class="invalid-feedback">Invalid end time</div>
				</div>
			</div>
			<!-- Monday -->
			<p class="mb-1">Monday</p>
			<div class="row">
				<!-- Start time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="mondaystart" type="time" class="form-control" value="<?php echo $row['mondaystart']; ?>">
					<div class="valid-feedback">Valid start time</div>
					<div class="invalid-feedback">Invalid start time</div>
				</div>
				<!-- End time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="mondayend" type="time" class="form-control" value="<?php echo $row['mondayend']; ?>">
					<div class="valid-feedback">Valid end time</div>
					<div class="invalid-feedback">Invalid end time</div>
				</div>
			</div>
			<!-- tuesday -->
			<p class="mb-1">Tuesday</p>
			<div class="row">
				<!-- Start time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="tuesdaystart" type="time" class="form-control" value="<?php echo $row['tuesdaystart']; ?>">
					<div class="valid-feedback">Valid start time</div>
					<div class="invalid-feedback">Invalid start time</div>
				</div>
				<!-- End time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="tuesdayend" type="time" class="form-control" value="<?php echo $row['tuesdayend']; ?>">
					<div class="valid-feedback">Valid end time</div>
					<div class="invalid-feedback">Invalid end time</div>
				</div>
			</div>
			<!-- wednesday -->
			<p class="mb-1">Wednesday</p>
			<div class="row">
				<!-- Start time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="wednesdaystart" type="time" class="form-control" value="<?php echo $row['wednesdaystart']; ?>">
					<div class="valid-feedback">Valid start time</div>
					<div class="invalid-feedback">Invalid start time</div>
				</div>
				<!-- End time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="wednesdayend" type="time" class="form-control" value="<?php echo $row['wednesdayend']; ?>">
					<div class="valid-feedback">Valid end time</div>
					<div class="invalid-feedback">Invalid end time</div>
				</div>
			</div>
			<!-- thursday -->
			<p class="mb-1">Thursday</p>
			<div class="row">
				<!-- Start time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="thursdaystart" type="time" class="form-control" value="<?php echo $row['thursdaystart']; ?>">
					<div class="valid-feedback">Valid start time</div>
					<div class="invalid-feedback">Invalid start time</div>
				</div>
				<!-- End time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="thursdayend" type="time" class="form-control" value="<?php echo $row['thursdayend']; ?>">
					<div class="valid-feedback">Valid end time</div>
					<div class="invalid-feedback">Invalid end time</div>
				</div>
			</div>
			<!-- friday -->
			<p class="mb-1">Friday</p>
			<div class="row">
				<!-- Start time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="fridaystart" type="time" class="form-control" value="<?php echo $row['fridaystart']; ?>">
					<div class="valid-feedback">Valid start time</div>
					<div class="invalid-feedback">Invalid start time</div>
				</div>
				<!-- End time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="fridayend" type="time" class="form-control" value="<?php echo $row['fridayend']; ?>">
					<div class="valid-feedback">Valid end time</div>
					<div class="invalid-feedback">Invalid end time</div>
				</div>
			</div>
			<!-- saturday -->
			<p class="mb-1">Saturday</p>
			<div class="row">
				<!-- Start time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="saturdaystart" type="time" class="form-control" value="<?php echo $row['saturdaystart']; ?>">
					<div class="valid-feedback">Valid start time</div>
					<div class="invalid-feedback">Invalid start time</div>
				</div>
				<!-- End time -->
				<div class="col-12 col-md-6 col-sm-12 mb-3">
					<input name="saturdayend" type="time" class="form-control" value="<?php echo $row['saturdayend']; ?>">
					<div class="valid-feedback">Valid end time</div>
					<div class="invalid-feedback">Invalid end time</div>
				</div>
			</div>
			<div class="row">
				<!-- Submission -->
				<div class="col-12 col-md-12 mb-3">
					<input type="hidden" name="schedulekey" value="<?php echo $_POST['schedulekey']; ?>"/>
					<button name="updateschedule" type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</form>
		<?php if (isset($_POST['updateschedule'])) { echo $feedback; } ?>
	</div>
</div>
<script>
$(document).ready( function () {
    $('#selectemployeesTable').DataTable();
} );
</script>
<?php
} else {
	echo '<p>maybe some day</p>'; // page can not be viewed
}
} else {
		echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
