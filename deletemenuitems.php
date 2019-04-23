<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">Menu</li>
	<li class="breadcrumb-item">Menu Items</li>
	<li class="breadcrumb-item active">Delete</li>
</ol>
<div class="card">
	<div class="card-header">Delete Menu Items</div>
	<div class="card-body">
		<?php
		// If delete button is pressed
		if (isset($_POST['deletesubmit'])) {
			try {
				// Create delete statement
				$sqldelete = 'DELETE FROM menuitem
											WHERE menuitemkey=:bvkey';
				// Prepare and execute
				$deleteresult = $db->prepare($sqldelete);
				$deleteresult->bindValue('bvkey', $_POST['menuitemkey']);
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
			<table class="table table-bordered" id="selectmenuitemsTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Type</th>
						<th>Price</th>
						<th>Count</th>
						<th>Description</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlselecti = "SELECT * FROM menuitem INNER JOIN menutype ON menuitem.menutypekey = menutype.menutypekey ORDER BY menuitemkey ASC";
					$result = $db->prepare($sqlselecti);
					$result->execute();
						while ( $row = $result-> fetch() )
							{
								echo '<tr><td> ' . $row['menuitemname'] .
								'</td><td> ' . $row['menutypename'] . '</td><td> ' . $row['menuitemprice'] . '</td>
								<td> ' . $row['menuitemcount'] . '</td><td> ' . $row['menuitemdesc'] . '</td>
								<td>
									<form name="deleteform" method="post" action="' . $_SERVER['PHP_SELF'] . '">
										<input type="hidden" name="menuitemkey" value="' . $row['menuitemkey'] . '"/>
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
    $('#selectmenuitemsTable').DataTable();
} );
</script>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
