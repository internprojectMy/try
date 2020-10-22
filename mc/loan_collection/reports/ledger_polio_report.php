<?php

$from = $_REQUEST['from'];
$expenses_type = $_REQUEST['expenses_type'];
$to = $_REQUEST['to'];
$search = $_REQUEST['search'];
$nic = $_REQUEST['nic'];
$branch_id = $_REQUEST['branch_id'];
// $branch_id = $_REQUEST['branch_name'];
require_once ('../../config.php');

require_once ('../../reporting_part/report_header_oa18.php');
 
	$query = "SELECT
			loan_transactionexp.id,
			loan_transactionexp.amount,
			loan_transactionexp.`comment`,
			loan_transactionexp.entered_date,
			loan_transactionexp.expcat,
			loan_expenses.category,
			loan_transactionexp.expencestype
			FROM
			loan_transactionexp
			INNER JOIN loan_expenses ON loan_expenses.id = loan_transactionexp.category
			WHERE
			loan_transactionexp.expcat = 'Income' AND
			loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
			loan_transactionexp.branch_name = '1' AND
			loan_transactionexp.expencestype = '$expenses_type'";
				





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
				AND document_charges.doc_date BETWEEN '$from'
											AND '$to'";




 $query3 = "SELECT
			loan_transactionexp.id,
			loan_transactionexp.amount,
			loan_transactionexp.`comment`,
			loan_transactionexp.entered_date,
			loan_transactionexp.expcat,
			loan_expenses.category,
			loan_transactionexp.expencestype
			FROM
			loan_transactionexp
			INNER JOIN loan_expenses ON loan_expenses.id = loan_transactionexp.category
			WHERE
			loan_transactionexp.expcat = 'Capital' AND
			loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
			loan_transactionexp.branch_name = '1' AND
			loan_transactionexp.expencestype = '$expenses_type'";







$query4 = "SELECT
			loan_transactionexp.id,
			loan_transactionexp.amount,
			loan_transactionexp.`comment`,
			loan_transactionexp.entered_date,
			loan_transactionexp.expcat,
			loan_expenses.category,
			loan_transactionexp.expencestype
			FROM
			loan_transactionexp
			INNER JOIN loan_expenses ON loan_expenses.id = loan_transactionexp.category
			WHERE
			loan_transactionexp.expcat = 'Administration Expenses' AND
			loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
			loan_transactionexp.branch_name = '1' AND
			loan_transactionexp.expencestype = '$expenses_type'";


$sql_4 = mysqli_query($con_main, $query4);
$query4_rows = mysqli_num_rows($sql_4); 




 $query5 = "SELECT
			loan_transactionexp.id,
			loan_transactionexp.amount,
			loan_transactionexp.`comment`,
			loan_transactionexp.entered_date,
			loan_transactionexp.expcat,
			loan_expenses.category,
			loan_transactionexp.expencestype
			FROM
			loan_transactionexp
			INNER JOIN loan_expenses ON loan_expenses.id = loan_transactionexp.category
			WHERE
			loan_transactionexp.expcat = 'Finance & Other Expenses' AND
			loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
			loan_transactionexp.branch_name = '1' AND
			loan_transactionexp.expencestype = '$expenses_type'";



	 $query6 = "SELECT
			loan_transactionexp.id,
			loan_transactionexp.amount,
			loan_transactionexp.`comment`,
			loan_transactionexp.entered_date,
			loan_transactionexp.expcat,
			loan_expenses.category,
			loan_transactionexp.expencestype
			FROM
			loan_transactionexp
			INNER JOIN loan_expenses ON loan_expenses.id = loan_transactionexp.category
			WHERE
			loan_transactionexp.expcat = 'Sales Expenses' AND
			loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
			loan_transactionexp.branch_name = '1' AND
			loan_transactionexp.expencestype = '$expenses_type'";


  $query7 = "SELECT
			loan_transactionexp.id,
			loan_transactionexp.amount,
			loan_transactionexp.`comment`,
			loan_transactionexp.entered_date,
			loan_transactionexp.expcat,
			loan_expenses.category,
			loan_transactionexp.expencestype
			FROM
			loan_transactionexp
			INNER JOIN loan_expenses ON loan_expenses.id = loan_transactionexp.category
			WHERE
			loan_transactionexp.expcat = 'Marketing Expenses' AND
			loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
			loan_transactionexp.branch_name = '1' AND
			loan_transactionexp.expencestype = '$expenses_type'";



	$query8 = "SELECT
			loan_transactionexp.id,
			loan_transactionexp.amount,
			loan_transactionexp.`comment`,
			loan_transactionexp.entered_date,
			loan_transactionexp.expcat,
			loan_expenses.category,
			loan_transactionexp.expencestype
			FROM
			loan_transactionexp
			INNER JOIN loan_expenses ON loan_expenses.id = loan_transactionexp.category
			WHERE
			loan_transactionexp.expcat = 'Liability' AND
			loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
			loan_transactionexp.branch_name = '1' AND
			loan_transactionexp.expencestype = '$expenses_type'";




?>













<div class="col-md-6" style="width: 50%; float: left;">


<table style="border-collapse:collapse;" border="1" id="report" width="99%">
						<thead>
                            <tr>
<th colspan="5">CASH IN</th>
<!-- <th colspan="4">CASH OUT</th>
 --></tr>

