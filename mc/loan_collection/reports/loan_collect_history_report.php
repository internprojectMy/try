<?php

$date = $_REQUEST['date'];
$search = $_REQUEST['search'];
require_once ('../../config.php');
require_once ('../../reporting_part/report_header_oa6.php');
 
	$query = "SELECT
			loan_customer.name_full,
			loan_customer.nic,
			loan_lending.net_payment,
			loan_lending.loan_amount,
			loan_lending.loan_type,
			cash_collecting.paid,
			cash_collecting.total,
			loan_lending.startdate,
			loan_lending.enddate,
			loan_lending.loanid,
			loan_lending.interest_amount,
			loan_lending.due_amount
			FROM
			loan_customer
			INNER JOIN loan_lending ON loan_customer.nic = loan_lending.nic
			INNER JOIN cash_collecting ON loan_lending.loanid = cash_collecting.loanid";


?>

<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
						<thead>
							<tr>
							<th>Customer Name</th>							
							<th>Customer NIC</th>
							<th>Loan ID</th>
							<th>Loan Type</th>
							<th>Loan Balance</th>
							<th>Payment Received</th>
							<th>Net Amount</th>	
							<th>Received Amount</th>	
							<th>Start Date</th>
							<th>End Date</th>						
						</tr>
						</thead>

						<tbody>
		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
			$sql = mysqli_query ($con_main, $query);
		
			while ($row = mysqli_fetch_array ($sql)){

				$tot_amt = $tot_amt + $row['loan_amount'];
				$tot_interest = $tot_interest + $row['LOAN_INTEREST'];
		?>
								<tr>
								<td><?php echo ($row['name_full']); ?></td>
								<td><?php echo ($row['nic']); ?></td>
								<td><?php echo ($row['loanid']); ?></td>
								
								<td><?php echo ($row['loan_type']); ?></td>
								<td><?php echo (number_format ($row['loan_amount'])); ?></td>
								<td><?php echo (number_format ($row['interest_amount'])); ?></td>
								<td><?php echo (number_format ($row['net_payment'])); ?></td>
								<td><?php echo (number_format($today_received,2)); ?></td>
								<td><?php echo ($start_date); ?></td>
								<td><?php echo ($end_date); ?></td>														
							</tr>
	<?php
							}
	?>
	<tr>
		<td colspan="5"><strong><center>TOTAL</center></strong></td>			
			
			<td></td>
			<td><strong><?php echo (number_format($tot_amt,2)); ?></strong></td>		
		</td>
	</tr>
	</tbody>	
</table>                               
