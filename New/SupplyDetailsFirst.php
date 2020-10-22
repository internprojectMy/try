<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

  *{
  margin:0;
  }
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

    
.heading{
    width: 100%;
    height:11%;
    background-color: #3498db;
    top: 0%;
    text-align: center;
    font-size: 50px;
    color: white;
}
.line1{
    width:100%;
    height:6%;
    background-color: #3498db;
    transform: translateY(10px);
}
.btnhome{
    background-color: #de0e1d;
    border: none;
    color: white;
    width: 10%;
    height: 100%;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    transform: translateX(200px);
}
.btnlogout{
    background-color: #de0e1d;
    border: none;
    color: white;
    width: 10%;
    height: 100%;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    transform: translateX(800px);
}
.line2{
    width:100%;
    height:20%;
    
    background-color: white;
    transform: translateY(50px);
}

body, html {
  height: 100%;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.hero-image {
  background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/SInterfa.jpg");
  height: 50%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

.hero-text {
  text-align: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color:#00FF00;
  
}


* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.column {
  float: left;
  width: 30%;
  height:350px;
  padding: 15px 5px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #C0C0C0;
  
}
.container {
  position: relative;
  width: 100%;
  max-width: 400px;
}

.container img {
  width: 100%;
  height: auto;
}

.container .btn {
 position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  background-color:#DAF7A6 ;
  color: #900C3F;
  font-size: 30px;
  padding: 12px 24px;
  border: none;
  border-radius: 5px;
  text-align: center;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  text-decoration: none;
  overflow: hidden;
  cursor: pointer;
}

.container.btn:after {
  content: "";
  background: #90EE90;
  display: block;
  position: absolute;
  padding-top: 300%;
  padding-left: 350%;
  margin-left: -20px!important;
  margin-top: -120%;
  opacity: 0;
  transition: all 0.8s
}
.container.btn:active:after {
  padding: 0;
  margin: 0;
  opacity: 1;
  transition: 0s
}




</style>
</head>
<body>
          <div class="heading">
           Dash Board
           </div>
          <div class="line1">
                <input class="btnhome" type="button" value="home" onclick="window.location.href = 'adminhome.php';">
                <input class="btnlogout" type="button" value="logout" onclick="window.location.href = 'adminlogin.php';">
        </div>


<div class="hero-image">
  <div class="hero-text">
    <h1 style="font-size:80px">Supply Management Setting Details</h1>
  </div>
</div>



<div class="row">
  <div class="column">
    <div class="card">
     <div class="container">
     <img src="images/SInter4.jpg" alt="Snow" style="width:100%">
     <button class="btn"><a href="Supply/AddNewSupplier.php">Add Suppliers</a></button>
    </div>
    </div>
   </div>

  <div class="column">
    <div class="card"> 
     <div class="container">
     <img src="images/SInter1.jpg" alt="Snow" style="width:100%">
     <button class="btn"><a href="Supply/NewSuppliersList.php" >List Of Suppliers</a></button>
    </div>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
      <div class="container">
     <img src="images/SInter2.jpg" alt="Snow" style="width:100%">
     <button class="btn"><a href="items/finalitemAdd.php">Add New Items</a></button>
    </div>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
       <div class="container">
     <img src="images/SInter3.jpg" alt="Snow" style="width:120%">
     <button class="btn"><a href="items/ItemConnect.php">List Of New Items</a></button>
    </div>
    </div>
  </div>
   <div class="column">
    <div class="card">
       <div class="container">
     <img src="images/SInter5.jpg" alt="Snow" style="width:120%">
     <button class="btn"><a href="Supply/ReOrder.php">Request Order</a></button>
    </div>
    </div>
  </div>
  <div class="column">
    <div class="card">
       <div class="container">
     <img src="images/SInter7.jpg" alt="Snow" style="width:70%">
     <button class="btn"> <a href="Supply/testorder.php" >Order details List</a></button>
    </div>
    </div>
  </div>


</div>

</body>
</html>
