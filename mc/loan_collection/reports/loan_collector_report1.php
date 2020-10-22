<?php
session_start();
$user_code = $_SESSION['USER_CODE'];

require_once ('../../config.php');
$collector = $_REQUEST['collector'];

$collector_select = "SELECT
						cash_collector.cash_name,
						cash_collector.id
						FROM
						cash_collector
						WHERE
						cash_collector.cash_name = '$collector'";
$collector_select_query = mysqli_query($con_main,$collector_select);
$collector_select_res = mysqli_fetch_assoc($collector_select_query);

$collector = $collector_select_res['cash_name'];
require_once ('../../reporting_part/report_header_oa5.php');



	$query = "SELECT
loan_lending.collector_name,
loan_lending.id,
loan_lending.loanid,
loan_lending.loan_date,
loan_lending.nic,
loan_lending.loan_amount,
loan_lending.interest_amount,
loan_lending.loan_type,
loan_lending.loantypes,
loan_lending.duration,
loan_lending.net_payment,
loan_lending.due_amount,
loan_lending.collector_day,
loan_lending.startdate,
loan_lending.enddate,
loan_lending.`status`,
loan_customer.name_full,
center.center_id,
center.center_name
FROM
loan_lending
INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
INNER JOIN center ON center.center_id = loan_customer.center_name
WHERE
			loan_lending.collector_name= '$collector'
";
?>

