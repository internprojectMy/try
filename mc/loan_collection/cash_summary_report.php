<?php
$from = $_REQUEST['from'];
$expenses_type = $_REQUEST['expenses_type'];
$to = $_REQUEST['to'];
$search = $_REQUEST['search'];
$nic = $_REQUEST['nic'];
$branch_id = $_REQUEST['branch_id'];
// $branch_id = $_REQUEST['branch_name'];
require_once ('../../config.php');

require_once ('../../reporting_part/report_header_oa8.php');

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
            cash_collecting.`status`
        FROM
            cash_collecting
            INNER JOIN branch ON branch.branch_id = cash_collecting.branch_name
        WHERE
            cash_collecting.branch_name = '$branch_id' AND
            cash_collecting.today BETWEEN '$from' AND '$to'";

$sql_1 = mysqli_query($con_main, $query);

$query1_rows = mysqli_num_rows($sql_1);
/*
 * checking purpose
 */
//	echo($query1_rows);



            $query2 = "SELECT
				document_charges.id,
				document_charges.loanno,
				document_charges.loan_amount,
				document_charges.document_rate,
				document_charges.document_amount,
				document_charges.status,
				document_charges.doc_date,
				document_charges.type,
				loan_customer.name_full,
				branch.branch_id
				FROM
				document_charges
				INNER JOIN loan_lending ON loan_lending.loanid = document_charges.loanno
				INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
				INNER JOIN branch ON branch.branch_id = loan_customer.branch_name
				WHERE
				loan_customer.branch_name = '$branch_id' 
				AND document_charges.doc_date BETWEEN '$from' AND '$to'";

$sql_2 = mysqli_query($con_main, $query2);

$query2_rows = mysqli_num_rows($sql_2);
/*
 * checking purpose
 */
//	echo($query2_rows);


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
$query3_rows = mysqli_num_rows($sql_3);


$query = "SELECT
            loan_lending.loantypes,
            loan_lending.net_payment,
            loan_lending.startdate,
            loan_lending.`status`,
            loan_customer.member_number,
            loan_customer.name_full
            FROM
            loan_lending
            INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
            WHERE
            loan_lending.startdate BETWEEN '$from' AND '$to' AND
            loan_customer.branch_name = '1'";


$sql_4 = mysqli_query($con_main, $query4);
$query4_rows = mysqli_num_rows($sql_4);    
/*
 * checking purpose
 */
//	echo($query3_rows);
	
//get the 1st table total row count
$table1_row_count = $query1_rows + $query2_rows;
// 2nd table total row count = 	$query3_rows
//echo($table1_row_count);
// assign the max row count
if ($table1_row_count > $query3_rows) {
    $max = $table1_row_count;
} else {
    $max = $query3_rows;
}
//echo($max);
?>							
<br/>
<div class="col-md-6" style="width: 50%; float: left;">
    <table style="border-collapse:collapse;" border="1" id="report" width="99%">
        <thead>
            <tr>
                <th colspan="5">CASH IN</th>
                <!-- <th colspan="4">CASH OUT</th>-->
            </tr>
            <tr>
                <th colspan="">Date</th>
                <th colspan="">Description</th>
                <th colspan="">Type</th>
                <th colspan="">Amount</th>
            </tr>
        </thead>

<?php
$tot_amt = 0;
$tot_interest = 0;
$sql = mysqli_query($con_main, $query);

while ($row = mysqli_fetch_array($sql)) {

    $tot_amt = $tot_amt + $row[''];
    $tot_interest2 = $tot_interest + $row['paid'];
    ?>
            <tr>
                <td><?php echo ($row['today']); ?></td>
                <td><?php echo ($row['name_full']); ?></td>
                <td><?php echo ($row['type']); ?></td>
                <td><?php echo (number_format($row['paid'], 2)); ?></td>					
            </tr>
            <?php
        }
        ?>

<?php
$tot_amt = 0;
$tot_interest = 0;
$sql = mysqli_query($con_main, $query);
$sql_2 = mysqli_query($con_main, $query2);



