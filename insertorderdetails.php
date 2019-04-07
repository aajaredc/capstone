<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {

		$formfield['fforderid'] = $_POST['orderid'];
		$formfield['ffmenuitemkey'] = $_POST['menuitemkey'];
		$formfield['fforderitemprice'] = $_POST['orderitemprice'];

		if (isset($_POST['OIEnter']))
		{
			$sqlinsert = 'INSERT INTO orderdetail (orderkey, menuitemkey,
					orderdetailprice) VALUES (:bvorderkey, :bvprodid, :bvorderitemprice)';

				//Prepares the SQL Statement for execution
				$stmtinsert = $db->prepare($sqlinsert);
				//Binds our associative array variables to the bound
				//variables in the sql statement
				$stmtinsert->bindvalue(':bvorderkey', $formfield['fforderid']);
				$stmtinsert->bindvalue(':bvprodid', $formfield['ffmenuitemkey']);
				//1
				$stmtinsert->bindvalue(':bvorderitemprice', $formfield['fforderitemprice']);

				//Runs the insert statement and query
				$stmtinsert->execute();
		}

		if (isset($_POST['DeleteItem']))
		{
			$sqldelete = 'DELETE FROM orderdetail
						WHERE orderdetailkey = :bvorderdetailkey';
			$stmtdelete = $db->prepare($sqldelete);
			$stmtdelete->bindvalue(':bvorderdetailkey', $_POST['orderdetailkey']);
			$stmtdelete->execute();
		}

		if (isset($_POST['UpdateItem']))
		{
			$sqlupdateoi = 'Update orderdetail
						set orderdetailprice = :bvitemprice, orderdetailnote = :bvitemnotes
						WHERE orderdetailkey = :bvorderitemid';
			$stmtupdateoi = $db->prepare($sqlupdateoi);
			$stmtupdateoi->bindvalue(':bvorderitemid', $_POST['orderitemid']);
			$stmtupdateoi->bindvalue(':bvitemprice', $_POST['newprice']);
			$stmtupdateoi->bindvalue(':bvitemnotes', $_POST['newnote']);
			$stmtupdateoi->execute();
		}
?>

<!-- Menu Items Selection -->
<div class="card" style="margin-bottom: 1rem;">
	<div class="card-header">Select Items for Order Number <?php echo $formfield['fforderid']; ?></div>
	<div class="card-body">
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
									<form method="post" action="'. $_SERVER['PHP_SELF']. '">
										<input type = "hidden" name = "orderid" value = "'. $formfield['fforderid'] .'">
										<input type = "hidden" name = "menuitemkey" value = "'. $row['menuitemkey'] .'">
										<input type = "hidden" name = "orderitemprice" value = "'. $row['menuitemprice'] .'">
										<input type="submit" name="OIEnter" value="Add Item"/>
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

<!-- Order Details -->
<div class="card">
	<div class="card-header">Order Details</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="orderdetailsTable" width="100%" cellspacing="0">
				<tr>
					<th>Item</th>
					<th>Price</th>
					<th>Notes</th>
					<th></th>
					<th></th>
				</tr>
				<?php
					$sqlselecto = "SELECT * FROM orderdetail WHERE orderkey=:bvorderkey";
					$resulto = $db->prepare($sqlselecto);
					$resulto->bindValue(':bvorderkey', $formfield['fforderid']);
					$resulto->execute();

					$ordertotal = 0;

					while ($rowo = $resulto->fetch() )
					{
					$ordertotal = $ordertotal + $rowo['orderdetailprice'];

					echo '<tr><td>' . $rowo['menuitemkey'] . '</td><td>' . $rowo['orderdetailprice'] . '</td>';
					echo '<td>' . $rowo['orderdetailnote'] . '</td><td>';
					echo '<form action = "' . $_SERVER['PHP_SELF'] . '" method = "post">';
					echo '<input type = "hidden" name = "orderid" value = "'. $formfield['fforderid'] .'">';
					echo '<input type = "hidden" name = "orderitemid" value = "'. $rowo['orderdetailkey'] .'">';
					echo '<input type="submit" name="NoteEntry" value="Update">';
					echo '</form></td><td>';
					echo '<form action = "' . $_SERVER['PHP_SELF'] . '" method = "post">';
					echo '<input type = "hidden" name = "orderid" value = "'. $formfield['fforderid'] .'">';
					echo '<input type = "hidden" name = "orderdetailkey" value = "'. $rowo['orderdetailkey'] .'">';
					echo '<input type="submit" name="DeleteItem" value="Delete">';
					echo '</form></td></tr>';
					}
				?>
			<tr>
				<th>Total:</th>
				<th><?php echo $ordertotal; ?></th>
			</tr>
			</table>

			<table class="table table-bordered">
				<?php
					if (isset($_POST['NoteEntry']))
					{
					$sqlselectoi = "SELECT orderdetail.*, menuitem.menuitemname
						from orderdetail, menuitem
						WHERE menuitem.menuitemkey = orderdetail.menuitemkey
						AND orderdetail.orderkey = :bvorderid
						AND orderdetail.orderdetailKey = :bvorderitemid";
					$resultoi = $db->prepare($sqlselectoi);
					$resultoi->bindValue(':bvorderid', $formfield['fforderid']);
					$resultoi->bindvalue(':bvorderitemid', $_POST['orderitemid']);
					$resultoi->execute();
					$rowoi = $resultoi->fetch();

					echo '
					<form action = "' . $_SERVER['PHP_SELF'] . '" method = "post">
						<table class="table table-bordered">
							<tr>
								<th>Price</th>
								<td><input type = "text" name ="newprice" value="'. $rowoi['orderdetailprice'] . '"></td>
							</tr>
							<tr>
								<th>Notes</th>
								<td><input type="text" name="newnote" value ="'. $rowoi['orderdetailnote'] . '"></td>
							</tr>
							<tr>
								<td>
									<input type = "hidden" name = "orderid" value = "'. $formfield['fforderid'] .'">
									<input type = "hidden" name = "orderitemid" value = "'. $rowoi['orderdetailkey'] .'" >
									<input type="submit" name="UpdateItem" value="Update"/>
								</td>
							</tr>
						</table>
					</form>
					';
					}
					?>
			</table>
		</div>
	</div>
</div>

<script>
$(document).ready( function () {
		$('#selectmenuitemsTable').DataTable();
		$('#orderdetails').DataTable();
} );
</script>
<?php
}
else {
	echo '<p>You are not signed in. Click <a href="signin.php">here</a> to sign in.</p>';
}
	require_once 'footer.php';
?>