<tr>
<th colspan="">Date</th>
<th colspan="">Description</th>
<th colspan="">Type</th>
<th colspan="">Amount</th>
</tr>
						</thead>
           
	<?php

		    $tot_amt = 0;
		    $tot_interest2 = 0;
			$sql = mysqli_query ($con_main, $query);
			
		
			while ($row = mysqli_fetch_array ($sql)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest2 = $tot_interest2 + $row['amount'];

	?>
			<tr>
				<td><?php echo ($row['entered_date']); ?></td>
				<td><?php echo ($row['category']); ?></td>
				<td><?php echo ($row['expcat']); ?></td>
				<td><?php echo (number_format($row['amount'],2)); ?></td>					
			</tr>
	<?php
		}
	?>


	<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql = mysqli_query ($con_main, $query);
			$sql_2 = mysqli_query ($con_main, $query2);
		
			while ($row = mysqli_fetch_array ($sql_2)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest = $tot_interest + $row['document_amount'];

	?>
				<tr>
					<td><?php echo ($row['doc_date']); ?></td>
					<td><?php echo ($row['name_full']); ?></td>
					<td><?php echo ($row['type']); ?></td>
					<td><?php echo (number_format($row['document_amount'],2)); ?></td>					
				</tr>
	<?php
			}
	?>


	<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql = mysqli_query ($con_main, $query);
			$sql_3 = mysqli_query ($con_main, $query3);
		
			while ($row = mysqli_fetch_array ($sql_3)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest3 = $tot_interest + $row['amount'];

	?>
				<tr>
					<td><?php echo ($row['entered_date']); ?></td>
					<td><?php echo ($row['category']); ?></td>
					<td><?php echo ($row['expcat']); ?></td>
					<td><?php echo (number_format($row['amount'],2)); ?></td>					
				</tr>
	<?php
			}
	?>

	<tr>
		<td colspan="3"><strong><center>TOTAL</center></strong></td>			
			
			<!-- <td><strong><?php //echo (number_format($tot_interest,2)); ?></strong></td> -->	
			<td><strong><?php echo (number_format($tot_interest2 + $tot_interest + $tot_interest3 ,2)); ?></strong></td>			
		</td>


	</tbody>	
</table> 
</div>


<div class="col-md-6" style="width: 50%; float: right;">


<table style="border-collapse:collapse;" border="1" id="report" width="100%">
						<thead>
                            <tr>
<th colspan="5">CASH OUT</th>
<!-- <th colspan="4">CASH OUT</th>
 --></tr>

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
			$sql_4 = mysqli_query ($con_main, $query4);
			
		
			while ($row = mysqli_fetch_array ($sql_4)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest6 = $tot_interest + $row['amount'];
				
	?>
			<tr>
					<td><?php echo ($row['entered_date']); ?></td>
					<td><?php echo ($row['category']); ?></td>
					<td><?php echo ($row['expcat']); ?></td>
					<td><?php echo (number_format($row['amount'],2)); ?></td> 		
			</tr>
	<?php
		}
	?>
	     
           
	<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql_5 = mysqli_query ($con_main, $query5);
			
		
			while ($row = mysqli_fetch_array ($sql_5)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest8 = $tot_interest + $row['amount'];
				
	?>
			<tr>
					<td><?php echo ($row['entered_date']); ?></td>
					<td><?php echo ($row['category']); ?></td>
					<td><?php echo ($row['expcat']); ?></td>
					<td><?php echo (number_format($row['amount'],2)); ?></td> 		
			</tr>
	<?php
		}
	?>

		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql_6 = mysqli_query ($con_main, $query6);
			
		
			while ($row = mysqli_fetch_array ($sql_6)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest9 = $tot_interest + $row['amount'];
				
	?>
			<tr>
					<td><?php echo ($row['entered_date']); ?></td>
					<td><?php echo ($row['category']); ?></td>
					<td><?php echo ($row['expcat']); ?></td>
					<td><?php echo (number_format($row['amount'],2)); ?></td> 		
			</tr>
	<?php
		}
	?>


		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql_7 = mysqli_query ($con_main, $query7);
			
		
			while ($row = mysqli_fetch_array ($sql_7)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest10 = $tot_interest + $row['amount'];
				
	?>
			<tr>
					<td><?php echo ($row['entered_date']); ?></td>
					<td><?php echo ($row['category']); ?></td>
					<td><?php echo ($row['expcat']); ?></td>
					<td><?php echo (number_format($row['amount'],2)); ?></td> 		
			</tr>
	<?php
		}
	?>


		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql_8 = mysqli_query ($con_main, $query8);
			
		
			while ($row = mysqli_fetch_array ($sql_8)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest11 = $tot_interest + $row['amount'];
				
	?>
			<tr>
					<td><?php echo ($row['entered_date']); ?></td>
					<td><?php echo ($row['category']); ?></td>
					<td><?php echo ($row['expcat']); ?></td>
					<td><?php echo (number_format($row['amount'],2)); ?></td> 		
			</tr>
	<?php
		}
	?>


	<tr>
		<td colspan="3"><strong><center>TOTAL</center></strong></td>			
			
			<!-- <td><strong><?php //echo (number_format($tot_interest,2)); ?></strong></td> -->	
			<td><strong><?php echo (number_format($tot_interest8 + $tot_interest8 + $tot_interest8 + $tot_interest11 + $tot_interest10 +$tot_interest10 ,2)); ?></strong></td>			
		</td>
	</tr>

	</tbody>	
</table>
</div>









	


