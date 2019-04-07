<?php
	session_start();
	require_once 'header.php';

	if ($_SESSION['signedin'] == 1) {

		$formfield['fforderkey'] = $_POST['orderkey'];
		$formfield['ffmenuitemkey'] = $_POST['menuitemkey'];
		$formfield['fforderitemprice'] = $_POST['orderitemprice'];

		if (isset($_POST['ODEnter']))
		{
			$sqlinsert = 'INSERT INTO orderdetail (orderkey, menuitemkey,
					orderdetailprice) VALUES (:bvorderkey, :bvprodid, :bvorderitemprice)';

				//Prepares the SQL Statement for execution
				$stmtinsert = $db->prepare($sqlinsert);
				//Binds our associative array variables to the bound
				//variables in the sql statement
				$stmtinsert->bindvalue(':bvorderkey', $formfield['fforderkey']);
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

<?php if(isset($_POST['submitorder'])) { ?>
	<!-- Order Successful -->
	<div class="card">
		<div class="card-header">Order Successful</div>
		<div class="card-body">
			<p>Order successful! :)</p>
		</div>
	</div>
<?php } else { ?>
	<!-- Menu Items Selection -->
	<div class="card" style="margin-bottom: 1rem;">
		<div class="card-header">Select Items for Order Number <?php echo $formfield['fforderkey']; ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="selectmenuitemsTable" width="100%" cellspacing="0">
					<?php
						$sqlselectc = "SELECT * from menutype";
						$resultc = $db->prepare($sqlselectc);
						$resultc->execute();
						echo '<tr>';
						while ($rowc = $resultc->fetch()) {
							echo '<th valign="top" align="center">' . $rowc['menutypename'] . '<br />';
							echo '<table>';
							$sqlselectp = "SELECT * from menuitem WHERE menutypekey = :bvtypekey";
							$resultp = $db->prepare($sqlselectp);
							$resultp->bindvalue(':bvtypekey', $rowc['menutypekey']);
							$resultp->execute();

							while ($rowp = $resultp->fetch()) {
								echo '<tr><td>';
								echo '<form action = "' . $_SEVER['PHP_SELF'] . '" method="post">';
								echo '<input type="hidden" name="orderkey" value="' . $formfield['fforderkey'] . '" />';
								echo '<input type="hidden" name="menuitemkey" value="' . $rowp['menuitemkey'] . '" />';
								echo '<input type="hidden" name="orderitemprice" value="' . $rowp['menuitemprice'] . '" />';
								echo '<input style="width: 100%;" type="submit" name="ODEnter" value="' .$rowp['menuitemname'] . '"/>';
								echo '</form>';
								echo '</td></tr>';
							}
							echo '</table></th>';
						}
						echo '</tr>';
					?>
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
						$sqlselecto = 'SELECT *
													 FROM orderdetail
													 INNER JOIN menuitem ON menuitem.menuitemkey=orderdetail.menuitemkey
													 WHERE orderkey=:bvorderkey';
						$resulto = $db->prepare($sqlselecto);
						$resulto->bindValue(':bvorderkey', $formfield['fforderkey']);
						$resulto->execute();

						$ordertotal = 0;

						while ($rowo = $resulto->fetch()){
						$ordertotal = $ordertotal + $rowo['orderdetailprice'];

						echo '<tr><td style="vertical-align: middle;">' . $rowo['menuitemname'] . '</td><td style="vertical-align: middle;">' . $rowo['orderdetailprice'] . '</td>';
						echo '<td style="vertical-align: middle;">' . $rowo['orderdetailnote'] . '</td><td>';
						echo '<form action = "' . $_SERVER['PHP_SELF'] . '" method = "post">';
						echo '<input type = "hidden" name = "orderkey" value = "'. $formfield['fforderkey'] .'">';
						echo '<input type = "hidden" name = "orderitemid" value = "'. $rowo['orderdetailkey'] .'">';
						echo '<input type="submit" name="NoteEntry" value="Update">';
						echo '</form></td><td>';
						echo '<form action = "' . $_SERVER['PHP_SELF'] . '" method = "post">';
						echo '<input type = "hidden" name = "orderkey" value = "'. $formfield['fforderkey'] .'">';
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
							AND orderdetail.orderkey = :bvorderkey
							AND orderdetail.orderdetailKey = :bvorderitemid";
						$resultoi = $db->prepare($sqlselectoi);
						$resultoi->bindValue(':bvorderkey', $formfield['fforderkey']);
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
										<input type = "hidden" name = "orderkey" value = "'. $formfield['fforderkey'] .'">
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
			<form name="ordersubmitform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<button name="submitorder" type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
<?php } ?>

<script>
$(document).ready( function () {
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
