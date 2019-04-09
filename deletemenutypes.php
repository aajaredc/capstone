<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
		// If delete button is pressed
		if (isset($_POST['deletesubmit'])) {
			// Create delete statement
			$sqldelete = 'DELETE FROM menutype
										WHERE menutypekey=:bvkey';
			// Prepare and execute
			$deleteresult = $db->prepare($sqldelete);
			$deleteresult->bindValue('bvkey', $_POST['menutypekey']);
			$deleteresult->execute();
		}
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Menu</li>
	<li class="breadcrumb-item">Menu Types</li>
	<li class="breadcrumb-item active">Delete</li>
</ol>
<div class="card">
	<div class="card-header">Delete Menu Types</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="selectmenutypesTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlselecti = "SELECT * FROM menutype WHERE 1 ORDER BY menutypekey ASC";
					$result = $db->prepare($sqlselecti);
					$result->execute();
					while ( $row = $result-> fetch() ) {
						echo '<tr><td>' . $row['menutypename'] . '</td><td> ' . $row['menutypedescription'] . '</td>
						<td>
							<form name="deleteform" method="post" action="' . $_SERVER['PHP_SELF'] . '">
								<input type="hidden" name="menutypekey" value="' . $row['menutypekey'] . '"/>
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
    $('#selectmenutypesTable').DataTable();
} );
</script>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
