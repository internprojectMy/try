<?php

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$search = $_REQUEST['search'];
$branch_id = $_REQUEST['branch_id'];
require_once ('../../config.php');
require_once ('../../reporting_part/report_header_oa9.php');


$interest_query = "SELECT
						loan_lending.interest_amount,
						cash_collecting.paid,
						loan_lending.loanid
					FROM
						loan_lending
					INNER JOIN cash_collecting ON cash_collecting.loanid = loan_lending.id
					WHERE
						cash_collecting.today BETWEEN '$from'
					AND '$to'";

$interest_sql = mysqli_query($con_main,$interest_query);
$total_interest_amount = 0;
$total_loan_paid_amount = 0;
while($interest_res = mysqli_fetch_assoc($interest_sql)){
	$interest_amount = round($interest_res['paid'],2) * (round($interest_res['interest_amount'],2)/120);
	$load_paid_amount = round($interest_res['paid'],2) - round($interest_amount,2);

	$total_interest_amount = $total_interest_amount + $interest_amount;
	$total_loan_paid_amount = $total_loan_paid_amount + $load_paid_amount;  
}
 
	$query2 = "SELECT
					Sum(loan_lending.net_payment),
					Sum(loan_lending.loan_amount),
					branch.branch_name
					FROM
					loan_lending
					INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
					INNER JOIN branch ON loan_customer.branch_name = branch.branch_id
					WHERE
					loan_lending.startdate BETWEEN '$from' AND '$to' AND
					loan_customer.branch_name = '$branch_id'";


$query = "SELECT
				loan_transactionexp.category,
				Sum(loan_transactionexp.amount),
				loan_expenses.category,
				branch.branch_name
				FROM
				loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON branch.branch_id = loan_transactionexp.branch_name
				WHERE
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
				loan_transactionexp.branch_name = '$branch_id'
				GROUP BY
					loan_transactionexp.category
			";	

$query3 = "SELECT
				other_income.category,
				Sum(other_income.amount)
				FROM `other_income`
				WHERE
				other_income.date BETWEEN '$from' AND '$to'
				GROUP BY
				other_income.category";


$query4 = "SELECT
				Sum(loan_transactionexp.amount),
				loan_transactionexp.expcat,
				loan_transactionexp.expencestype,
				loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Administration Expenses' AND
				loan_transactionexp.branch_name = '$branch_id' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
				loan_transactionexp.expcat,
				loan_transactionexp.expencestype,
				loan_expenses.category
				";			 

						
$query5 = "SELECT
				Sum(loan_transactionexp.amount),
				loan_transactionexp.expcat,
				loan_transactionexp.expencestype,
				loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Marketing Expenses' AND
				loan_transactionexp.branch_name = '$branch_id' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
				loan_transactionexp.expcat,
				loan_transactionexp.expencestype,
				loan_expenses.category";

$query6 = "SELECT
				Sum(document_charges.document_amount),
				document_charges.type,
				loan_customer.branch_name,
				branch.branch_name
				FROM
				document_charges
				INNER JOIN loan_lending ON document_charges.loanno = loan_lending.loanid
				INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
				INNER JOIN branch ON loan_customer.branch_name = branch.branch_id
				WHERE
				document_charges.doc_date BETWEEN '$from' AND '$to' AND
				loan_customer.branch_name = '$branch_id'
				GROUP BY
					document_charges.type";	


$query7 = "SELECT
				Sum(loan_transactionexp.amount),
				loan_transactionexp.expcat,
				loan_transactionexp.expencestype,
				loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Finance & Other Expenses' AND
				loan_transactionexp.branch_name = '$branch_id' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
				loan_transactionexp.expcat,
				loan_transactionexp.expencestype,
				loan_expenses.category";				

$query8 = "SELECT
				Sum(loan_transactionexp.amount),
				loan_transactionexp.expcat,
				loan_transactionexp.expencestype,
				loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Sales Expenses' AND
				loan_transactionexp.branch_name = '$branch_id' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
				loan_transactionexp.expcat,
				loan_transactionexp.expencestype,
				loan_expenses.category";

?>


<!--========================================INCOME===========================-->

