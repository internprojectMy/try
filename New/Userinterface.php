<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  *{
  margin:0;
  }
html,body{
  height:100%;
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
* {box-sizing: border-box;}
body {
font-family: Verdana, sans-serif;
background-color: #f1f1f1;
font-family: Arial;
}
h1{
   text-align: center;
   font-size: 60px;
}

.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  margin: auto;
  padding-top: 20px;
  padding-right: 10px;
  padding-bottom: 50px;
  padding-left: 10px;
}


/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
/* Center website */
.main {
  max-width: 1000px;
  margin: auto;
}


.row {
  margin: 10px -200px;
}

/* Add padding BETWEEN each column */
.row,
.row > .column {
  padding: 10px;
}

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 20%;
  display: none; /* Hide all elements by default */
}

/* Clear floats after rows */ 
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Content */
.content {
  background-color: white;
  padding: 2px;
  width: 100%;
  height: 450px;

}

/* The "show" class is added to the filtered elements */
.show {
  display: block;
}

/* Style the buttons */
.btn {
  font-size:150%;
  border: none;
  outline: none;
  padding: 25px 25px;
  background-color: white;
  cursor: pointer;
  border-radius: 12px;
}

.btn:hover {
  background-color: #ddd;
}

.btn.active {
  font-size:150%;
  background-color: #666;
  color: white;
  border-radius: 12px;
}
</style>
</head>
<body>
   <div class="heading">Dash Board</div>

        <div class="line1">
                <input class="btnhome" type="button" value="home" onclick="window.location.href = 'adminhome.php';">
                <input class="btnlogout" type="button" value="logout" onclick="window.location.href = 'adminlogin.php';">
        </div><br><br>

<h1>Supply Product</h1>

<div class="slideshow-container">

<div class="mySlides fade">
  <img src="images/product1.jpg" style="width:100%">
</div>

<div class="mySlides fade">
  <img src="images/product3.jpg" style="width:100%">
</div>

<div class="mySlides fade">
  <img src="images/product5.jpg" style="width:100%">
</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>

<!--end of the slide show-->
<!-- MAIN (Center website) -->
<div class="main">


<hr>
<div id="myBtnContainer">
  <button class="btn active" onclick="filterSelection('all')"> Show all</button>
  <button class="btn" onclick="filterSelection('oils')"> Oils</button>
  <button class="btn" onclick="filterSelection('tyres')"> Tyres</button>
  <button class="btn" onclick="filterSelection('paints')"> Paints</button>
</div>

<!-- Portfolio Gallery Grid -->
<div class="row">
  <div class="column oils">
    <div class="content">
      <img src="images/oil1.jpg" alt="Mountains" style="width:100%">
      <h4>Caltex</h4>
      <p>Havoline®Super 4T SAE 20W-40 products.with Havoline C.O.R.E. Technology lubricates, protects, and cleans as you ride.Explore our range of motorcycle engine oils including mineral, semi and fully synthetic. Available in different SAE grades: 5w40, 10w40, 15W-40, 20w40
        <br><br><a href="https://chevron.lk/product-list/">More Details</a></p>
    </div>
  </div>
  <div class="column oils">
    <div class="content">
    <img src="images/oil2.jpg" alt="Lights" style="width:100%">
      <h4>Delo® Gear EP-5</h4>
      <p>Delo® Gear EP-5 are multipurpose lubricants. They are made from paraffinic base stocks and contain a carefully balanced additive package to provide gear protection and long lubricant life</p>
    </div>
  </div>
  <div class="column oils">
    <div class="content">
    <img src="images/oil5.jpg" alt="Nature" style="width:100%">
      <h4>Kixx G SJ</h4>
      <p>Kixx G SJ is a high quality engine oil designed to meet the requirements of passenger car and light truck engines where API SJ performance is required.</p>
    </div>
  </div>
  <div class="column oils">
    <div class="content">
    <img src="images/oil6.jpg" alt="Nature" style="width:100%">
      <h4>caltex grease</h4>
      <p></p>
    </div>
  </div>
  <div class="column oils">
    <div class="content">
    <img src="images/oil7.jpg" alt="Nature" style="width:100%">
      <h4>Caltex Delo Grease</h4>
      <p>
