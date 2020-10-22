position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  background-color: #555;
  color: white;
  font-size: 30px;
  padding: 12px 24px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  text-align: center;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  text-decoration: none;
  overflow: hidden;
  cursor: pointer




  <?php 
 $sql="SELECT Sup_name,Sup_address,Sup_city,Sup_account,Sup_phone,Sup_email,It_type,Scode FROM supplier";
 $result=mysqli_query($con,$sql);
 $resultCheck=mysqli_num_rows($result);

 if($resultCheck>0){
  while ($row =mysqli_fetch_assoc($result)) {
    echo $row['Scode']"<br>";
  }
 }
 ?>



CREATE TABLE_NAME RDetails(
    RId int(250) not null PRIMARY KEY AUTO_INCREMENT,
    ICode varchar(500) not null,
    ITtype varchar(200) not null,
    Sname varchar(500) not null,
    Semail varchar(300) not null,
    IQuantity int (1000) not null
     );

     $Scod    =$_POST['Scode'];
$I_nam =$_POST['I_name'];
$It_typ   =$_POST['It_type'];
$I_cos =$_POST['I_cost'];
$I_de   =$_POST['I_des'];
$Icod   =$_POST['Icode'];