<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
						<thead>
						<tr>
							<th width="740px">Income</th>
							<th>$</th>
							<th style="width:298px;">cumulative</th>									
						
						</tr>
						</thead>

						<tbody>
		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql2 = mysqli_query ($con_main, $query2);
		
			while ($row = mysqli_fetch_array ($sql2)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest1 = $tot_interest + $row[''];

				$net =  $row['Sum(loan_lending.net_payment)'];
				$loan = $row['Sum(loan_lending.loan_amount)'];

				$balance = $row['Sum(loan_lending.net_payment)'] - $row['Sum(loan_lending.loan_amount)'];


				
                              

		?>
						<!-- 	<tr>
							<td style="display: none;">Investment Income</td>
							<td></td>
							<td style="display: none;"><?php echo (number_format($row['Sum(loan_lending.net_payment)'])); ?></td>														
							</tr>
							<tr>
								<td style="display: none;">investment expenses </td>
								<td></td>	
								<td style="display: none;"><?php echo (number_format($row['Sum(loan_lending.loan_amount)'])); ?></td>
																					
							</tr> -->

			<tr>

		<td colspan="2"><strong>Interest Income </strong></td>			
			
			<td><strong><?php echo (number_format($total_interest_amount,2)); ?></strong></td>		
		</td>
	</tr>
	<?php
							}
	?>

	<!--====================================== DOCUMENT CHARGES TABLE =================================-->
 </tbody>

		<tbody>
			<tr>
				<th style="float: left;">Other Income</th>
			</tr>
		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql7 = mysqli_query ($con_main, $query6);
		
			while ($row = mysqli_fetch_array ($sql7)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest25 = $tot_interest25 + $row['Sum(document_charges.document_amount)'];
                
                
				 

		?>

							<tr>
							<td><?php echo ($row['type']); ?></td>
							<td><?php echo (number_format($row['Sum(document_charges.document_amount)'])); ?></td>
							<td></td>
							
																							
							</tr>
	<?php
							}
	?>
	<tr>

		<td colspan="2"><b>OTHER INCOME TOTAL</b></td>			
			
			<td><strong><?php echo (number_format($tot_interest25,2)); ?></strong></td>		
		</td>
	</tr>

<!-- 	<tr>
		<td>Gross profit</td>
		<td><?php echo (number_format($balance,2)); ?></td>	
	</tr>
		<tr>
		<td>Other Income</td>
		<td><?php echo (number_format($tot_interest,2)); ?></td>	
	</tr>
 -->
		<tr>

		<td colspan="2"><strong><center> TOTAL</center></strong></td>			
			
			<td><strong><?php echo (number_format($total_interest_amount + $tot_interest25,2)); ?></strong></td>		
		</td>
	</tr>
           <?php 

        $total = $balance + $tot_interest;
        

       ?>
               			<?php $othertotle = $balance + $tot_interest;
			    
			
			?>
	</tbody>	 
</table>
<br>

<!---=========================================Expenses table=======================================================-->

<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
						<thead>
						<tr>
							<th width="720px">Expenses</th>
							<th width="240px">$</th>
							<th width="290px">Cumulative</th>							
											
						</tr>

						</thead>

