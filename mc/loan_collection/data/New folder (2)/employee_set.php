<?php
	include ('db.access.php');
	
	$crn_id = $_REQUEST['id'];
	
	$result_array = array();
	$result = false;
	$message = "";
	$debug = "";
	
	$emp_query =  "SELECT
					E.crn_id AS ID,
					E.epf_no AS EPF,
					E.epf_no_2 AS EPF_2,
					E.name_initial AS NAME_INITIAL,
					E.name_full AS NAME_FULL,
					E.name_calling AS NAME_CALLING,
					E.nic AS NIC,
					E.dob AS dob,
					E.emp_image AS IMAGE,
					E.nationality AS NATIONALITY,
					E.marital_status AS MARITAL_STATUS,
					E.gender AS GENDER,
					E.addres_street AS ADDRESS_LINE1,
					E.addres_street_2 AS ADDRESS_LINE2,
					E.addres_city AS ADDRESS_CITY,
					E.electorate AS ELECORATE,
					E.district AS DISTRICT,
					E.province AS PROVINCE,
					E.country AS COUNTRY,
					E.land_phone_no AS LAND_PHONE,
					E.personal_phone_num AS PERSONAL_PHONE,
					E.office_line AS OFFICE_PHONE,
					E.office_email AS EMAIL_OFFICE,
					E.other_email AS EMAIL_OTHER,
					E.location AS LOCATION,
					E.department AS DEPARTMENT,
					E.job_title AS JOB_TITLE,
					E.job_type AS JOB_TYPE,
					E.job_status AS JOB_STATUS,
					E.job_level AS JOB_LEVEL,
					E.job_location AS JOB_LOCATION,
					E.join_date AS JOIN_DATE,
					E.basic_salary AS BASIC_SALARY,
					E.allownces AS ALLOWANCE,
					E.special_benifit AS BENEFITS,
					E.person_name AS CONTACT_PERSON,
					E.relationship AS CONTACT_RELATION,
					E.contact_number AS CONTACT_NUMBER,
					E.contract_star_date AS CONTRACT_START,
					E.contract_end_date AS CONTRACT_END,
					E.contract_agreement AS CONTRACT_AGREEMENT,
					E.ot_payerbility AS OT_PAY,
					E.active AS ACTIVE,
					E.suspend AS SUSPEND,
					E.sal_pay AS SAL_PAY,
					E.resigned AS RESIGNED
					FROM
					emp_registration AS E
					WHERE
					E.crn_id = '$crn_id'";
	
	$emp_sql = mysqli_query($conn, $emp_query);
	
	$emp = mysqli_fetch_assoc($emp_sql);
	$debug = $emp_query;

	if ($emp_sql){
		$result = true;
		$message = "Success";

		$result_array['data'] = $emp;
	}else{
		$result = false;
		$message = "Error results";
	}

	$result_array['result'] = $result;
	$result_array['message'] = $message;
	$result_array['debug'] = $debug;
	
	mysqli_close($conn);
	
	echo (json_encode($result_array));
?>