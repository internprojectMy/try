function formValidation(){
	var email = document.getElementById('email');

if(emailValidation(email, "* Please enter a valid email address *")){

	return true;
		}
		return false;
}
function emailValidation(inputtext, alertMsg){
 var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
 if(inputtext.value.match(emailExp)){
 return true;
 }else{
 document.getElementById('p3').innerText = alertMsg; //this segment
displays the validation rule for email
 inputtext.focus();
 return false;
 }
}

function doValidate()
{
	var readmail = document.appointment.requiredemail;
var checkatsymbol = readmail.indexof("@");
var checkdotsymbol = readmail.lastindexof(".");
if (readmail.value =="" || checkatsymbol<1)
{
alert("Please put the correct email address");
document.appointment.requiredemail.focus();
return false;
}
return ( true );
}



function validateEmail(email) { //Validates the email address
    var emailRegex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return emailRegex.test(email);
}

function validatePhone(phone) { //Validates the phone number
    var phoneRegex = /^(\+91-|\+91|0)?\d{10}$/; // Change this regex based on requirement
    return phoneRegex.test(phone);
}

function doValidate() {
   if (!validateEmail(document.appointment.requiredphone.value) || !validatePhone(document.appointment.requiredphone.value) ){
    alert("Invalid Email");
    return false;
}

<form name="appointment" method="post" onsubmit="return doValidate();">
      Name:*<br />
      <input type="text" name="requiredname" />
      Email:*<br />
        <input type="text" name="requiredemail" />
      Phone:*<br />
        <input type="text" name="requiredphone" />
      Appointment Date:*<br />
        <input type="text" name="requireddate" />

  Appointment Time:*<br />
            <input type="text" name="requiredtime" /><br /><br />
              <input name="submit" type="submit"  value="Book Now" />           </form>