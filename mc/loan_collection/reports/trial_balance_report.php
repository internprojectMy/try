<?php

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$search = $_REQUEST['search'];
$branch_id = $_REQUEST['branch_id'];
require_once ('../../config.php');
require_once ('../../reporting_part/report_header_oa15.php');

?>

<?php  

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


    $query1 = "SELECT
			Sum(loan_transactionexp.amount),
				loan_transactionexp.expcat,
				loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Administration Expenses' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
					loan_transactionexp.category,
					loan_transactionexp.expcat";
					
	$query2 = "SELECT
					Sum(loan_transactionexp.amount),
					loan_transactionexp.expcat,
					loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Sales Expenses' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
					loan_transactionexp.category,
					loan_transactionexp.expcat";
					
					
	 $query3 = "SELECT
					Sum(loan_transactionexp.amount),
					loan_transactionexp.expcat,
					loan_expenses.category
				FROM
					loan_transactionexp
				INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
				INNER JOIN branch ON loan_transactionexp.branch_name = branch.branch_id
				WHERE
				loan_transactionexp.expcat = 'Finance & Other Expenses' AND
				loan_transactionexp.branch_name = '1' AND
				loan_transactionexp.entered_date BETWEEN '$from' AND '$to'
				GROUP BY
					loan_transactionexp.category,
					loan_transactionexp.expcat";
					
	$query4 = "SELECT
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
					
    $query5 = "SELECT
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
					
					
	$query6 = "SELECT
                	capital.id,
                	capital.category,
                Sum(capital.amount),
                capital.`comment`,
                	capital.date,
                	capital.expenses_type,
                	capital.`status`
                FROM
                	capital
                WHERE
                	capital.date BETWEEN '$from'
                AND '$to'";
                
                
    $query7 = "SELECT
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
				
				
	$query8 = "SELECT
				    Sum(loan_lending.loan_amount)
					  FROM
					loan_lending
				WHERE
			loan_lending.startdate BETWEEN '$from' AND '$to'";
			
			
			
			
		    
	 $query9 = "SELECT
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
                    
    $sql9 = mysqli_query($con_main, $query9);
    $query_rows = mysqli_num_rows($sql9);

   while ($row = mysqli_fetch_array ($sql9)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest9 = $tot_interest9 + $row['paid'];
        }                
				
    
    
    $query10 = "SELECT
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
                                            
     $query11 = "SELECT
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
                                            
?>





<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
		<thead>
			<tr>
				<th width="740px">Description</th>
				<th>Debit</th>
				<th style="width:298px;">Credit</th>
			</tr>
		</thead>

	<tbody>
       	    <tr>
		        <td colspan="1">Interest Income</td>			
			    <td><strong><?php echo (number_format($total_interest_amount,2)); ?></strong></td>		
	        </tr>
	        
	<?php

		    $tot_amt = 0;
		    $tot_interest1 = 0;
			$sql1 = mysqli_query ($con_main, $query1);
			
		
			while ($row = mysqli_fetch_array ($sql1)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest1 = $tot_interest1 + $row['Sum(loan_transactionexp.amount)'];

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
			$sql2 = mysqli_query ($con_main, $query2);
			
		
			while ($row = mysqli_fetch_array ($sql2)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest2 = $tot_interest2 + $row['Sum(loan_transactionexp.amount)'];

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
		    $tot_interest3 = 0;
			$sql3 = mysqli_query ($con_main, $query3);
			
		
			while ($row = mysqli_fetch_array ($sql3)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest3 = $tot_interest3 + $row['Sum(loan_transactionexp.amount)'];

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
		    $tot_interest4 = 0;
			$sql4 = mysqli_query ($con_main, $query4);
			
		
			while ($row = mysqli_fetch_array ($sql4)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest4 = $tot_interest4 + $row['Sum(loan_transactionexp.amount)'];

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
		    $tot_interest5 = 0;
			$sql5 = mysqli_query ($con_main, $query5);
			
		
			while ($row = mysqli_fetch_array ($sql5)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest5 = $tot_interest5 + $row['Sum(loan_transactionexp.amount)'];

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
		    $tot_interest6 = 0;
			$sql6 = mysqli_query ($con_main, $query6);
			
		
			while ($row = mysqli_fetch_array ($sql6)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest6 = $tot_interest6 + $row['Sum(capital.amount)'];

	?>
			<tr>
				<td><?php echo ($row['category']); ?></td>

			<td><?php echo ($row['']); ?></td>
				<td><?php echo (number_format($row['Sum(capital.amount)'],2)); ?></td>					
			</tr>
	<?php
		}
	?>
	
	
	<?php

		    $tot_amt = 0;
		    $tot_interest7 = 0;
			$sql7 = mysqli_query ($con_main, $query7);
			
		
			while ($row = mysqli_fetch_array ($sql7)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest7 = $tot_interest7 + $row['Sum(loan_transactionexp.amount)'];

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
		    $tot_interest8 = 0;
			$sql8 = mysqli_query ($con_main, $query8);
			
		
			while ($row = mysqli_fetch_array ($sql8)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest8 = $tot_interest8 + $row['Sum(loan_transactionexp.amount)'];
             


	?>
			<tr>
				<td>Loan Stock</td>
				<td><?php echo (number_format($row['Sum(loan_lending.loan_amount)'] - $total_loan_paid_amount  ,2)); ?></td>				
				
				
			</tr>
          
	<?php
		}
	?>
	
	
		<?php

		    $tot_amt = 0;
		    $tot_interest10 = 0;
			$sql10 = mysqli_query ($con_main, $query10);
			
		
			while ($row = mysqli_fetch_array ($sql10)){

				$tot_amt = $tot_amt + $row[''];
				$tot_interest10 = $tot_interest10 + $row['document_amount'];
             


	?>
			<tr>
				<td colspan="2">Document Charges</td>
				<td><?php echo (number_format($tot_interest10 ,2)); ?></td>
			</tr>
          
	<?php
		}
	?>
	
	
	
	
	        





	



 </tbody>




        
           	 					
</table>                           
