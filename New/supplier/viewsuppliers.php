<?php require_once('../dbConnect.php');?>

<?php
$query="SELECT Sup_name,Sup_address,Sup_city,Sup_account,Sup_phone,Sup_email,It_type,Scode FROM supplier";
$result_set= mysqli_query($con,$query);
if($result_set){
	//echo "Query Success";
	echo mysqli_num_rows($result_set)."Records found. <hr> ";
	$table='<table>';
	$table.='<tr><th>Numbers</th>
	            <th>Name</th>
		          <th>Address</th>
		          <th>City</th>
		          <th>Account</th>
		          <th>Phone</th>
		          <th>E-mail</th>
		          <th>Type</th>
		          <th>Code</th>
              <th>Action</th></tr>';
		        $coun=1;
while ($record=mysqli_fetch_assoc($result_set)) {
    $table.='<tr>';
    $table.='<td>'.$coun.'</td>';
    $table.='<td>'.$record['Sup_name'].'</td>';
    $table.='<td>'.$record['Sup_address'].'</td>';
    $table.='<td>'.$record['Sup_city'].'</td>';
    $table.='<td>'.$record['Sup_account'].'</td>';
    $table.='<td>'.$record['Sup_phone'].'</td>';
    $table.='<td>'.$record['Sup_email'].'</td>';
    //$table.='<td>'.$record['Sup_data'].'</td>';
    $table.='<td>'.$record['It_type'].'</td>';
    $table.='<td>'.$record['Scode'].'</td>';
    
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
		<h1> Suppliers Details List page</h1>
	</header>

<?php echo $table;?>
</body>
</html>
<?php mysqli_close($con);?>