while ($row = mysqli_fetch_array($sql_2)) {

    $tot_amt = $tot_amt + $row[''];
    $tot_interest = $tot_interest + $row['document_amount'];
    ?>
            <tr>
                <td><?php echo ($row['doc_date']); ?></td>
                <td><?php echo ($row['name_full']); ?></td>
                <td><?php echo ($row['type']); ?></td>
                <td><?php echo (number_format($row['document_amount'], 2)); ?></td>					
            </tr>
            <?php
        }
        if ($table1_row_count == $max) {
            ?>
            <tr>
                <td colspan="3"><strong><center>TOTAL</center></strong></td>			

    <!-- <td><strong><?php //echo (number_format($tot_interest,2));  ?></strong></td> -->	
                <td><strong><?php echo (number_format($tot_interest + $tot_interest2, 2)); ?></strong></td>			
            </tr>	
            <?php
        } else {
            $balance_rows = $max - $table1_row_count;
          //  echo($balance_rows);
            $check = 1;
            while ($check <= $balance_rows) {
                ?>
            <tr>
                <td height="21px"></td>
                <td></td>
                <td></td>
                <td></td>					
            </tr>				
            <?php
            $check++;
        }
        ?>
        <tr>
            <td colspan="3"><strong><center>TOTAL</center></strong></td>			

    <!-- <td><strong><?php //echo (number_format($tot_interest,2));  ?></strong></td> -->	
            <td><strong><?php echo (number_format($tot_interest + $tot_interest2, 2)); ?></strong></td>			
        </tr>	
    
        <?php
    }
    ?>
     </table>
</div>

<div class="col-md-6" style="width: 50%; float: right;">
    <table style="border-collapse:collapse;" border="1" id="report" width="100%">
        <thead>
            <tr>
                <th colspan="5">CASH OUT</th>
            <tr>
                <th colspan="">Date</th>
                <th colspan="">Description</th>
                <th colspan="">Expense Type</th>
                <th colspan="">Amount</th>
            </tr>
        </thead>


        <?php
$tot_amt = 0;
$tot_interest = 0;
$sql_4 = mysqli_query($con_main, $query4);

while ($row = mysqli_fetch_array($sql_4)) {

    $tot_amt = $tot_amt + $row[''];
    $tot_interest6 = $tot_interest + $row['net_payment'];
    ?>
            <tr>
                <td><?php echo ($row['startdate']); ?></td>
                <td><?php echo ($row['name_full']); ?></td>
                <td><?php echo ($row['member_number']); ?></td>
                <td><?php echo (number_format($row['net_payment'], 2)); ?></td>                    
            </tr>
            <?php
        }
        ?>

<?php
$tot_amt = 0;
$tot_interest = 0;
$sql_3 = mysqli_query($con_main, $query3);

$num_rows_3 = mysqli_num_rows($sql_3);
while ($row = mysqli_fetch_array($sql_3)) {

    $tot_amt = $tot_amt + $row[''];
    $tot_interest1 = $tot_interest1 + $row['amount'];
    ?>
            <tr>
                <td><?php echo ($row['entered_date']); ?></td>
                <td><?php echo ($row['comment']); ?></td>
                <td><?php echo ($row['cat1']); ?></td>
                <td><?php echo (number_format($row['amount'], 2)); ?></td>			
            </tr>
            <?php
        }



        if ($query3_rows == $max) {
            ?>
            <tr>
                <td colspan="3"><strong><center>TOTAL</center></strong></td>			

    <!-- <td><strong><?php //echo (number_format($tot_interest,2));  ?></strong></td> -->	
                <td><strong><?php echo (number_format($tot_interest1, 2)); ?></strong></td>			
                </td>
            </tr>	
        </table>
            <?php
        } else {
            $bal_rows = $max - $query3_rows;
            $check2 = 1;
            while ($check2 <= $bal_rows) {
                ?>
            <tr>
                <td height="22px"></td>
                <td></td>
                <td></td>
                <td></td>					
            </tr>				
            <?php
            $check2++;
        }
        ?>
        <td colspan="3"><strong><center>TOTAL</center></strong></td>			

    <!-- <td><strong><?php //echo (number_format($tot_interest,2));  ?></strong></td> -->	
        <td><strong><?php echo (number_format($tot_interest1, 2)); ?></strong></td>			
    </td>
    </tr>	
    </table>
        <?php
    }
    ?>
</div>