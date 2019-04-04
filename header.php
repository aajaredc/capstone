<?php
	require_once 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"> </script>
		<![endif]-->
		<title>Dashboard</title>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Dashboard">

		<!-- Scripts and Libs -->
		<link type="text/css" href="styles/main.css" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
 		<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
	</head>

	<body>
		<!-- Navigation -->
	  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
			<a class="navbar-brand mr-1" href="#">Dashboard</a>
			<?php if ($_SESSION['signedin'] == 1) { ?>
				<span class="navbar-text ml-auto">
					Welcome, <?php echo $_SESSION['employeefirstname']; ?>. <a href="signout.php">Sign Out</a>
				</span>
			<?php } ?>
	  </nav>

		<div id="main-wrapper">
			<ul class="sidebar navbar-nav">
					<?php if ($_SESSION['signedin'] == 1) { ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-fw fa-table"></i>
								<span>Menu</span>
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<h6 class="dropdown-header">Menu Items:</h6>
								<a class="dropdown-item" href="selectmenuitems.php">Select</a>
								<a class="dropdown-item" href="insertmenuitems.php">Insert</a>
								<a class="dropdown-item" href="#">Update</a>
								<div class="dropdown-divider"></div>
								<h6 class="dropdown-header">Menu Types:</h6>
								<a class="dropdown-item" href="#">Select</a>
								<a class="dropdown-item" href="insertmenutypes.php">Insert</a>
								<a class="dropdown-item" href="#">Update</a>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-fw fa-user"></i>
								<span>Employees</span>
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<h6 class="dropdown-header">Employees:</h6>
								<a class="dropdown-item" href="selectemployees.php">Select</a>
								<a class="dropdown-item" href="#">Insert</a>
								<a class="dropdown-item" href="#">Update</a>
								<div class="dropdown-divider"></div>
								<h6 class="dropdown-header">Employee Types:</h6>
								<a class="dropdown-item" href="#">Select</a>
								<a class="dropdown-item" href="insertemployeetypes.php">Insert</a>
								<a class="dropdown-item" href="#">Update</a>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-fw fa-pallet"></i>
								<span>Inventory</span>
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="#">Select</a>
								<a class="dropdown-item" href="#">Insert</a>
								<a class="dropdown-item" href="#">Update</a>
							</div>
						</li>
					<?php } ?>
			</ul>
			<div id="wrapper">
				<div class="container-fluid">
