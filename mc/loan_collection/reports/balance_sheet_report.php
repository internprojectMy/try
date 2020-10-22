<?php

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$search = $_REQUEST['search'];
$branch_id = $_REQUEST['branch_id'];
require_once ('../../config.php');
require_once ('../../reporting_part/report_header_oa16.php');
 


	$query = "SELECT
					Sum(cash_collecting.net_payment)
					FROM
						cash_collecting
					INNER JOIN branch ON branch.branch_id = cash_collecting.branch_name
					WHERE
						cash_collecting.branch_name = '1'
					AND cash_collecting.today BETWEEN '$from' AND '$to'";
												


		$query2 = "SELECT
					Sum(document_charges.document_amount)
							FROM
				document_charges
				INNER JOIN loan_lending ON loan_lending.loanid = document_charges.loanno
				INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
				INNER JOIN branch ON branch.branch_id = loan_customer.branch_name
						WHERE
				loan_customer.branch_name = '1' 
				AND document_charges.doc_date BETWEEN '$from' AND '$to'";


	$query3 = "SELECT
				Sum(loan_transactionexp.amount)
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				LEFT JOIN branch ON branch.branch_name = loan_transactionexp.branch_name
				WHERE
					loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				AND loan_transactionexp.branch_name = '1'";




	 $query4 = "SELECT
					Sum(loan_lending.net_payment)
					FROM
						loan_lending
					INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
					WHERE
						loan_lending.startdate BETWEEN '2019-09-10'
					AND '2019-12-01'
					AND loan_customer.branch_name = '1'";									


	 $query5 = "SELECT
					Sum(loan_transactionexp.amount),
					loan_transactionexp.expcat,
					loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Marketing Expenses' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
					loan_transactionexp.category,
					loan_transactionexp.expcat";	
						
   

	 $query6 = "SELECT
					Sum(loan_transactionexp.amount),
					loan_transactionexp.expcat,
					loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Liability' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
					loan_transactionexp.category,
					loan_transactionexp.expcat";

		
	 $query7 = "SELECT
					Sum(loan_transactionexp.amount),
					loan_transactionexp.expcat,
					loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Capital' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
					loan_transactionexp.category,
					loan_transactionexp.expcat";


	$query8 = "SELECT
				Sum(loan_transactionexp.amount),
				loan_transactionexp.expcat,
				loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Asset' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
				loan_transactionexp.category = 21
				GROUP BY
				loan_transactionexp.category,
				loan_transactionexp.expcat,
				loan_expenses.category";


	$query9 = "SELECT
				Sum(loan_transactionexp.amount),
				loan_transactionexp.expcat,
				loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Asset' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
				loan_transactionexp.category = 2
				GROUP BY
				loan_transactionexp.category,
				loan_transactionexp.expcat,
				loan_expenses.category";




		$query10 = "SELECT
						Sum(loan_lending.loan_amount)
						FROM
						loan_lending
						WHERE
						loan_lending.startdate BETWEEN '$from' AND '$to''";


		
		$query11 = "SELECT
				Sum(loan_transactionexp.amount),
				loan_transactionexp.expcat,
				loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Asset' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
				loan_transactionexp.category = 2
				GROUP BY
				loan_transactionexp.category,
				loan_transactionexp.expcat,
				loan_expenses.category";						
																							

?>




