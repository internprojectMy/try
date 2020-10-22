<?php
include('../config.php');

$responce = "";
$coords = "";
$x_axis = "";

$con_type_query = "SELECT
MCT.CON_TYPE_ID,
MCT.CON_TYPE
FROM
mobi_con_type AS MCT
WHERE
MCT.`STATUS` = 1
ORDER BY
MCT.CON_TYPE ASC";

$con_type_sql = mysqli_query($con_main, $con_type_query);

$c = 0;

while ($con_types = mysqli_fetch_assoc($con_type_sql)){
    $con_type_id = $con_types['CON_TYPE_ID'];
    $con_type_caption = $con_types['CON_TYPE'];

    $now_yr = $yr;
    $now_mn = $mn;

    $date_array = "";

    for ($i=0; $i < 6; $i++){
        $now_mn = str_pad($now_mn,2,"0",STR_PAD_LEFT);

        $date_array[] = $now_yr."-".$now_mn."-01";

        $now_yr = date('Y', strtotime($now_yr."-".$now_mn."-01 previous month"));
        $now_mn = date('n', strtotime($now_yr."-".$now_mn."-01 previous month"));
        $now_mn = str_pad($now_mn,2,"0",STR_PAD_LEFT);
    }

    $reversed_date_array = array_reverse($date_array);

    $i = 0;

    $data = "";

    foreach ($reversed_date_array as $reversed_date) {
        $this_yr = date('Y',strtotime($reversed_date));
        $this_mn = date('n',strtotime($reversed_date));

        $query = "SELECT
        DDS.TOTAL_DUE
        FROM
        dialog_detail_summary AS DDS
        INNER JOIN dialog_header AS DH ON DH.RECORD_ID = DDS.RECORD_ID
        INNER JOIN mobi_number AS MN ON DDS.MOBILE_NO = MN.NUMBER
        WHERE
        YEAR(DH.BILL_DATE_TO) = $this_yr AND
        MONTH(DH.BILL_DATE_TO) = $this_mn AND
        DDS.MOBILE_NO <> '0.00' AND
        MN.CON_TYPE = $con_type_id
        GROUP BY
        DDS.MOBILE_NO
        ORDER BY
        DDS.MOBILE_NO ASC";

        $sql = mysqli_query($con_main, $query);

        $total_usage = 0;

        while ($res = mysqli_fetch_assoc($sql)){
            $total_usage = $total_usage + (double)$res['TOTAL_DUE'];
        }

        $data[$i][0] = $i;
        $data[$i][1] = $total_usage;

        $i++;
    }

    $coords[$c]['label'] = $con_type_caption;
    $coords[$c]['data'] = $data;
    $coords[$c]['lines']['show'] = true;
    $coords[$c]['lines']['fill'] = true;
    $coords[$c]['points']['show'] = true;
    $coords[$c]['points']['radius'] = 5;

    $c++;
}

$responce['coords'] = $coords;

$now_yr = $yr;
$now_mn = $mn;
$date_array = "";

for ($i=0; $i < 6; $i++){
    $now_mn = str_pad($now_mn,2,"0",STR_PAD_LEFT);

    $date_array[] = $now_yr."-".$now_mn."-01";

    $now_yr = date('Y', strtotime($now_yr."-".$now_mn."-01 previous month"));
    $now_mn = date('n', strtotime($now_yr."-".$now_mn."-01 previous month"));
    $now_mn = str_pad($now_mn,2,"0",STR_PAD_LEFT);
}

$reversed_date_array = array_reverse($date_array);

$i = 0;

$data = "";

foreach ($reversed_date_array as $reversed_date) {
    $this_yr = date('Y',strtotime($reversed_date));
    $this_mn = date('n',strtotime($reversed_date));
    $this_mn_txt = date('M',strtotime($reversed_date));

    $x_axis[$i][0] = $i;
    $x_axis[$i][1] = $this_mn_txt;

    $i++;
}

$responce['x_axis'] = $x_axis;

mysqli_close($con_main);

echo (json_encode($responce));
?>