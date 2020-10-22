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

    $in_date = sanitize($_REQUEST['in_date']);
    $out_date = sanitize($_REQUEST['out_date']);
    $epf_no = sanitize($_REQUEST['epf_no']);
    $location = sanitize($_REQUEST['location']);
    $department = sanitize($_REQUEST['department']);
    $job_level = sanitize($_REQUEST['job_level']);
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

    switch ($iradio){
        CASE 'invalied':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " ((FVA.in_time<>'00:00:00' AND FVA.out_time='00:00:00') OR (FVA.in_time='00:00:00' AND FVA.out_time<>'00:00:00')) ";

            $report_type = "Invalid Attendance ";

            $col_array[0] = array ('name' => 'EMP', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'IN TIME', 'col' => 'IN');
            $col_array[4] = array ('name' => 'OUT TIME', 'col' => 'OUT');
        BREAK;

        CASE 'absent':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " ((FVA.in_time='00:00:00' AND FVA.out_time='00:00:00') AND FVA.leave_id='0') ";

            $report_type = "Absent ";

            $col_array[0] = array ('name' => 'EMP', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'DESIGNATION', 'col' => 'JT');
            $col_array[4] = array ('name' => 'CONTACT', 'col' => 'CONT');
            $col_array[5] = array ('name' => 'ADDRESS', 'col' => 'ADDR');
        BREAK;

        CASE 'ot':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " FVA.ot_minutes > 0 ";

            $report_type = "OT ";

            $col_array[0] = array ('name' => 'EMP', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START');
            $col_array[4] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END');
            $col_array[5] = array ('name' => 'IN TIME', 'col' => 'IN');
            $col_array[6] = array ('name' => 'OUT TIME', 'col' => 'OUT');
            $col_array[7] = array ('name' => 'OT MINS', 'col' => 'OT');
            // $col_array[8] = array ('name' => 'OT RATE', 'col' => 'OT_RATE');
        BREAK;

        CASE 'present':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " (FVA.in_time <> '00:00:00' OR FVA.out_time <> '00:00:00') ";

            $report_type = "Present ";

            $col_array[0] = array ('name' => 'EMP', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START');
            $col_array[4] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END');
            $col_array[5] = array ('name' => 'IN TIME', 'col' => 'IN');
            $col_array[6] = array ('name' => 'OUT TIME', 'col' => 'OUT');
            $col_array[7] = array ('name' => 'OT MINS', 'col' => 'OT');
            //  $col_array[8] = array ('name' => 'OT RATE', 'col' => 'OT_RATE');
        BREAK;

        CASE 'late_early_departure':
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " (FVA.early_departure_minutes > 0 OR FVA.late_minutes > 0) ";

            $report_type = "Late/Early Departure ";

            $col_array[0] = array ('name' => 'EMP', 'col' => 'EPF');
            $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
            $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
            $col_array[3] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START');
            $col_array[4] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END');
            $col_array[5] = array ('name' => 'IN TIME', 'col' => 'IN');
            $col_array[6] = array ('name' => 'OUT TIME', 'col' => 'OUT');
            $col_array[7] = array ('name' => 'LATE', 'col' => 'LATE');
            $col_array[8] = array ('name' => 'EARLY', 'col' => 'EARLY');
        BREAK;
    }

    if (count($col_array, COUNT_NORMAL) <= 0){
        $col_array[0] = array ('name' => 'EMP', 'col' => 'EPF');
        $col_array[1] = array ('name' => 'NAME', 'col' => 'NAME');
        $col_array[2] = array ('name' => 'DATE', 'col' => 'DATE');
        $col_array[3] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START');
        $col_array[4] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END');
        $col_array[5] = array ('name' => 'IN TIME', 'col' => 'IN');
        $col_array[6] = array ('name' => 'OUT TIME', 'col' => 'OUT');
        $col_array[7] = array ('name' => 'LATE', 'col' => 'LATE');
        $col_array[8] = array ('name' => 'EARLY', 'col' => 'EARLY');
        $col_array[9] = array ('name' => 'BREAKFAST', 'col' => 'meal.breakfast');
        $col_array[10] = array ('name' => 'LUNCH', 'col' => 'meal.lunch');
        $col_array[10] = array ('name' => 'OT', 'col' => 'OT');
    }

    $query = "SELECT
            FVA.epf AS EPF,
            ER.name_initial AS `NAME`,
            ER.personal_phone_num AS CONT,
            LM.loc_name AS LOC,
            DM.dep_name AS DEP,
            JL.job_level_name AS DES,
            FVA.date AS DATE,
            FVA.in_time AS `IN`,
            FVA.out_time AS `OUT`,
            SC.shift_name AS SHIFT,
            TIME(FVA.shift_start) AS SHIFT_START,
            TIME(FVA.shift_end) AS SHIFT_END,
            FVA.late_minutes AS LATE,
            ROUND(
                    FVA.early_departure_minutes / 60
                ) AS EARLY,
            ROUND(FVA.ot_minutes / 60, 1) AS OT,
            FVA.shift_ot_pay_rate AS OT_RATE,
            LT.leave_name AS `LEAVE`,
            job_title.job_title AS JT
            FROM
            final_verify_attendance AS FVA
            INNER JOIN emp_registration AS ER ON FVA.crn_id = ER.crn_id
            INNER JOIN location_m AS LM ON FVA.location = LM.loc_id
            INNER JOIN department_m AS DM ON FVA.department = DM.dep_id
            LEFT JOIN job_level AS JL ON FVA.job_level = JL.job_level_id
            INNER JOIN shift_creation AS SC ON FVA.prioritized_shift_id = SC.id
            LEFT JOIN leave_request AS LR ON FVA.leave_id = LR.id
            LEFT JOIN leave_type AS LT ON LR.holiday_type = LT.leave_type_id
            INNER JOIN job_title ON ER.job_title = job_title.job_id
            ".$where."
            ORDER BY
            DATE ASC,
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

                                    $meal_query = "";
                                    $date = $row['DATE'];
                                    $epf = $row['EPF'];
                                    $meal_count = 0;
                                    $meal_charge = 0;

                                    if ($col_val == "meal.breakfast"){
                                        $meal_query = "SELECT
                                        COUNT(FVM.emp_no) AS C
                                        FROM
                                        final_verify_meal AS FVM
                                        WHERE
                                        FVM.emp_no = '$epf' AND
                                        DATE(FVM.meal_date) = '$date' AND
                                        FVM.meal_type = 'Breakfast'";

                                        $meal_sql = mysqli_query ($conn, $meal_query);
                                        $meal_res = mysqli_fetch_assoc ($meal_sql);
                                        $meal_count = (int)$meal_res['C'];

                                        $meal_amount_charge = mysqli_query ($conn, "SELECT MA.amount AS AMOUNT FROM meal_amount AS MA WHERE MA.meal_type = 'Breakfast'");
                                        $meal_res_charge = mysqli_fetch_assoc ($meal_amount_charge);
                                        $meal_charge = (double)$meal_res_charge['AMOUNT'];

                                        $meal_charge = $meal_charge * $meal_count;

                                        //echo ("<td>".$meal_count."</td>");
                                        echo ("<td>".$meal_charge."</td>");
                                    }else if ($col_val == "meal.lunch"){
                                        $meal_query = "SELECT
                                        COUNT(FVM.emp_no) AS C
                                        FROM
                                        final_verify_meal AS FVM
                                        WHERE
                                        FVM.emp_no = '$epf' AND
                                        DATE(FVM.meal_date) = '$date' AND
                                        FVM.meal_type = 'Lunch'";

                                        $meal_sql = mysqli_query ($conn, $meal_query);
                                        $meal_res = mysqli_fetch_assoc ($meal_sql);
                                        $meal_count = (int)$meal_res['C'];

                                        $meal_amount_charge = mysqli_query ($conn, "SELECT MA.amount AS AMOUNT FROM meal_amount AS MA WHERE MA.meal_type = 'Lunch'");
                                        $meal_res_charge = mysqli_fetch_assoc ($meal_amount_charge);
                                        $meal_charge = (double)$meal_res_charge['AMOUNT'];

                                        $meal_charge = $meal_charge * $meal_count;

                                        //echo ("<td>".$meal_count."</td>");
                                        echo ("<td>".$meal_charge."</td>");
                                    }else{
                                        echo ("<td>".$row[$col_val]."</td>");
                                    }
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