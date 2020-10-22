<!-- SELECT
loan_customer.name_full,
loan_customer.customer_mobile1,
loan_customer.center_name
FROM
loan_customer
WHERE
loan_customer.group_name = '2' -->

<?php

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$search = $_REQUEST['search'];
$nic = $_REQUEST['nic'];
require_once ('../../config.php');

$sql = "SELECT
			loan_customer.name_full,
			loan_customer.customer_mobile1,
			loan_customer.spouse_name,
			loan_customer.nic,
			loan_lending.nic
			FROM
			loan_lending

			INNER JOIN loan_customer ON loan_customer.nic = '$nic'";

$cus_details_sql = mysqli_query($con_main,$sql);
$cus_details_res = mysqli_fetch_assoc($cus_details_sql);
$cus_name = $cus_details_res['name_full'];
$cus_nic = $cus_details_res['nic'];
$customer_mobile1 = $cus_details_res['customer_mobile1'];
$spouse_name = $cus_details_res['spouse_name'];
$spouse_contact = $cus_details_res['spouse_contact'];



require_once ('../../reporting_part/report_header_oa1.php');
 
	$query = "SELECT
				loan_customer.id,
				loan_lending.loanid,
				loan_customer.nic,
				loan_lending.loan_date,
				loan_lending.startdate,
				loan_lending.enddate,
				loan_lending.loan_amount,
				loan_lending.interest_amount,
				loan_lending.net_payment,
				loan_lending.duration,
				loan_lending.due_amount,
				center.center_id,
				center.center_name
				FROM
				loan_customer
				INNER JOIN loan_lending ON loan_customer.nic = loan_lending.nic
				INNER JOIN center ON center.center_id = loan_customer.center_name
				WHERE
				loan_customer.nic = '$nic' AND
				loan_lending.loan_date BETWEEN '$from'
				AND '$to'";



?>



<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
						<thead>
						<tr>
							<th>Loan Id</th>
							<th>NIC No</th>						
							<th>Center</th>
							<th>Investment Amount</th>
							<th>Interest Rate</th>
							<th>Net Amount</th>
							<th>Amount Of Installment</th>
							<th>Loan Balance</th>
							<th>Loan Duration</th>
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

				$tot_amt = $tot_amt + $row[''];
				$tot_interest = $tot_interest + $row['net_payment'];
				
				$tot_interest1 = $tot_interest1 + $row['loan_amount'];
				
				
			$loan_id = $row['loanid'];

			$collect_amount_query = "SELECT
											Sum(cash_collecting.paid) AS TOTAL_PAID
										FROM
											cash_collecting
										WHERE
											cash_collecting.loanid = '$loan_id'
										AND cash_collecting.today BETWEEN '$from'
										AND '$to'";

				$collect_amount_sql = mysqli_query($con_main,$collect_amount_query);
                $collect_amount_res = mysqli_fetch_assoc($collect_amount_sql);
                $total_paid_amount = $collect_amount_res['TOTAL_PAID'];
                $bal_available = $row['net_payment']-$total_paid_amount; 	

		?>


							<tr>
								<td><?php echo ($row['loanid']); ?></td>
								<td><?php echo ($row['nic']); ?></td>
								<td><?php echo ($row['center_name']); ?></td>
								<td><?php echo (number_format($row['loan_amount'],2)); ?></td>
								<td><?php echo ($row['interest_amount']); ?></td>
								<td><?php echo (number_format($row['net_payment'],2)); ?></td>
								<td><?php echo (number_format($row['due_amount'],2)); ?></td>
								<td><?php echo(number_format($bal_available,2)) ?></td>
								<td><?php echo ($row['duration']); ?></td>
								<td><?php echo ($row['startdate']); ?></td>
								<td><?php echo ($row['enddate']); ?></td>
								
															
							</tr>
	<?php
							}
	?>
<tr>
		<td colspan="3"><strong><center>TOTAL</center></strong></td>			
			<td><strong><?php echo (number_format($tot_interest1,2)); ?></strong></td>
			<td></td>
			<td><strong><?php echo (number_format($tot_interest,2)); ?></strong></td>			
		</td>
	</tr> 
	</tbody>	
</table>                        