<!-- 						<tbody>
		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql = mysqli_query ($con_main, $query);
		
			while ($row = mysqli_fetch_array ($sql)){

				$tot_amt = $tot_amt + $row['Sum(loan_transactionexp.amount)'];
				$tot_interest = $tot_interest + $row['Sum(loan_transactionexp.amount)'];
		?>
							<tr>
							<td><?php echo ($row['category']); ?></td>
							<td><?php echo (number_format($row['Sum(loan_transactionexp.amount)'])); ?></td>
							<td></td>
																							
							</tr>
	<?php
							}
	?>
	<tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td><strong><?php echo (number_format($tot_interest,2)); ?></strong></td>		
		</td>
	</tr>
 	<tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td style="height: 22px;"><strong></strong></td>
		
		</td>
	</tr>

		<tr>
		<td colspan="2"><strong><center>TOTAL PROFIT</center></strong></td>			
			
			
			<td><strong><?php echo (number_format($total - $tot_interest ,2)); ?></strong></td>		
		</td>
	</tr> -->
	</tbody>
		<tbody>
			  <tr>
		          <th style="float: left;">Administration Expenses</th>
		       </tr>
		<?php

		    $tot_amt = 0;
		    $tot_interest6 = 0;
			$sql5 = mysqli_query ($con_main, $query4);
		
			while ($row = mysqli_fetch_array ($sql5)){

				$tot_amt = $tot_amt + $row['Sum(loan_transactionexp.amount)'];
				$tot_interest6 = $tot_interest6 + $row['Sum(loan_transactionexp.amount)'];
		?>
		                
							<tr>
							<td><?php echo ($row['category']); ?></td>
							<td><?php echo (number_format($row['Sum(loan_transactionexp.amount)'])); ?></td>
							<td></td>
																							
							</tr>
	<?php
							}
	?>
	<tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td><strong><?php echo (number_format($tot_interest6,2)); ?></strong></td>		
		</td>
	</tr>
	<!-- <tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td style="height: 22px;"><strong></strong></td>
		
		</td>
	</tr>

		<tr>
		<td colspan="2"><strong><center>TOTAL PROFIT</center></strong></td>			
			
			
			<td><strong><?php echo (number_format($total - $tot_interest ,2)); ?></strong></td>		
		</td>
	</tr> -->
	</tbody>
		<tbody>
			  <tr>
		          <th style="float: left;">Marketing Expenses</th>
		       </tr>
		<?php

		    $tot_amt = 0;
		    $tot_interest7 = 0;
			$sql6 = mysqli_query ($con_main, $query5);
		
			while ($row = mysqli_fetch_array ($sql6)){

				$tot_amt = $tot_amt + $row['Sum(loan_transactionexp.amount)'];
				$tot_interest7 = $tot_interest7 + $row['Sum(loan_transactionexp.amount)'];
		?>
		                
							<tr>
							<td><?php echo ($row['category']); ?></td>
							<td><?php echo (number_format($row['Sum(loan_transactionexp.amount)'])); ?></td>
							<td></td>
																							
							</tr>
	<?php
							}
	?>
	<tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td><strong><?php echo (number_format($tot_interest7,2)); ?></strong></td>		
		</td>
	</tr>

				  <tr>
		          <th style="float: left;">Sale Expenses</th>
		       </tr>
		<?php

		    $tot_amt = 0;
		    $tot_interest8 = 0;
			$sql8 = mysqli_query ($con_main, $query8);
		
			while ($row = mysqli_fetch_array ($sql8)){

				$tot_amt8 = $tot_amt8 + $row['Sum(loan_transactionexp.amount)'];
				$tot_interest8 = $tot_interest8 + $row['Sum(loan_transactionexp.amount)'];
		?>
		                
							<tr>
							<td><?php echo ($row['category']); ?></td>
							<td><?php echo (number_format($row['Sum(loan_transactionexp.amount)'])); ?></td>
							<td></td>
																							
							</tr>
	<?php
							}
	?>
	<tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td><strong><?php echo (number_format($tot_interest7,2)); ?></strong></td>		
		</td>
	</tr>
<!-- 	<tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td style="height: 22px;"><strong></strong></td>
		
		</td>
	</tr>

		<tr>
		<td colspan="2"><strong><center>TOTAL PROFIT</center></strong></td>			
			
			
			<td><strong><?php echo (number_format($total - $tot_interest ,2)); ?></strong></td>		
		</td>
	</tr> -->
	</tbody>
		<tbody>
			  <tr>
		          <th style="float: left;">Finance & Other Expenses</th>
		       </tr>
		<?php

		    $tot_amt = 0;
		    $tot_interest8 = 0;
			$sql8 = mysqli_query ($con_main, $query7);
		
			while ($row = mysqli_fetch_array ($sql8)){

				$tot_amt = $tot_amt + $row['Sum(loan_transactionexp.amount)'];
				$tot_interest8 = $tot_interest8 + $row['Sum(loan_transactionexp.amount)'];
		?>
		                
							<tr>
							<td><?php echo ($row['category']); ?></td>
							<td><?php echo (number_format($row['Sum(loan_transactionexp.amount)'])); ?></td>
							<td></td>
																							
							</tr>
	<?php
							}
	?>
	<tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td><strong><?php echo (number_format($tot_interest8,2)); ?></strong></td>		
		</td>
	</tr>
	<tr>
		<td colspan="2"><strong><center></center></strong></td>			
			
			
			<td style="height: 22px;"><strong></strong></td>
		
		</td>
	</tr>

		<tr>
		<td colspan="2">Total Expenses</td>			
			
			
			<td><strong><?php echo (number_format($tot_interest6 + $tot_interest7 + $tot_interest8 ,2)); ?></strong></td>		
		</td>
			<?php 
			   
			   $totalexpense = $tot_interest6 + $tot_interest7 + $tot_interest8;
			   
			     $total = $total_interest_amount + $tot_interest25;
			   
			?>
	</tr>
		<tr>
		<td colspan="1"><strong><center>TOTAL PROFIT</center></strong></td>			
			
			
		<td><strong><?php echo (number_format($total - $totalexpense ,2)); ?></strong></td>	

		</td>
		<td></td>
		</tr>
	</tbody>		
</table>                           
