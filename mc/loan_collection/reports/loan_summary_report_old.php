<?php

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$search = $_REQUEST['search'];
require_once ('../../config.php');
require_once ('../../reporting_part/report_header_oa2.php');
$today = date('Y-m-d');
$curr_month = date('m');
$curr_year = date('Y');
 
	$query = "SELECT
				loan_customer.id,
				loan_lending.loanid,
				loan_customer.nic,
				loan_lending.loan_date,
				loan_lending.startdate,
				loan_lending.enddate,
				loan_lending.loan_amount,
				loan_lending.duration,
				loan_lending.interest_amount,
				loan_lending.net_payment,
				loan_customer.name_full,
				loan_lending.loan_type,
				center.center_id,
				center.center_name
				FROM
				loan_customer
				INNER JOIN loan_lending ON loan_customer.nic = loan_lending.nic
				INNER JOIN center ON center.center_id = loan_customer.center_name
					WHERE
				loan_lending.loan_date BETWEEN '$from'
				AND '$to'";


?>


<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%" id="tblexportData">
						<thead>
						<tr>
							<th>Loan ID</th>
							<th>Customer Name</th>							
							<th>Customer NIC</th>
							<th>Center</th>
							<th>Investment Amount</th>
							<th>Interest Rate</th>
							<th>Net Balance</th>
							<th>Duration</th>
							<th>Loan Balance</th>
							<th>Start Date</th>
							<th>End Date</th>						
						</tr>
						</thead>

						<tbody>
		<?php

		    $tot_amt = 0;
		    $tot_interest = 0;
		    $tot_amt1 = 0;
		    $tot_interest1 = 0;
			$sql = mysqli_query ($con_main, $query);
		
			while ($row = mysqli_fetch_array ($sql)){

				$tot_amt = $tot_amt + $row['net_payment'];
				$tot_interest = $tot_interest + $row['net_payment'];

				$tot_amt1 = $tot_amt1 + $row['loan_amount'];
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
                $start = $row['startdate'];
                $end = $row['enddate'];

             	$balance = $row['net_payment'] - $row['loan_amount'];
                $month = date("m",strtotime($start));
				$year = date("Y",strtotime($start));

				if($year == $curr_year){
					if($month != 12){

						$month_gap = $curr_month - $month;

					}else{
						/*if(){

							$month_gap = $curr_month - $month;

						}*/

						

					}

				}else{


				}

				$d = ($balance / 4 )* $month_gap;
				$final = $balance + $d;



		?>
							<tr>
								<td><?php echo ($row['loanid']); ?></td>
								<td><?php echo ($row['name_full']); ?></td>
								<td><?php echo ($row['nic']); ?></td>
								<td><?php echo ($row['center_name']); ?></td>
								<td><?php echo ($row['loan_amount']); ?></td>
								<td><?php echo ($row['interest_amount']); ?></td>
								<td><?php echo (number_format($row['net_payment'],2)); ?></td>
								<td><?php echo ($row['duration']); ?></td>

								<td><?php echo(number_format($final,2)) ?></td>
								<td><?php echo ($start); ?></td>
								<td><?php echo ($row['enddate']); ?></td>
																							
							</tr>
	<?php
							}
	?>
	<tr>
		<td colspan="4"><strong><center>TOTAL</center></strong></td>			
			<td><strong><?php echo (number_format($tot_interest1,2)); ?></strong></td>	
			<td></td>
			<td><strong><?php echo (number_format($tot_interest,2)); ?></strong></td>		
		</td>
	</tr>
	</tbody>	
</table>                               
