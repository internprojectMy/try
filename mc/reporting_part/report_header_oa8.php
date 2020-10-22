<?php
 $query = "SELECT
            	cash_collecting.id,
            	cash_collecting.branch_name,
            	cash_collecting.center_name,
            	cash_collecting.loanid,
            	cash_collecting.name_full,
            	cash_collecting.nic,
            	cash_collecting.net_payment,
            	cash_collecting.paid,
            	cash_collecting.total,
            	cash_collecting.today,
            	cash_collecting.type,
            	cash_collecting.types,
            	cash_collecting.`status`,
            	cash_collecting.expenses_type
            FROM
            	cash_collecting
            INNER JOIN branch ON branch.branch_id = cash_collecting.branch_name
            INNER JOIN expenses_type ON cash_collecting.expenses_type = expenses_type.expenses_type
            WHERE
            	cash_collecting.branch_name = '$branch_id'
            AND cash_collecting.today BETWEEN '$from'
            AND '$to'
            AND cash_collecting.expenses_type = '$expenses_type'";


    $sql = mysqli_query($con_main, $query);
    $query_rows = mysqli_num_rows($sql);

   while ($row = mysqli_fetch_array ($sql)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest2 = $tot_interest2 + $row['paid'];
        }


$query2 = "SELECT
            	document_charges.id,
            	document_charges.loanno,
            	document_charges.loan_amount,
            	document_charges.document_rate,
            	document_charges.document_amount,
            	document_charges.`status`,
            	document_charges.doc_date,
            	document_charges.type,
            	loan_customer.name_full,
            	branch.branch_id,
            	document_charges.expenses_type
            FROM
            	document_charges
            INNER JOIN loan_lending ON loan_lending.loanid = document_charges.loanno
            INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
            INNER JOIN branch ON branch.branch_id = loan_customer.branch_name
            INNER JOIN expenses_type ON document_charges.expenses_type = expenses_type.expenses_type
            WHERE
            	loan_customer.branch_name = '$branch_id'
            AND document_charges.doc_date BETWEEN '$from'
            AND '$to'
            AND expenses_type.expenses_type = '$expenses_type'";


     $sql_2 = mysqli_query($con_main, $query2);
    $query_rows = mysqli_num_rows($sql_2);
    while ($row = mysqli_fetch_array ($sql_2)){

                $tot_amt623 = $tot_amt623 + $row[''];
                $tot_interest623 = $tot_interest623 + $row['document_amount'];

}

 $query3 = "SELECT
                loan_transactionexp.id,
                loan_transactionexp.category,
                loan_transactionexp.amount,
                loan_transactionexp.expencestype,
                loan_transactionexp.comment,
                loan_transactionexp.other,
                loan_transactionexp.entered_date,
                loan_transactionexp.entered_by,
                loan_transactionexp.type,
                loan_expenses.category AS cat1,
                loan_transactionexp.branch_name
                FROM
                loan_transactionexp
                INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
                LEFT JOIN branch ON branch.branch_name = loan_transactionexp.branch_name
                WHERE
                loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
                loan_transactionexp.expencestype = '$expenses_type' AND
                loan_transactionexp.branch_name = '$branch_id'";



$sql_3 = mysqli_query($con_main, $query3);
    $query_rows = mysqli_num_rows($sql_3);

     while ($row = mysqli_fetch_array ($sql_3)){

                $tot_amt13 = $tot_amt13 + $row[''];
                $tot_interest13 = $tot_interest13 + $row['amount'];

   }

$query4 = "SELECT
            	loan_lending.loantypes,
            	loan_lending.net_payment,
            	loan_lending.loan_amount,
            	loan_lending.`status`,
            	loan_lending.loan_date,
            	loan_customer.member_number,
            	loan_customer.name_full,
            	loan_lending.expenses_type
            FROM
            	loan_lending
            INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
            INNER JOIN expenses_type ON loan_lending.expenses_type = expenses_type.expenses_type
            WHERE
            	loan_lending.startdate BETWEEN '$from'
            AND '$to'
            AND loan_customer.branch_name = '1'
            AND loan_lending.expenses_type = '$expenses_type'";


$sql_4 = mysqli_query($con_main, $query4);
$query4_rows = mysqli_num_rows($sql_4); 

while ($row = mysqli_fetch_array($sql_4)) {

    $tot_amt6 = $tot_amt6 + $row[''];
    $tot_interest6 = $tot_interest6 + $row['loan_amount']; 
}