Delo greases combine lubricating oils with thickeners to enable every greased part to operate smoothly, ensuring high performance and long-life protection.</p>
    </div>
  </div>
  
  <div class="column tyres">
    <div class="content">
      <img src="images/tyres1.jpg" alt="Car" style="width:100%">
      <h4>Maxxis Products</h4>
      <p>hether you’re riding on hardpack, loose dirt or mud, Maxxis has the mountain bike tire for you. There’s nothing better than mountain biking on Maxxis.</p>
    </div>
  </div>
  <div class="column tyres">
    <div class="content">
    <img src="images/tyres2.jpg" alt="Car" style="width:70%">
      <h4>Openeo</h4>
      <p>We present an offer for the best-selling motorcycle tyres in our store. These are the most popular models chosen by our clients. Check whether some of the following proposals meet your expectations.</p>
    </div>
  </div>
  <div class="column tyres">
    <div class="content">
    <img src="images/tyres6.jpg" alt="Car" style="width:100%">
      <h4>CEAT</h4>
      <p>Dual Compound Technology
Wobble-free and comfortable ride
Attractive angular tread block design</p>
    </div>
  </div>
<div class="column tyres">
    <div class="content">
    <img src="images/tyres4.jpg" alt="Car" style="width:100%">
      <h4>Kingrun</h4>
      <p>tyres have been independently tested and the results are conclusive. Up Against the name 'Name Brand' tyres, Kingrun's Phantom K3000 managed to outperform on noise, and Wet Braking Distances.</p>
    </div>
  </div>
<div class="column tyres">
    <div class="content">
    <img src="images/tyres5.jpg" alt="Car" style="width:100%">
      <h4>Lexani Tire</h4>
      <p> Lexani Tire recognizes the need for a premium performing product. And with an extensive portfolio of tire options to accommodate today's most demanding and discerning drivers, you can rest assured that Lexani has the appropriate tire to confidently satisfy your needs for whatever vehicle you drive.</p>
    </div>
  </div>


  <div class="column paints">
    <div class="content">
      <img src="images/paint2.jpg" alt="Car" style="width:70%">
      <h4>Starclass 2K Causeway</h4>
      <p>Starclass 2K Auto Paint is a two component high
performance polyurethane acrylic paint with superior gloss
& excellent weather resistance properties. High stain
resistance, abrasion resistance, gasoline resistance &
unique hardness, specially recommended for automotive
refinish . </p>
    </div>
  </div>
  <div class="column paints">
    <div class="content">
    <img src="images/Paint4.jpg" alt="Car" style="width:80%">
      <h4>Sunny 2K PU Rapid Primer(2 1)</h4>
      <p>This is rapid drying, high solid two component polyurethane primer for automotive & industrial use. This has excellent filling and sanding properties. It will level out minor irregularities in the substrate and improve adhesion of the top coat.</p>
    </div>
  </div>
  <div class="column paints">
    <div class="content">
    <img src="images/Paint5.jpg" alt="Car" style="width:80%">
      <h4>Causeway auto body clear</h4>
      <p>two component high solid economical filler for refinishing of vehicles. It protects the surface from corrosion and fills minor cavities also. Due to the resistance to salty sea spray, this can be recommended for marine environment also. </p>
    </div>
  </div>
<div class="column paints">
    <div class="content">
    <img src="images/Paints.jpg" alt="Car" style="width:70%">
      <h4>Sunny 2K Rapid Primer Surfacer</h4>
      <p>Sunny 2K Rapid Primer Surfacer (2:1) is rapid drying, high solid two component polyurethane primer for automotive & industrial use. This has excellent filling and sanding properties. It will level out minor irregularities in the substrate and improve adhesion of the top coat.</p>
    </div>
  </div>
  <div class="column paints">
    <div class="content">
    <img src="images/Paint3.jpg" alt="Car" style="width:80%">
      <h4>Hi-Gloss 2K hardener</h4>
      <p>Causeway Hi-Gloss 2K hardener is a solution of poly-functional poly-isocyanic polymer with non-yellowing properties.Used in conjunction with Causeway Hi-gloss 2K clear for automotive and steelworks.</p>
    </div>
  </div>


<!-- END GRID -->
</div>

<!-- END MAIN -->
</div>

<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
//end the slideshow..

filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("column");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}



</script>

</body>
</html> 