<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
						<thead>
						<tr>
							<th>Loan ID</th>
							<th>Customer Name</th>							
							<th>Customer NIC</th>
							<th>Center</th>
							<th>Premium</th>
							<th>Loan Balance</th>
							<th>Start Date</th>
							<th>End Date</th>						
						</tr>
						</thead>

						<tbody>
		<?php

		    // $tot_amt = 0;
		    // $tot_interest = 0;
			$sql = mysqli_query ($con_main, $query);
		
			while ($row = mysqli_fetch_assoc($sql)){

				$due_payment = (double)$row['net_payment'];
				$start_date = $row['startdate'];
				$end_date = $row['enddate'];
				$loan_type = $row['loan_type'];
				$loan_amt = $row['net_payment'];
				$loan_amount = $row['loan_amount'];
				$cus_name = $row['name_full'];
				$cus_nic  = $row['nic'];
				$loan_id  = $row['loanid'];
				$lend_id = $row['id'];
				$duration =$row['duration'];
				$loan_tp = $row['type'];
				$due_amount = $row['net_payment'];

				if($loan_type == 1){

					$today_obj = time();
					$start_date_obj = strtotime($start_date);
					$day_count_obj = $today_obj - $start_date_obj;
					$paid = round($day_count_obj / (60 * 60 * 24));
					$paid = $paid+1;

					if($paid>0){
						
					   if($paid<=$duration){
					   	
					   	     $sql2 = "SELECT
											Sum(cash_collecting.paid) AS COUNT
									  FROM
											`cash_collecting`
									  WHERE
											cash_collecting.loanid = '$lend_id'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

                            $total_paid_amount = (double)$sql2_res['COUNT'];
							$today_payment = ($due_payment * $paid) - $total_paid_amount; 
							$loan_balance = $loan_amt - $total_paid_amount;
							

					  
					
				
		?>
							<tr>
								<td><?php echo ($row['loanid']); ?></td>
								<td><?php echo ($row['name_full']); ?></td>
								<td><?php echo ($row['nic']); ?></td>
								<td><?php echo ($row['center_name']); ?></td>
								<td><?php echo ($row['due_amount']); ?></td>
								<td><?php echo (number_format($loan_balance,2)); ?></td>
								<td><?php echo ($start_date); ?></td>
								<td><?php echo ($end_date); ?></td>														
							</tr>
	<?php
            }
        }
	}else if($loan_type == 2){

            
		    $today_obj = time();
			$start_date_obj = strtotime($start_date);
			$day_count_obj = $today_obj - $start_date_obj;
			$day_count = floor($day_count_obj / (60 * 60 * 24)); 
			if($day_count%7==0){
            $day_count = ($day_count/7)+1;
            $day_count = floor($day_count);

                       if($day_count>0){
            	 	
                           if($day_count<=$duration){

            	 	$sql2 = "SELECT
								Sum(cash_collecting.paid) AS COUNT
							FROM
								`cash_collecting`
							WHERE
								cash_collecting.loanid = '$lend_id'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

                            $total_paid_amount = (double)$sql2_res['COUNT'];
							$today_payment = ($due_payment * $paid) - $total_paid_amount; 
							$loan_balance = $loan_amt - $total_paid_amount;

                            // if($today_payment != 0){

				  ?>

				          <tr>
								<td><?php echo ($row['loanid']); ?></td>
								<td><?php echo ($row['name_full']); ?></td>
								<td><?php echo ($row['nic']); ?></td>
								<td><?php echo ($row['center_name']); ?></td>
								<td><?php echo ($row['due_amount']); ?></td>
								<td><?php echo (number_format($loan_balance,2)); ?></td>
								<td><?php echo ($start_date); ?></td>
								<td><?php echo ($end_date); ?></td>														
							</tr>
				<?php
			 }
            }	 
            
	}
            
	}else if($loan_type == 3){

		 $today_obj = time();
		 $start_date_obj = strtotime($start_date);
		 $day_count_obj = $today_obj - $start_date_obj;
		 $day_count = floor($day_count_obj / (60 * 60 * 24));
		 
		 if($day_count%14==0){
		 $day_count = ($day_count/14)+1;
		 $day_count = floor($day_count);

		    if($day_count>0){

		    	  if($day_count<= $duration){

		   	   	   $sql2 = "SELECT
								Sum(cash_collecting.paid) AS COUNT
							FROM
								`cash_collecting`
							WHERE
								cash_collecting.loanid = '$lend_id'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

                            $total_paid_amount = (double)$sql2_res['COUNT'];
							$today_payment = ($due_payment * $paid) - $total_paid_amount; 
							$loan_balance = $loan_amt - $total_paid_amount;

					?>

					<tr>
								<td><?php echo ($row['loanid']); ?></td>
								<td><?php echo ($row['name_full']); ?></td>
								<td><?php echo ($row['nic']); ?></td>
								<td><?php echo ($row['center_name']); ?></td>
								<td><?php echo ($row['due_amount']); ?></td>
								<td><?php echo (number_format($loan_balance,2)); ?></td>
								<td><?php echo ($start_date); ?></td>
								<td><?php echo ($end_date); ?></td>														
							</tr>
				<?php
 
       }		   	   
	}
}

	} else if($loan_type ==4){

		 $today_obj = time();
		 $start_date_obj = strtotime($start_date);
		 $day_count_obj = $today_obj - $start_date_obj;
		 $day_count = floor($day_count_obj / (60 * 60 * 24));
		 
		 if($day_count%30==0){
		 $day_count = ($day_count/30)+1;
		 $day_count = floor($day_count);

		 if($day_count>0){

		 	if($day_count<=$duration){

		   	   	   $sql2 = "SELECT
								Sum(cash_collecting.paid) AS COUNT
							FROM
								`cash_collecting`
							WHERE
								cash_collecting.loanid = '$lend_id'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

                            $total_paid_amount = (double)$sql2_res['COUNT'];
							$today_payment = ($due_payment * $paid) - $total_paid_amount; 
							$loan_balance = $loan_amt - $total_paid_amount;

					?>

					 <tr>
								<td><?php echo ($row['loanid']); ?></td>
								<td><?php echo ($row['name_full']); ?></td>
								<td><?php echo ($row['nic']); ?></td>
								<td><?php echo ($row['center_name']); ?></td>
								<td><?php echo ($row['due_amount']); ?></td>
								<td><?php echo (number_format($loan_balance,2)); ?></td>
								<td><?php echo ($start_date); ?></td>
								<td><?php echo ($end_date); ?></td>														
							</tr>
				<?php

		   	 }  
		}
	}

	}
}
?>
	</tbody>	
</table>                               

<!-- 
SELECT
			loan_lending.collector_name,
			loan_lending.id,
			loan_lending.loanid,
			loan_lending.loan_date,
			loan_lending.nic,
			loan_lending.loan_amount,
			loan_lending.interest_amount,
			loan_lending.loan_type,
			loan_lending.loantypes,
			loan_lending.duration,
			loan_lending.net_payment,
			loan_lending.due_amount,
			loan_lending.collector_day,
			loan_lending.startdate,
			loan_lending.enddate,
			loan_lending.`status`,
			loan_customer.name_full
			FROM
			loan_lending
			INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
			WHERE
			loan_lending.collector_name= '$coll_name -->