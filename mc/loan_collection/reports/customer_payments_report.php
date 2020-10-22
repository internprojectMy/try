<?php

require_once ('../../config.php');

$cusid = $_REQUEST['name_full'];
$loanid = $_REQUEST['loanno'];

 $sql = "SELECT
		loan_customer.name_full,
		loan_customer.member_number,
		loan_customer.nic,
		loan_lending.loan_date,
		loan_lending.loanid,
		loan_lending.loan_amount,
		loan_lending.interest_amount,
		loan_lending.loan_type,
		loan_lending.loantypes,
		loan_lending.duration,
		loan_lending.net_payment,
		loan_lending.due_amount,
		loan_lending.collector_day,
		loan_lending.collector_name,
		loan_lending.enddate,
		loan_lending.startdate,
		loan_lending.status
		FROM
		loan_lending
		INNER JOIN loan_customer ON loan_customer.nic = loan_lending.nic
		WHERE
		loan_lending.loanid = '$loanid'";
				
				// WHERE
				// loan_lending.customer_id = '$cusid'
				
$cus_details_sql = mysqli_query($con_main,$sql);
$cus_details_res = mysqli_fetch_assoc($cus_details_sql);

$cus_name = $cus_details_res['name_full'];
$cus_nic = $cus_details_res['nic'];
$start = $cus_details_res['startdate'];
$end = $cus_details_res['startdate'];
$type = $cus_details_res['loantypes'];
$amount = $cus_details_res['loan_amount'];
$interest = $cus_details_res['interest_amount'];
$date = $cus_details_res['loan_date'];
$due = $cus_details_res['due_amount'];
$duea = $cus_details_res['duration'];


		$query1 = "SELECT
					loan_lending.loanid,
					loan_lending.net_payment,
					cash_collecting.paid,
					cash_collecting.today,
					cash_collecting.status
					FROM
					cash_collecting
					INNER JOIN loan_lending ON loan_lending.loanid = cash_collecting.loanid
					WHERE
					loan_lending.id = 'loanid'";
				
$query1_exec = mysqli_query($con_main,$query1);

$total = 0;
while($query1_res = mysqli_fetch_assoc($query1_exec)){
    
    $total = $total + $query1_res['paid'];


}

 $balance_amount = $cus_details_res['net_payment'] - $tot_bill_amt;



 $sql2 = "SELECT
								Sum(cash_collecting.paid) AS COUNT
							FROM
								`cash_collecting`
							WHERE
								cash_collecting.loanid = '$loanid'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

							$due_payment = (double)$row['net_payment'];
							$loan_amt = $row['net_payment'];

                            $total_paid_amount = (double)$sql2_res['COUNT'];
							$today_payment = ($due_payment * $paid) - $total_paid_amount; 
							$loan_balance = $loan_amt  - $total_paid_amount;

							$loan_balance1 =  $balance_amount - $total_paid_amount ;

		


require_once ('../../reporting_part/report_header_oa3.php');
 
	$query = "SELECT
					cash_collecting.paid,
					cash_collecting.today
						FROM
						   `cash_collecting`
									  WHERE
								cash_collecting.loanid = '$loanid'";



?>

<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
						<thead>
						<tr>
							<th>Collect Date</th>							
							<th>Payment</th>												
						</tr>
						</thead>

						<tbody>
		<?php

		    $tot_bill_amt = 0;

			$sql = mysqli_query ($con_main, $query);
		
			while ($row = mysqli_fetch_array ($sql)){

				$tot_bill_amt = $tot_bill_amt + $row['paid'];
		?>
							<tr>
								<td><center><?php echo ($row['today']); ?></center></td>
								<td><center><?php echo ($row['paid']); ?></center></td>
							</tr>
	<?php
							}
	?>
	<tr>
		<td colspan="1"><strong><center>TOTAL</center></strong></td>			
			<td><strong><center><?php echo (number_format($tot_bill_amt,2)); ?></center></strong></td>			
		</td>
	</tr>
	</tbody>	
</table> 


                       
