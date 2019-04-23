<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Locations</li>
	<li class="breadcrumb-item active">Delete</li>
</ol>
<div class="card">
	<div class="card-header">Delete Locations</div>
	<div class="card-body">
		<?php
		// If delete button is pressed
		if (isset($_POST['deletesubmit'])) {
			try {
				// Delete locations
				$sqldelete = 'DELETE FROM locations
											WHERE locationkey=:bvkey';
				$deleteresult = $db->prepare($sqldelete);
				$deleteresult->bindValue('bvkey', $_POST['locationkey']);
				$deleteresult->execute();
				// Delete all tables under that location
				$sqldelete = 'DELETE FROM tables
											WHERE locationkey=:bvkey';
				$deleteresult = $db->prepare($sqldelete);
				$deleteresult->bindValue('bvkey', $_POST['locationkey']);
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
			<table class="table table-bordered" id="selectlocationsTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Address</th>
						<th>Description</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlselectc = "SELECT * FROM locations ORDER BY locationkey ASC";
					$result = $db->prepare($sqlselectc);
					$result->execute();
						while ( $row = $result-> fetch() )
							{
								echo '<tr><td> ' . $row['locationname'] .
								'</td><td> ' . $row['locationaddress'] . '</td><td> ' . $row['locationdescription'] . '</td>
								<td>
									<form name="deleteform" method="post" action="' . $_SERVER['PHP_SELF'] . '">
										<input type="hidden" name="locationkey" value="' . $row['locationkey'] . '"/>
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
    $('#selectlocationsTable').DataTable();
} );
</script>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
