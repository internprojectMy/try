<?php
session_start();
include 'config.php';

$update=false;
    $id="";
	$groundname="";
	$groundDescrip="";
	$country="";
	$district="";
    $photo="";


if(isset($_POST['add'])){
	$name=$_POST['groundname'];
	$address=$_POST['groundDescrip'];
	$bank=$_POST['country'];
	$accountno=$_POST['district'];

	$photo=$_FILES['image']['name'];
	$upload="uploads/".$photo;

	$query="INSERT INTO slground(groundname,groundDescrip,country,accountno,email,phone,photo) VALUES(?,?,?,?,?,?,?)";
	$stmt=$con->prepare($query);
	$stmt->bind_param("sssssss",$name,$address,$bank,$accountno,$email,$phone,$upload);
	$stmt->execute();
	move_uploaded_file($_FILES['image']['tmp_name'],$upload);

	header('location:supplyindex.php');
    $_SESSION['response']="Successfully Inserted to the database !";
    $_SESSION['res_type']="success";
}
if(isset($_GET['delete'])){
	$id=$_GET['delete'];

    $sql="SELECT photo FROM crud WHERE id=?";
    $stmt2=$con->prepare($sql);
    $stmt2->bind_param("i",$id);
    $stmt2->execute();
    $result2=$stmt2->get_result();
    $row=$result2->fetch_assoc();

    $imagepath=$row['photo'];
    unlink($imagepath);

	$query="DELETE FROM crud WHERE id=?";
	$stmt=$con->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();

	header('location:supplyindex.php');
    $_SESSION['response']="Successfully deleted !!!!!";
    $_SESSION['res_type']="danger";
}

if(isset($_GET['edit'])){
	$id=$_GET['edit'];

	$query="SELECT * FROM crud WHERE id=?";
	$stmt=$con->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();
	$result=$stmt->get_result();
	$row=$result->fetch_assoc();

	$id=$row['id'];
	$name=$row['name'];
	$address=$row['address'];
	$bank=$row['bank'];
	$accountno=$row['accountno'];
	$email=$row['email'];
    $phone=$row['phone'];
    $photo=$row['photo'];

    $update=true;


}
if(isset($_POST['update'])){
	$id=$_POST['id'];
	$name=$_POST['name'];
	$address=$_POST['address'];
	$bank=$_POST['bank'];
	$accountno=$_POST['accountno'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$oldimage=$_POST['oldimage'];

    if(isset($_FILES['image']['name']) && ($_FILES['image']['name']!="")){
    $newimage="uploads/".$_FILES['image']['name'];
    unlink($oldimage);
    move_uploaded_file($_FILES['image'][tmp_name], $newimage);

}
else{
	$newimage=$oldimage;
}
 
 $query="UPDATE crud SET name=?,address=?,bank=?,accountno=?,email=?,phone=?,photo=? WHERE id=?";
 $stmt=$con->prepare($query);
 $stmt->bind_param("sssssssi",$name,$address,$bank,$accountno,$email,$phone,$newimage,$id);
 $stmt->execute();
 $_SESSION['response']="Updated Successfully !!";
 $_SESSION['res_type']="primary";
 header('location:supplyindex.php');
}
if(isset($_GET['details'])){
	$id=$_GET['details'];
	$query="SELECT * FROM crud WHERE id=?";
	$stmt=$con->prepare($query);
	$stmt->bind_param("i",$id);
	$stmt->execute();
	$result=$stmt->get_result();
	$row=$result->fetch_assoc();

	$vid=$row['id'];
	$vname=$row['name'];
	$vaddress=$row['address'];
	$vbank=$row['bank'];
	$vaccountno=$row['accountno'];
	$vemail=$row['email'];
	$vphone=$row['phone'];
	$vphoto=$row['photo'];
}

?>
