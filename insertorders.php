<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Orders</a></li>
	<li class="breadcrumb-item active">Insert</li>
</ol>

<div class="card">
	<div class="card-header">Select Customer</div>
	<div class="card-body">
		<?php if (isset($_POST['insertordersubmit'])) { ?>
			<?php
				// Date time
				date_default_timezone_set('UTC');
				$date = date('Y-m-d');
				$time = date('h:i:s');

				//enter data into database
				$sqlinsert = 'INSERT INTO orders (customerkey, orderdate, ordertime, employeekey)
								VALUES (:bvcu, :bvdate, :bvtime, :bvem)';
				$stmtinsert = $db->prepare($sqlinsert);
				$stmtinsert->bindvalue(':bvcu', $_POST['customerkey']);
				$stmtinsert->bindvalue(':bvdate', $date);
				$stmtinsert->bindvalue(':bvtime', $time);
				$stmtinsert->bindvalue(':bvem', $_SESSION['employeekey']);
				$stmtinsert->execute();

				$sqlmax = "SELECT MAX(orderkey) AS maxid from orders";
				$resultmax = $db->prepare($sqlmax);
				$resultmax->execute();
				$rowmax = $resultmax->fetch();
				$maxid = $rowmax["maxid"];
			?>
			<p>Selection successful. Please proceed to enter items.</p>
			<form method="post" action="insertorderdetails.php">
				<input type="hidden" name="orderkey" value = "<?php echo $maxid; ?>" />
				<input type="submit" name="ordersubmit" value="Proceed" />
			</form>
		<?php } else { ?>
			<div class="table-responsive">
				<table class="table table-bordered" id="selectcustomersTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sqlselectc = "SELECT * FROM customer WHERE 1";
						$result = $db->prepare($sqlselectc);
						$result->execute();
							while ( $row = $result-> fetch() )
								{
									echo '<tr><td>' . $row['customerfirstname'] . '</td><td> ' . $row['customerlastname'] .
									'</td><td> ' . $row['customerphone'] . '</td><td> ' . $row['customeremail'] . '</td>
									<td>
										<form name="insertorderform" method="post" action="' . $_SERVER['PHP_SELF'] . '">
											<input type="hidden" name="customerkey" value="' . $row['customerkey'] . '"/>
											<input type="submit" name="insertordersubmit" value="Select"/>
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
