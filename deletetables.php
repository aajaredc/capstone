<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
		// If delete button is pressed
		if (isset($_POST['deletesubmit'])) {
			// Create delete statement
			$sqldelete = 'DELETE FROM tables
										WHERE tablekey=:bvkey';
			// Prepare and execute
			$deleteresult = $db->prepare($sqldelete);
			$deleteresult->bindValue('bvkey', $_POST['tablekey']);
			$deleteresult->execute();
		}
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Locations</li>
	<li class="breadcrumb-item">Tables</li>
	<li class="breadcrumb-item active">Delete</li>
</ol>
<div class="card">
	<div class="card-header">Delete Tables</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="selecttablesTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Location</th>
						<th>Description</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlselectt = "SELECT * FROM tables INNER JOIN locations ON tables.locationkey = locations.locationkey ORDER BY tablekey ASC";
					$result = $db->prepare($sqlselectt);
					$result->execute();
						while ( $row = $result-> fetch() )
							{
								echo '<tr><td> ' . $row['tablename'] .
								'</td><td> ' . $row['locationname'] . '</td><td> ' . $row['tabledescription'] . '</td>
								<td>
									<form name="deleteform" method="post" action="' . $_SERVER['PHP_SELF'] . '">
										<input type="hidden" name="tablekey" value="' . $row['tablekey'] . '"/>
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
    $('#selecttablesTable').DataTable();
} );
</script>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
