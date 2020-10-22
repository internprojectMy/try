<?php
 include 'supplyaction.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
  <h1 class="text-center text-dark mt-2">..Supply Details..</h1>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="main.php">Crud App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="supplyindex.php">Suppliers Details</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="UserInterface.php">Search Items</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="category.php">Items Details</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="brand.php">Brand</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="product.php">Product</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="order.php">order</a>
      </li>
    </ul>
  </div>
      </nav>

<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<hr>
			<?php if(isset($_SESSION['response'])){ ?>
			<div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <b><?= $_SESSION['response']; ?></b>
</div>
<?php } unset($_SESSION['response']); ?>

			
		</div>		
</div>
<div class="row">
	<div class="col-md-4">
		<h3 class="text-center text-info">Add Record</h3>
		<form action="supplyaction.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?= $id; ?>">
			<div class="form-group">
				<input type="text" name="name" value="<?= $name; ?>" class="form-control" placeholder=" Enter name" required>
				
			</div>
      <div class="form-group">
        <input type="address" name="address" value="<?= $address
        ; ?>" class="form-control" placeholder=" Enter Address.." required>
        </div>
        <div class="form-group">
        <input type="bank" name="bank" value="<?= $bank; ?>" class="form-control" placeholder=" Enter Bank Name.." required>
        </div>
        <div class="form-group">
        <input type="accountno" name="accountno" value="<?= $accountno; ?>" class="form-control" placeholder=" Enter Account No" required>
        </div>

			<div class="form-group">
				<input type="email" name="email" value="<?= $email; ?>" class="form-control" placeholder=" Enter Email" required>
				</div>
          <div class="form-group">
				<input type="tel" name="phone" value="<?= $phone; ?>" class="form-control" placeholder=" Enter Phone"  required>
				</div>
				<div class="form-group">
					<input type="hidden" name="oldimage" value="<?= $photo; ?>">
					<input type="file" name="image" class="custom-file">
					<img src="<?= $photo; ?>" width="120" class="img-thumbnail">
					</div>
				<div class="form-group">
					<?php if($update==true){ ?>
                     
                     <input type="submit" name="update" class="btn btn-success btn-block" value="Update Record">
                 <?php } else {?>

					<input type="submit" name="add" class="btn btn-primary btn-block" value="Add Record">
				<?php } ?>
					
				</div>


		</form>
		
	</div>
	<div class="col-md-8">
		<?php
           $query="SELECT * FROM crud";
           $stmt=$con->prepare($query);
           $stmt->execute();
           $result=$stmt->get_result();

		  ?>
		<h3 class="text-center text-info">Record of Supply Details..</h3>
		<table class="table table-hover">
    <thead>
      <tr>
        <th>SCode</th>
        <th>Image</th>
        <th>Supply Name</th>
        <th>Supply Email</th>
        <th>Supply Phone</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    	<?php while($row=$result->fetch_assoc()) { ?>
      <tr>
        <td><?= $row['id']; ?></td>
        <td><img src="<?= $row['photo']; ?>" width="25"></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['email']; ?></td>
        <td><?= $row['phone']; ?></td>
        <td>
        <a href="supplydetails.php?details=<?= $row['id']; ?>" class="badge badge-primary p-3">Detils</a>
        <a href="supplyaction.php?delete=<?= $row['id']; ?>" class="badge badge-danger p-3" onclick="return confirm('Do you want to delete this Record ??');">Delete</a>
        <a href="supplyindex.php?edit=<?= $row['id']; ?>" class="badge badge-success p-3">Edit</a>
        </td>
      </tr>
  <?php } ?>
    </tbody>
  </table>
		
	</div>
	
</div>
</div>
</body>
</html>