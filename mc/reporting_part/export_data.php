<?php
	// header('Content-Type: application/json');

	
	session_start();
	require ('../config.php');

	
	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();


	if(isset($_GET['export'])){
if($_GET['export'] == 'true'){
$query = mysqli_query($con_main, "SELECT
                loan_customer.id,
                loan_lending.loanid,
                loan_customer.nic,
                loan_lending.loan_date,
                loan_lending.startdate,
                loan_lending.enddate,
                loan_lending.loan_amount,
                loan_lending.interest_amount,
                loan_lending.net_payment,
                loan_lending.duration,
                loan_lending.due_amount,
                center.center_id,
                center.center_name
                FROM
                loan_customer"); // Get data from Database from demo table
 
 
    $delimiter = ",";
    $filename = "significant_" . date('Ymd') . ".csv"; // Create file name
     
    //create a file pointer
    $f = fopen('php://memory', 'w'); 
     
    //set column headers
    $fields = array('ID', 'loanid', 'nic', 'loan_date', 'startdate');
    fputcsv($f, $fields, $delimiter);
     
    //output each row of the data, format line as csv and write to file pointer
    while($row = mysqli_fetch_assoc(($sql)){
        
        $lineData = array($row['id'], $row['loanid'], $row['nic'], $row['loan_date'], $row['startdate']);
        fputcsv($f, $lineData, $delimiter);
    }
     
    //move back to beginning of file
    fseek($f, 0);
     
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
     
    //output all remaining data on a file pointer
    fpassthru($f);
 
 }
}




	
	// $responce['operation'] = $op;
	// $responce['result'] = $success;
	// $responce['id'] = $id;
	// $responce['message'] = $message;
	// $responce['debug'] = $debug;
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>