<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
						<thead>
						<tr>
							<th width="740px">Description</th>
							<th>$</th>
							<th style="width:298px;">$</th>							
						
						</tr>
						</thead>

	<tbody>


            <tr>
            	<td align="left"><strong>Assest</strong></td>
            	<td></td>
            	<td></td>
            </tr>
            <tr>
            	<td align="left"><u><b>Non Current Assest</b></u></td>
            </tr>


				<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql9 = mysqli_query ($con_main, $query9);
			
		
			while ($row = mysqli_fetch_array ($sql9)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest9 = $tot_interest + $row['Sum(loan_transactionexp.amount)'];



	?>
			<tr>
				<td><?php echo ($row['category']); ?></td>
			<td><?php echo ($row['']); ?></td> 
				<td><?php echo (number_format($row['Sum(loan_transactionexp.amount)'],2)); ?></td>					
			</tr>
	<?php
		}
	?>

			<?php

		    $tot_amt = 0;
		    $tot_interest2 = 0;
			$sql8 = mysqli_query ($con_main, $query8);
			
		
			while ($row = mysqli_fetch_array ($sql8)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest10 = $tot_interest2 + $row['Sum(loan_transactionexp.amount)'];



	?>
			<tr>
				<td><?php echo ($row['category']); ?></td>
			<!-- <td><?php echo (number_format($tot_interest10 - $tot_interest9 ,2)); ?></td> -->
				<td><?php echo (number_format($tot_interest10 - $tot_interest9 ,2)); ?></td>					
			</tr>
	<?php
		}
	?>

			<tr>

		<td colspan="1"><strong><center> Total Non Current Assest</center></strong></td>			
			
			<td></td>
			<td><strong><?php echo (number_format($tot_interest9 + $tot_interest10 ,2)); ?></strong></td>	
		</td>
	</tr>


		<tr>
            	<td align="left"><u><b>Current Assest</b></u></td>
            </tr>





		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql = mysqli_query ($con_main, $query);
			
		
			while ($row = mysqli_fetch_array ($sql)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest1 = $tot_interest + $row['Sum(cash_collecting.net_payment)'];

	?>
	
	<?php
		}
	?>

	<?php

		    $tot_amt = 0;
		    $tot_interest2 = 0;
			$sql2 = mysqli_query ($con_main, $query2);
			
		
			while ($row = mysqli_fetch_array ($sql2)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest2 = $tot_interest2 + $row['Sum(document_charges.document_amount)'];

	?>

	<?php
		}
	?>


	<?php

		    $tot_amt = 0;
		    $tot_interest2 = 0;
			$sql3 = mysqli_query ($con_main, $query3);
			
		
			while ($row = mysqli_fetch_array ($sql3)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest3 = $tot_interest2 + $row['Sum(loan_transactionexp.amount)'];


	?>

	<?php
		}
	?>

	<?php

		    $tot_amt = 0;
		    $tot_interest2 = 0;
			$sql4 = mysqli_query ($con_main, $query4);
			
		
			while ($row = mysqli_fetch_array ($sql4)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest4 = $tot_interest2 + $row['Sum(loan_lending.net_payment)'];



	?>

	<?php
		}
	?>


		<?php

		   $cashin =  $tot_interest4 + $tot_interest3;
		   $cashout = $tot_interest1 + $tot_interest2;

	?>
			<tr>
				<td>Cash Book</td>
			
				<td><?php echo (number_format($cashin - $cashout ,2)); ?></td>
				<td><?php echo ($row['']); ?></td> 				
			</tr>



  	<?php

		   $cashin =  $tot_interest4 + $tot_interest3;
		   $cashout = $tot_interest1 + $tot_interest2;

	?>
			<tr>
				<td>Petty Cash</td>
			
				<td><?php echo (number_format($cashin - $cashout ,2)); ?></td>
				<td><?php echo ($row['']); ?></td> 				
			</tr>			


<?php

		    $tot_amt = 0;
		    $tot_interest2 = 0;
			$sql7 = mysqli_query ($con_main, $query7);
			
		
			while ($row = mysqli_fetch_array ($sql7)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest7 = $tot_interest2 + $row['Sum(loan_transactionexp.amount)'];

	?>
			<tr>
				<td>Capital</td>
			
				<td><?php echo (number_format($row['Sum(loan_transactionexp.amount)'],2)); ?></td>
				<td><?php echo ($row['']); ?></td> 			
			</tr>
	<?php
		}
	?>


	   <tr>
	   	  <th align="left"><b><u>Liability</u></b></th>
	   </tr>


	<?php

		    $tot_amt = 0;
		    $tot_interest2 = 0;
			$sql6 = mysqli_query ($con_main, $query6);
			
		
			while ($row = mysqli_fetch_array ($sql6)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest6 = $tot_interest2 + $row['Sum(loan_transactionexp.amount)'];

	?>
			<tr>
			    <td>Liability</td>
				<td><?php echo (number_format($row['Sum(loan_transactionexp.amount)'],2)); ?></td>
				<td><?php echo ($row['']); ?></td> 			
			</tr>
	<?php
		}
	?>



<?php

		    $tot_amt = 0;
		    $tot_interest2 = 0;
			$sql10 = mysqli_query ($con_main, $query10);
			
		
			while ($row = mysqli_fetch_array ($sql10)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest10 = $tot_interest2 + $row['Sum(loan_transactionexp.amount)'];

	?>
			<tr>
				<td>Loan Stock</td>
			<!-- <td><?php echo (number_format($tot_interest10 - $tot_interest9 ,2)); ?></td> -->
				<td><?php echo (number_format($row['Sum(loan_lending.loan_amount)'],2)); ?></td>					
			</tr>
	<?php
		}
	?>






 </tbody>



		<tr>

		<td colspan="1"><strong><center> TOTAL</center></strong></td>			
			
			<td><strong><?php echo (number_format($tot_interest1 + $tot_interest7,2)); ?></strong></td>
			<td><strong><?php echo (number_format($tot_interest2 + $tot_interest4 + $tot_interest3 + $tot_interest5 + $tot_interest7 ,2)); ?></strong></td>	
		</td>
	</tr>
        
           	 					
</table>                           
