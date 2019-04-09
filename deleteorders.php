<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
		// If delete button is pressed
		if (isset($_POST['deletesubmit'])) {
			// Create delete statement for orders
			$sqldelete = 'DELETE FROM orders
										WHERE orderkey=:bvkey';
			// Prepare and execute
			$deleteresult = $db->prepare($sqldelete);
			$deleteresult->bindValue('bvkey', $_POST['orderkey']);
			$deleteresult->execute();

			// Create delete statement for order details
			$sqldelete = 'DELETE FROM orderdetail
										WHERE orderkey=:bvkey';
			// Prepare and execute
			$deleteresult = $db->prepare($sqldelete);
			$deleteresult->bindValue('bvkey', $_POST['orderkey']);
			$deleteresult->execute();
		}
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Orders</li>
	<li class="breadcrumb-item active">Delete</li>
</ol>
<div class="card">
	<div class="card-header">Delete Orders</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="selectordersTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Date</th>
						<th>Time</th>
						<th>Customer</th>
						<th>Employee</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlselecto = "SELECT * FROM orders
												 INNER JOIN customer ON orders.customerkey = customer.customerkey
												 INNER JOIN employee ON orders.employeekey = employee.employeekey
												 ORDER BY orderkey ASC";
					$result = $db->prepare($sqlselecto);
					$result->execute();
					while ( $row = $result-> fetch() ) {
						echo '<tr><td>' . $row['orderdate'] . '</td><td> ' . $row['ordertime'] .
						'</td><td> ' . $row['customeremail'] . '</td><td> ' . $row['employeeusername'] . '</td>
						<td>
							<form name="deleteform" method="post" action="' . $_SERVER['PHP_SELF'] . '">
								<input type="hidden" name="orderkey" value="' . $row['orderkey'] . '"/>
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