$query5 = "SELECT
	excess_entry.category,
	excess_entry.text,
	excess_entry.date,
	excess_entry.`status`,
	excess_entry.expenses_type
FROM
	excess_entry
INNER JOIN expenses_type ON excess_entry.expenses_type = expenses_type.expenses_type
WHERE
	excess_entry.`status` = '1'
AND excess_entry.date BETWEEN '$from'
AND '$to'
AND expenses_type.expenses_type = '$expenses_type'";


$sql_5 = mysqli_query($con_main, $query5);
$query5_rows = mysqli_num_rows($sql_5);

while ($row = mysqli_fetch_array ($sql_5)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest5 = $tot_interest5 + $row['category'];

}


$query6 = "SELECT
            loan_transactionexp.amount,
            loan_transactionexp.`comment`,
            loan_transactionexp.expcat,
            loan_transactionexp.entered_date
            FROM `loan_transactionexp`
            WHERE
            loan_transactionexp.expcat = 'Capital' AND
            loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
            loan_transactionexp.branch_name = '1' AND
            loan_transactionexp.expencestype ='$expenses_type'";


$sql_6 = mysqli_query($con_main, $query6);
$query6_rows = mysqli_num_rows($sql_6); 

 while ($row = mysqli_fetch_array ($sql_6)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest6 = $tot_interest6 + $row['amount'];


}


$query7 = "SELECT
            other_income.id,
            other_income.category,
            other_income.amount,
            other_income.`comment`,
            other_income.date,
            other_income.expenses_type,
            other_income.`status`
            FROM
            other_income
            INNER JOIN expenses_type ON other_income.expenses_type = expenses_type.expenses_type
            WHERE
            other_income.date BETWEEN '$from' AND '$to' AND
            expenses_type.expenses_type = '$expenses_type'";


$sql_7 = mysqli_query($con_main, $query7);
$query6_rows = mysqli_num_rows($sql_7); 

 while ($row = mysqli_fetch_array ($sql_7)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest7 = $tot_interest7 + $row['amount'];

 

 }
 
 $query8 = "SELECT
            	capital.id,
            	capital.category,
            	capital.amount,
            	capital.`comment`,
            	capital.date,
            	capital.expenses_type,
            	capital.`status`
            FROM
            capital
            INNER JOIN excess_entry ON capital.expenses_type = excess_entry.expenses_type
            WHERE
            capital.date BETWEEN '$from' AND '$to' AND
            excess_entry.expenses_type = '$expenses_type'";
            
            
    $sql_8 = mysqli_query($con_main, $query8);
    $query7_rows = mysqli_num_rows($sql_8); 

    while ($row = mysqli_fetch_array ($sql_8)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest8 = $tot_interest8 + $row['amount'];

 

 }        
 
 $cash_in = $tot_interest2 + $tot_interest9 + $tot_interest5 + $tot_interest623 +$tot_interest7 + $tot_interest8 ;
 $cash_out = $tot_interest13 + $tot_interest6;
 
 
?>
<div align="center" style="width:100%; padding: 2px auto 2px auto;">
  <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border-top: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>
      <td align="center" colspan="4" style="border-bottom: 1px solid #000;">
        <font style="font-size:21px; font-weight: bold;"><strong>B & A MICRO CREDIT</strong></font>
      </td>
    </tr>

    <tr style="height: 50px">
      <td align="center" colspan="4" style="border-top: 1px solid #000; padding: 5px 0px 5px 0px;">
      <font style="font-size:18px; font-weight: bold;"><strong><?php echo ($report_type."CASH BOOK SUMMARY"); ?></strong></font>
      </td>
    </tr>

  </table>
  <table width="98%" border="0" cellspacing="2" cellpadding="1" style="border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>
      <td><strong>From :</strong><?php echo (" ".date('d/m/Y', strtotime($from))); ?></td>
    </tr>
    <tr>
      <td><strong>To :</strong><?php echo (" ".date('d/m/Y', strtotime($to))); ?></td>
    </tr>
    <tr>
        <td><strong>End Balance :<?php echo(number_format($cash_in - $cash_out ,2)); ?></strong></td>
    </tr>
    
   <!--  <tr>
        <td><strong>Expense Start Balance :<?php echo(number_format($TOTT,2)); ?></strong></td>
    </tr> -->
    <tr>
        
      <td><?php if(!empty($epf_no)){ ?><strong>Employee:</strong><?php } ?></td>
      <td><?php if(!empty($epf_no)){ echo ($epf_no." - ".$emp_str); } ?></td>
      
      
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>