<?php
    include ('../__data_fol/db.access.php');

    function sanitize($val){
        $ret = "";

        if (isset ($val) && $val != NULL){
            $ret = $val;
        }else{
            $ret = "";
        }

        return $ret;
    }

    $in_date = sanitize($_REQUEST['from_date']);
    $out_date = sanitize($_REQUEST['to_date']);
    $epf_no = sanitize($_REQUEST['epf_no']);
    $location = sanitize($_REQUEST['location']);
    $department = sanitize($_REQUEST['department']);
    $job_level = sanitize($_REQUEST['job_level']);
    $by_gender = sanitize($_REQUEST['emp_geder']);
    $iradio = sanitize($_REQUEST['iradio']);

    $where = "";
    $from_date = "";
    $to_date = "";
    $report_type = "";
    $department_str = "ALL";
    $job_level_str = "ALL";

    $col_array = array();

    if (empty($out_date)){
        $out_date = date('Y-m-d');
    }

    if (!empty($in_date) && !empty($out_date)){
        $where .= (empty($where)) ? " WHERE " : " AND ";
        $where .= " FVA.date BETWEEN '$in_date' AND '$out_date' ";

        $from_date = $in_date;
        $to_date = $out_date;
    }

    if (!empty($epf_no)){
        $where .= (empty($where)) ? " WHERE " : " AND ";
        $where .= " FVA.epf = '$epf_no' ";

        $filter_str .= (empty($filter_str)) ? "" : " | ";
        $filter_str .= " EPF : ".$epf_no;
    }

    if (!empty($location)){
        $where .= (empty($where)) ? " WHERE " : " AND ";
        $where .= " FVA.location = '$location' ";

        $query_filter = mysqli_query($conn, "SELECT L.loc_name FROM location_m AS L WHERE L.loc_id = '$location'");
        $res_filter = mysqli_fetch_array($query_filter);
        $location_str = $res_filter[0];

        $filter_str .= (empty($filter_str)) ? "" : " | ";
        $filter_str .= " Location : ".$location_str;
    }

    if (!empty($department)){
        $where .= (empty($where)) ? " WHERE " : " AND ";
        $where .= " FVA.department = '$department' ";

        $query_filter = mysqli_query($conn, "SELECT D.dep_name FROM department_m AS D WHERE D.dep_id = '$department'");
        $res_filter = mysqli_fetch_array($query_filter);
        $department_str = $res_filter[0];
    }

    if (!empty($job_level)){
        $where .= (empty($where)) ? " WHERE " : " AND ";
        $where .= " FVA.job_level = '$job_level' ";

        $query_filter = mysqli_query($conn, "SELECT J.job_level_name FROM job_level AS J WHERE J.job_level_id = '$job_level'");
        $res_filter = mysqli_fetch_array($query_filter);
        $job_level_str = $res_filter[0];
    }

    if (!empty($by_gender)){
        $where .= (empty($where)) ? " WHERE " : " AND ";
        $where .= " FVA.job_level = '$by_gender' ";

        $query_filter = mysqli_query($conn, "SELECT emp_registration.gender FROM emp_registration WHERE emp_registration.gender = '$by_gender'");
        $res_filter = mysqli_fetch_array($query_filter);
        $job_level_str = $res_filter[0];
    }

    switch ($iradio){
        CASE 'by_emp':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " ((FVA.in_time<>'00:00:00' AND FVA.out_time='00:00:00') OR (FVA.in_time='00:00:00' AND FVA.out_time<>'00:00:00')) ";

            $report_type = "By Employee";

            $col_array[0] = array ('name' => 'EMP NO', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'Name With Initial', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'Full Name', 'col' => 'NAME_INITIAL');
            $col_array[3] = array ('name' => 'Caling Name', 'col' => 'FULL_NAME');
            $col_array[4] = array ('name' => 'NIC', 'col' => 'NIC');
            $col_array[5] = array ('name' => 'BOB', 'col' => 'DOB');
            $col_array[6] = array ('name' => 'Nationality', 'col' => 'NATIONALITY');
            $col_array[7] = array ('name' => 'Marital Status', 'col' => 'MARITAL');
            $col_array[8] = array ('name' => 'Gender', 'col' => 'GENDER');
            $col_array[9] = array ('name' => 'Addres', 'col' => 'ADDRESS');
            $col_array[10] = array ('name' => 'Electrorate', 'col' => 'ELECTORATE');
            $col_array[11] = array ('name' => 'District', 'col' => 'DISTRICT');
            $col_array[12] = array ('name' => 'Province', 'col' => 'PROVINCE');
            $col_array[13] = array ('name' => 'Contry', 'col' => 'COUNTRY');
            $col_array[14] = array ('name' => 'Land Phone', 'col' => 'LAND_PHONE');
            $col_array[15] = array ('name' => 'Personal Number', 'col' => 'PESONAL_PHONE');
            $col_array[16] = array ('name' => 'Office Line', 'col' => 'OFFICE_PHONE');
            $col_array[17] = array ('name' => 'Office E-Mail', 'col' => 'OFFICE_EMAIL');
            $col_array[18] = array ('name' => 'Joing Date', 'col' => 'JOIN_DATE');
            $col_array[19] = array ('name' => 'Location', 'col' => 'LOC');
            $col_array[20] = array ('name' => 'Department', 'col' => 'DEP');
            $col_array[21] = array ('name' => 'Designation', 'col' => 'DES');
            $col_array[22] = array ('name' => 'Job Type', 'col' => 'JOB_LEVEL');
            $col_array[23] = array ('name' => 'Job Status', 'col' => 'JOB_STATUS');
            $col_array[25] = array ('name' => 'Basic Salary', 'col' => 'BASIC_SALARY');
            $col_array[27] = array ('name' => 'OT Payerbility', 'col' => 'OT_PAY');
            $col_array[28] = array ('name' => 'Emergenzy Contater Name', 'col' => 'EMEG_NAME');
            $col_array[29] = array ('name' => 'Emergenzy Contater Relationaship', 'col' => 'EMEG_RELATION');
            $col_array[30] = array ('name' => 'Emergenzy Contater Number', 'col' => 'EMEG_PHONE');
            $col_array[31] = array ('name' => 'Active', 'col' => 'ACTIVE');
            $col_array[32] = array ('name' => 'Suspendent', 'col' => 'SUSPEND');
            $col_array[33] = array ('name' => 'Sal Pay', 'col' => 'SAL_PAY');
            $col_array[34] = array ('name' => 'Resign', 'col' => 'RESIGNED');
        BREAK;

        CASE 'by_job_level':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " ((FVA.in_time='00:00:00' AND FVA.out_time='00:00:00') AND FVA.leave_id='0') ";

            $report_type = "By Job Level ";

            $col_array[0] = array ('name' => 'EMP NO', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'DESIGNATION', 'col' => 'JOB_LEVEL');
            $col_array[4] = array ('name' => 'CONTACT', 'col' => 'PESONAL_PHONE');
            $col_array[5] = array ('name' => 'ADDRESS', 'col' => 'ADDRESS');
        BREAK;

        CASE 'by_gender':
            $where .= (empty($where)) ? " WHERE " : " AND ";

            $report_type = "By Gender ";

            $col_array[0] = array ('name' => 'EMP NO', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START');
            $col_array[4] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END');
            $col_array[5] = array ('name' => 'IN TIME', 'col' => 'IN');
            $col_array[6] = array ('name' => 'OUT TIME', 'col' => 'OUT');
            $col_array[7] = array ('name' => 'OT MINS', 'col' => 'OT');
            $col_array[8] = array ('name' => 'OT RATE', 'col' => 'OT_RATE');
        BREAK;

        CASE 'service_report':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " (FVA.in_time <> '00:00:00' AND FVA.out_time <> '00:00:00') ";

            $report_type = "Service Report ";

            $col_array[0] = array ('name' => 'EMP NO', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START');
            $col_array[4] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END');
            $col_array[5] = array ('name' => 'IN TIME', 'col' => 'IN');
            $col_array[6] = array ('name' => 'OUT TIME', 'col' => 'OUT');
            $col_array[7] = array ('name' => 'OT MINS', 'col' => 'OT');
            $col_array[8] = array ('name' => 'OT RATE', 'col' => 'OT_RATE');
        BREAK;

        CASE 'time_card':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " (FVA.early_departure_minutes > 0 OR FVA.late_minutes > 0) ";

            $report_type = "Time Card ";

            $col_array[0] = array ('name' => 'EMP NO', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START');
            $col_array[4] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END');
            $col_array[5] = array ('name' => 'IN TIME', 'col' => 'IN');
            $col_array[6] = array ('name' => 'OUT TIME', 'col' => 'OUT');
            $col_array[7] = array ('name' => 'LATE', 'col' => 'LATE');
            $col_array[8] = array ('name' => 'EARLY DEPARTURE', 'col' => 'EARLY');
        BREAK; 

        CASE 'employee_individual_details':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " (FVA.early_departure_minutes > 0 OR FVA.late_minutes > 0) ";

            $report_type = "Employee Individual Details ";

            $col_array[0] = array ('name' => 'EMP NO', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START');
            $col_array[4] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END');
            $col_array[5] = array ('name' => 'IN TIME', 'col' => 'IN');
            $col_array[6] = array ('name' => 'OUT TIME', 'col' => 'OUT');
            $col_array[7] = array ('name' => 'LATE', 'col' => 'LATE');
            $col_array[8] = array ('name' => 'EARLY DEPARTURE', 'col' => 'EARLY');
        BREAK;
    }

    if (count($col_array, COUNT_NORMAL) <= 0){
        $col_array[0] = array ('name' => 'EMP NO', 'col' => 'EPF');
        $col_array[1] = array ('name' => 'Name With Initial', 'col' => 'NAME');
        $col_array[2] = array ('name' => 'Full Name', 'col' => 'NAME_INITIAL');
        $col_array[3] = array ('name' => 'Caling Name', 'col' => 'FULL_NAME');
        $col_array[4] = array ('name' => 'NIC', 'col' => 'NIC');
        $col_array[5] = array ('name' => 'BOB', 'col' => 'DOB');
        $col_array[6] = array ('name' => 'Nationality', 'col' => 'NATIONALITY');
        $col_array[7] = array ('name' => 'Marital Status', 'col' => 'MARITAL');
        $col_array[8] = array ('name' => 'Gender', 'col' => 'GENDER');
        $col_array[9] = array ('name' => 'Addres', 'col' => 'ADDRESS');
        $col_array[10] = array ('name' => 'Electrorate', 'col' => 'ELECTORATE');
        $col_array[11] = array ('name' => 'District', 'col' => 'DISTRICT');
        $col_array[12] = array ('name' => 'Province', 'col' => 'PROVINCE');
        $col_array[13] = array ('name' => 'Contry', 'col' => 'COUNTRY');
        $col_array[14] = array ('name' => 'Land Phone', 'col' => 'LAND_PHONE');
        $col_array[15] = array ('name' => 'Personal Number', 'col' => 'PESONAL_PHONE');
        $col_array[16] = array ('name' => 'Office Line', 'col' => 'OFFICE_PHONE');
        $col_array[17] = array ('name' => 'Office E-Mail', 'col' => 'OFFICE_EMAIL');
        $col_array[18] = array ('name' => 'Joing Date', 'col' => 'JOIN_DATE');
        $col_array[19] = array ('name' => 'Location', 'col' => 'LOC');
        $col_array[20] = array ('name' => 'Department', 'col' => 'DEP');
        $col_array[21] = array ('name' => 'Designation', 'col' => 'DES');
        $col_array[22] = array ('name' => 'Job Type', 'col' => 'JOB_LEVEL');
        $col_array[23] = array ('name' => 'Job Status', 'col' => 'JOB_STATUS');
        $col_array[25] = array ('name' => 'Basic Salary', 'col' => 'BASIC_SALARY');
        $col_array[27] = array ('name' => 'OT Payerbility', 'col' => 'OT_PAY');
        $col_array[28] = array ('name' => 'Emergenzy Contater Name', 'col' => 'EMEG_NAME');
        $col_array[29] = array ('name' => 'Emergenzy Contater Relationaship', 'col' => 'EMEG_RELATION');
        $col_array[30] = array ('name' => 'Emergenzy Contater Number', 'col' => 'EMEG_PHONE');
        $col_array[31] = array ('name' => 'Active', 'col' => 'ACTIVE');
        $col_array[32] = array ('name' => 'Suspendent', 'col' => 'SUSPEND');
        $col_array[33] = array ('name' => 'Sal Pay', 'col' => 'SAL_PAY');
        $col_array[34] = array ('name' => 'Resign', 'col' => 'RESIGNED');
    }

    $query = "SELECT
    FVA.epf AS EPF,
    ER.name_initial AS `NAME`,
    ER.name_initial AS NAME_INITIAL,
    ER.name_full AS FULL_NAME,
    ER.name_calling AS CALLING_NAME,
    ER.nic AS NIC,
    ER.dob AS DOB,
    ER.nationality AS NATIONALITY,
    ER.marital_status AS MARITAL,
    ER.gender AS GENDER,
    CONCAT(ER.addres_street,ER.addres_street_2,ER.addres_city) AS ADDRESS,
    ER.electorate AS ELECTORATE,
    ER.district AS DISTRICT,
    ER.province AS PROVINCE,
    ER.country AS COUNTRY,
    ER.land_phone_no AS LAND_PHONE,
    ER.personal_phone_num AS PESONAL_PHONE,
    ER.office_line AS OFFICE_PHONE,
    ER.office_email AS OFFICE_EMAIL,
    ER.join_date AS JOIN_DATE,
    LM.loc_name AS LOC,
    department_m.dep_name AS DEP,
    job_title.job_title AS DES,
    JL.job_level_name AS JOB_LEVEL,
    ES.emp_status_name AS JOB_STATUS,
    ER.basic_salary AS BASIC_SALARY,
    IF(ER.ot_payerbility=1,'Yes','No') AS OT_PAY,
    ER.person_name AS EMEG_NAME,
    ER.relationship AS EMEG_RELATION,
    ER.contact_number AS EMEG_PHONE,
    FVA.date AS DATE,
    FVA.in_time AS `IN`,
    FVA.out_time AS `OUT`,
    SC.shift_name AS SHIFT,
    FVA.shift_start AS SHIFT_START,
    FVA.shift_end AS SHIFT_END,
    FVA.late_minutes AS LATE,
    FVA.early_departure_minutes AS EARLY,
    FVA.ot_minutes AS OT,
    FVA.shift_ot_pay_rate AS OT_RATE,
    LT.leave_name AS `LEAVE`,
    ER.active AS ACTIVE,
    ER.suspend AS SUSPEND,
    ER.sal_pay AS SAL_PAY,
    ER.resigned AS RESIGNED
    FROM
    final_verify_attendance AS FVA
    INNER JOIN emp_registration AS ER ON FVA.crn_id = ER.crn_id
    INNER JOIN location_m AS LM ON FVA.location = LM.loc_id
    LEFT JOIN job_level AS JL ON FVA.job_level = JL.job_level_id
    INNER JOIN shift_creation AS SC ON FVA.prioritized_shift_id = SC.id
    LEFT JOIN leave_request AS LR ON FVA.leave_id = LR.id
    LEFT JOIN leave_type AS LT ON LR.holiday_type = LT.leave_type_id
    LEFT JOIN employee_status AS ES ON ER.job_status = ES.emp_status_id
    INNER JOIN department_m ON FVA.department = department_m.dep_id
    INNER JOIN job_title ON FVA.job_title = job_title.job_id
    ".$where."
    ORDER BY
    EPF ASC";

    $sql = mysqli_query($conn, $query);
?>
<html>
	<head>
		<title>Original Apperal</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
        <style rel="stylesheet" type="text/css">
            #report_table_main{
                border-collapse: collapse;
            }

            #report_table_main thead tr th{
                text-align: center;
            }

            .th-color-change{
                background: #7dc7ea;
                color: white;
            }
        </style>
	</head>
	<body>
		<?php require_once ('report_header_oa.php'); ?>

        <div align="center" style="width:100%; padding: 2px auto 2px auto;" >
            <br />
            <table border="1" width="98%" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <?php
                            foreach ($col_array as $i => $col_index) {
                                echo ("<th>".$col_array[$i]['name']."</th>");
                            }
                        ?>
                    </tr>
                </thead>
                <tbody id="t-body">
                    <?php
                        while ($row = mysqli_fetch_assoc ($sql)){

                            echo ("<tr>");

                                foreach ($col_array as $i => $col_index) {
                                    $col_val = $col_array[$i]['col'];

                                    echo ("<td>".$row[$col_val]."</td>");
                                }
                            
                            echo ("</tr>");
                        }
                    ?>
                </tbody>
            </table>
        </div>

	</body>
</html>
<?php
    mysqli_close ($conn);
?>