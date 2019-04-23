<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Customers</a></li>
	<li class="breadcrumb-item active">Select</li>
</ol>
<div class="card">
	<div class="card-header">Select Customers</div>
	<div class="card-body">
		<?php
			if (isset($_POST['deletesubmit'])) {
				try {
					$sqldelete = 'DELETE FROM customer
												WHERE customerkey=:bvkey';
					$deleteresult = $db->prepare($sqldelete);
					$deleteresult->bindValue('bvkey', $_POST['customerkey']);
					$deleteresult->execute();

					// Success
					echo '<div class="alert alert-success" role="alert">Delete successful</div>';
				} catch (Exception $e) {
					// An error occured
					echo '<div class="alert alert-danger" role="alert"><strong>Delete failed: </strong>' . $e->getMessage() . '</div>';
				}
			}
		?>
		<div class="table-responsive">
			<table class="table table-bordered" id="selectcustomersTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone</th>
						<th>Address</th>
						<th>City</th>
						<th>State</th>
						<th>ZIP</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlselectc = "SELECT * FROM customer ORDER BY customerkey ASC";
					$result = $db->prepare($sqlselectc);
					$result->execute();
						while ( $row = $result-> fetch() )
							{
								echo '<tr><td> ' . $row['customerfirstname'] .
								'</td><td> ' . $row['customerlastname'] . '</td><td> ' . $row['customerphone'] .
								'</td><td> ' . $row['customeraddress'] . '</td><td> ' . $row['customercity'] .
								'</td><td> ' . $row['customerstate'] . '</td><td> ' . $row['customerzip'] .
								'</td><td> ' . $row['customeremail'] . '</td>
								<td>
									<form name="deletecustomersform" method="post" action="' . $_SERVER['PHP_SELF'] . '">
										<input type="hidden" name="customerkey" value="' . $row['customerkey'] . '"/>
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
    $('#selectcustomersTable').DataTable();
} );
</script>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
