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

    $where = "";
    $from_date = "";
    $to_date = "";
    $report_type = "Time-card ";

    $emp_str = "";

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

        $emp_sql = mysqli_query($conn,"SELECT ER.name_initial AS `NAME` FROM emp_registration AS ER WHERE ER.epf_no = '$epf_no'");
        $emp_res = mysqli_fetch_assoc ($emp_sql);

        $emp_str = $emp_res['NAME'];
    }

    if (count($col_array, COUNT_NORMAL) <= 0){
        $col_array[0] = array ('name' => 'DATE', 'col' => 'DATE', 'align' => 'center');
        $col_array[1] = array ('name' => 'SHIFT IN', 'col' => 'SHIFT_START', 'align' => 'center');
        $col_array[2] = array ('name' => 'SHIFT OUT', 'col' => 'SHIFT_END', 'align' => 'center');
        $col_array[3] = array ('name' => 'IN TIME', 'col' => 'IN', 'align' => 'center');
        $col_array[4] = array ('name' => 'OUT TIME', 'col' => 'OUT', 'align' => 'center');
        $col_array[5] = array ('name' => 'LATE', 'col' => 'LATE', 'align' => 'right');
        $col_array[6] = array ('name' => 'EARLY DEPARTURE', 'col' => 'EARLY', 'align' => 'right');
        $col_array[7] = array ('name' => 'BREAKFAST', 'col' => 'meal.breakfast', 'align' => 'right');
        $col_array[8] = array ('name' => 'LUNCH', 'col' => 'meal.lunch', 'align' => 'right');
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
    ROUND(FVA.early_departure_minutes/60) AS EARLY,
    FVA.ot_minutes AS OT,
    FVA.shift_ot_pay_rate AS OT_RATE,
    LT.leave_name AS `LEAVE`
    FROM
    final_verify_attendance AS FVA
    INNER JOIN emp_registration AS ER ON FVA.crn_id = ER.crn_id
    INNER JOIN location_m AS LM ON FVA.location = LM.loc_id
    INNER JOIN department_m AS DM ON FVA.department = DM.dep_id
    LEFT JOIN job_level AS JL ON FVA.job_level = JL.job_level_id
    INNER JOIN shift_creation AS SC ON FVA.prioritized_shift_id = SC.id
    LEFT JOIN leave_request AS LR ON FVA.leave_id = LR.id
    LEFT JOIN leave_type AS LT ON LR.holiday_type = LT.leave_type_id
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
                        $total_late = 0;
                        $total_early_departure = 0;
                        $total_breakfast = 0;
                        $total_lunch = 0;

                        while ($row = mysqli_fetch_assoc ($sql)){

                            echo ("<tr>");

                                foreach ($col_array as $i => $col_index) {
                                    $col_val = $col_array[$i]['col'];
                                    $col_align = $col_array[$i]['align'];

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

                                        $total_breakfast = $total_breakfast + $meal_charge;

                                        echo ("<td align=\"".$col_align."\">".number_format($meal_charge,2)."</td>");
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

                                        $total_lunch = $total_lunch + $meal_charge;

                                        echo ("<td align=\"".$col_align."\">".number_format($meal_charge,2)."</td>");
                                    }else{
                                        echo ("<td align=\"".$col_align."\">".$row[$col_val]."</td>");
                                    }

                                    if ($col_val == "EARLY"){
                                        $total_early_departure = $total_early_departure + (double)$row[$col_val];
                                    }

                                    if ($col_val == "LATE"){
                                        $total_late = $total_late + (double)$row[$col_val];
                                    }
                                }
                            
                            echo ("</tr>");
                        }
                    ?>

                    <tr>
                        <td align="center" colspan="5"><strong>Total</strong></td>
                        <td align="right"><?php echo (number_format($total_late,2)); ?></td>
                        <td align="right"><?php echo (number_format($total_early_departure,2)); ?></td>
                        <td align="right"><?php echo (number_format($total_breakfast,2)); ?></td>
                        <td align="right"><?php echo (number_format($total_lunch,2)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

	</body>
</html>
<?php
    mysqli_close ($conn);
?>