<table class="table table-striped table-vcenter table-condensed">
<thead>
    <tr>
        <th class="text-center">Invoice Date</th>
        <th class="text-center">Mobile No</th>
        <th class="text-center">Total Due</th>
    </tr>
</thead>

<tbody>
<?php
    $query = "";
    $where = "";

    if ($sp == 1){
        $where = " WHERE (MSP.SHORT_NAME IS NULL AND
        MCT.CON_TYPE IS NULL AND
        MN.`LIMIT` IS NULL) ";

        if (!empty($yr)){
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " YEAR(DH.BILL_DATE_TO) = '$yr' ";
        }
    
        if (!empty($mn)){
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " MONTH(DH.BILL_DATE_TO) = '$mn' ";
        }

        $query = "SELECT
        DH.INVOICE_NO,
        DH.BILL_DATE_FROM,
        DH.BILL_DATE_TO AS DUE_DATE,
        MU.EMP_NO,
        CONCAT_WS(' ',MU.FIRST_NAME,MU.LAST_NAME) AS EMP_NAME,
        MD.DEPARTMENT,
        DDS.MOBILE_NO,
        MSP.SHORT_NAME AS SERVICE_PROVIDER,
        MCT.CON_TYPE AS CONNECTION_TYPE,
        MN.`LIMIT`,
        IF(MN.UNLIMITED=1,'YES','NO') AS UNLIMITED,
        DDS.MONTHLY_RENTAL,
        DDS.TOTAL_USAGE_CHARGES,
        DDS.TOTAL_TAX,
        DDS.TOTAL_BILL_AMOUNT,
        DDS.TOTAL_DUE
        FROM
        dialog_detail_summary AS DDS
        LEFT JOIN mobi_number AS MN ON DDS.MOBILE_NO = MN.NUMBER
        LEFT JOIN mas_user AS MU ON MN.USER_ID = MU.USER_CODE
        LEFT JOIN mobi_con_type AS MCT ON MN.CON_TYPE = MCT.CON_TYPE_ID
        LEFT JOIN mobi_service_provider AS MSP ON MN.SERVICE_PROVIDER = MSP.SP_ID
        LEFT JOIN mas_department AS MD ON MU.DEPARTMENT = MD.DEP_CODE
        INNER JOIN dialog_header AS DH ON DDS.RECORD_ID = DH.RECORD_ID";

        $query .= $where;
    }else if($sp == 2){
        $where = " WHERE
        (MS.SHORT_NAME IS NULL AND
        MC.CON_TYPE IS NULL AND
        MN.`LIMIT` IS NULL) ";
    
        if (!empty($yr)){
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " YEAR(MH.DUE_DATE) = '$yr' ";
        }
    
        if (!empty($mn)){
            $where .= (empty($where)) ? " WHERE " : " AND ";
            $where .= " MONTH(MH.DUE_DATE) = '$mn' ";
        }

        $query = "SELECT
        MU.EMP_NO,
        CONCAT_WS(' ',MU.FIRST_NAME,MU.LAST_NAME) AS EMP_NAME,
        MH.BILL_NO,
        MH.BILL_DATE,
        MH.DUE_DATE,
        MD.DEPARTMENT,
        MDS.MOBILE_NO,
        MS.SHORT_NAME AS SERVICE_PROVIDER,
        MC.CON_TYPE AS CONNECTION_TYPE,
        MN.`LIMIT`,
        IF(MN.UNLIMITED=1,'YES','NO') AS UNLIMITED,
        MDS.MONTHLY_RENTAL,
        MDS.TOTAL_USAGE_CHARGES,
        MDS.TOTAL_TAX,
        MDS.TOTAL_DUE AS TOTAL_BILL_AMOUNT,
        MDS.TOTAL_DUE
        FROM
        mobitel_detail_summary AS MDS
        LEFT JOIN mobi_number AS MN ON MDS.MOBILE_NO = MN.NUMBER
        LEFT JOIN mas_user AS MU ON MN.USER_ID = MU.USER_CODE
        LEFT JOIN mas_department AS MD ON MU.DEPARTMENT = MD.DEP_CODE
        LEFT JOIN mobi_service_provider AS MS ON MN.SERVICE_PROVIDER = MS.SP_ID
        LEFT JOIN mobi_con_type AS MC ON MN.CON_TYPE = MC.CON_TYPE_ID
        INNER JOIN mobitel_header AS MH ON MDS.RECORD_ID = MH.RECORD_ID";

        $query .= $where;
    }

    $sql = mysqli_query ($con_main, $query);
		
    while ($row = mysqli_fetch_array ($sql)){
        $total_due = (double)$row['TOTAL_DUE'];

        echo ('<tr>');
        echo ('<td align="center">'.$row['DUE_DATE'].'</td>');
        echo ('<td align="center">'.$row['MOBILE_NO'].'</td>');
        echo ('<td align="right">'.number_format($total_due,2).'</td>');
        echo ('</tr>');
    }
?>
</tbody>
</table>