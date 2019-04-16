<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
		// If delete button is pressed
		if (isset($_POST['deletesubmit'])) {
			// Create delete statement for tickets
			$sqldelete = 'DELETE FROM tickets
										WHERE ticketkey=:bvkey';
			// Prepare and execute
			$deleteresult = $db->prepare($sqldelete);
			$deleteresult->bindValue('bvkey', $_POST['ticketkey']);
			$deleteresult->execute();

			// Create delete statement for ticket details
			$sqldelete = 'DELETE FROM ticketdetail
										WHERE ticketkey=:bvkey';
			// Prepare and execute
			$deleteresult = $db->prepare($sqldelete);
			$deleteresult->bindValue('bvkey', $_POST['ticketkey']);
			$deleteresult->execute();
		}
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Tickets</li>
	<li class="breadcrumb-item active">Delete</li>
</ol>
<div class="card">
	<div class="card-header">Delete Tickets</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="selectordersTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Date</th>
						<th>Time</th>
						<th>Type</th>
						<th>Customer</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlselecto = "SELECT * FROM tickets
												 INNER JOIN customer ON tickets.customerkey = customer.customerkey
												 ORDER BY ticketkey ASC";
					$result = $db->prepare($sqlselecto);
					$result->execute();
					while ( $row = $result-> fetch() ) {
						echo '<tr><td>' . $row['ticketdate'] . '</td><td> ' . $row['tickettime'] .
						'</td><td> ' . $row['tickettype'] . '</td><td> ' . $row['customeremail'] . '</td>
						<td>
							<form name="deleteform" method="post" action="' . $_SERVER['PHP_SELF'] . '">
								<input type="hidden" name="ticketkey" value="' . $row['ticketkey'] . '"/>
								<input type="submit" name="deletesubmit" value="Delete"/>
							</form>
						</td>';
					}
					echo '</tr>';
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
$(document).ready( function () {
    $('#selectordersTable').DataTable();
} );
</script>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
