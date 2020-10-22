<?php require_once('../dbConnect.php');?>

<?php
$query="SELECT Scode,I_name,It_type,I_cost,I_des,Icode FROM product";
$result_set= mysqli_query($con,$query);
if($result_set){
	//echo "Query Success";
	echo mysqli_num_rows($result_set)."Records found. <hr> ";
	$table='<table>';
	$table.='<tr><th>Numbers</th>
	            <th>Supplier Code</th>
		        <th>Item Name</th>
		        <th>Item Type</th>
		        <th>Unit Cost</th>
		        <th>Item Description</th>
		        <th>Item Code</th>
            <th>Action</th></tr>';

		         $coun=1;
while ($record=mysqli_fetch_assoc($result_set)) {
    $table.='<tr>';
    $table.='<td>'.$coun.'</td>';
    $table.='<td>'.$record['Scode'].'</td>';
    $table.='<td>'.$record['I_name'].'</td>';
    $table.='<td>'.$record['It_type'].'</td>';
    $table.='<td>'.$record['I_cost'].'</td>';
    $table.='<td>'.$record['I_des'].'</td>';
    $table.='<td>'.$record['Icode'].'</td>';
    //$table.='<td>''</td>';

    //$table.='<td>'.$record[''].'</td>';
    //$table.='<td>'.$record['It_type'].'</td>';
    //$table.='<td>'.$record['Scode'].'</td>';

    $table.='</tr>';
   $coun++;
}
$table.='</table>';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<style>
 table{
 	width: 75%;
 	margin:30px auto;
 	border-collapse:collapse;
 	text-align: left;
 	color:#588c7e; 
 }
 tr{
    border-bottom: 1px solid #cbcbcb;
    background-color: #f2f2f2;
   }
 th,td{
       border: none;
       height: 20px;
       padding: 15px;
      }
 tr:hover{
           background:#f5f5f5;
         }

</style>
</head>
<body>
	<header>
		<h1> Supplier's Item List page</h1>
	</header>
<div class="topnav">
  <a class="active" href="supplyAdd.php">Add new Suppliers</a>
  <a href="viewsuppliers.php">List of Suppliers</a>
  <a href="itemAdd.php">Add new Items</a>
  <a href="ListItem.php">List of Items</a>
  <a href="viewItem.php">View List of Items</a>
</div>
<header>
		<h1> Supplier's Item List page</h1>
	</header>
<?php echo $table;?>
</body>
</html>
<?php mysqli_close($con);?>