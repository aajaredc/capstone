<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Customers</a></li>
	<li class="breadcrumb-item active">Update</li>
</ol>
<div class="card">
	<div class="card-header">Update Customers</div>
	<div class="card-body">
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
									<form name="updatecustomersselectionform" method="post" action="updatecustomersform.php">
										<input type="hidden" name="customerkey" value="' . $row['customerkey'] . '"/>
										<input type="hidden" name="firstname" value="' . $row['customerfirstname'] . '"/>
										<input type="hidden" name="lastname" value="' . $row['customerlastname'] . '"/>
										<input type="hidden" name="phone" value="' . $row['customerphone'] . '"/>
										<input type="hidden" name="email" value="' . $row['customeremail'] . '"/>
										<input type="hidden" name="address" value="' . $row['customeraddress'] . '"/>
										<input type="hidden" name="city" value="' . $row['customercity'] . '"/>
										<input type="hidden" name="state" value="' . $row['customerstate'] . '"/>
										<input type="hidden" name="zip" value="' . $row['customerzip'] . '"/>
										<input type="submit" name="updatecustomerselection" value="Update"/>
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
