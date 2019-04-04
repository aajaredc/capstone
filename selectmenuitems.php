<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="#">Menu</a></li>
	<li class="breadcrumb-item"><a href="#">Menu Items</a></li>
	<li class="breadcrumb-item active">Select</li>
</ol>
<div class="card">
	<div class="card-header">Select Menu Items</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="selectmenuitemsTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Key</th>
						<th>Name</th>
						<th>Type</th>
						<th>Price</th>
						<th>Count</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlselecti = "SELECT * FROM menuitem INNER JOIN menutype ON menuitem.menutypekey = menutype.menutypekey ORDER BY menuitemkey ASC";
					$result = $db->prepare($sqlselecti);
					$result->execute();
						while ( $row = $result-> fetch() )
							{
								echo '<tr><td>' . $row['menuitemkey'] . '</td><td> ' . $row['menuitemname'] .
								'</td><td> ' . $row['menutypename'] . '</td><td> ' . $row['menuitemprice'] . '</td>
								<td> ' . $row['menuitemcount'] . '</td><td> ' . $row['menuitemdesc'] . '</td>';
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
