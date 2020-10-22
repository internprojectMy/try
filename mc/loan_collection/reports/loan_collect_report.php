<?php
require_once ('../../config.php');
require_once ('../../reporting_part/report_header_oa4.php');

$cash_tobe_collect1 = 0;
$cash_tobe_collect2 = 0;
$cash_tobe_collect3 = 0;
$cash_tobe_collect4 = 0;

$cash_collected1 = 0;
$cash_collected2 = 0;
$cash_collected3 = 0;
$cash_collected4 = 0;
 
	$query = "SELECT
				cash_collector.id,
				cash_collector.cash_name,
				cash_collector.status,
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
				loan_lending.status,
				loan_customer.name_full,
				cash_collecting.paid
FROM
					cash_collector
					INNER JOIN loan_lending ON cash_collector.cash_name = loan_lending.collector_name
					INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
					INNER JOIN cash_collecting ON loan_lending.loanid = cash_collecting.loanid
WHERE
loan_lending.collector_day = 'Tuesday'
";

?>

<table style="border-collapse:collapse; margin: 0 auto;" border="1" id="report" width="98%">
						<thead>
						<tr>
							<th>Customer Name</th>							
							<th>Customer NIC</th>
							<th>Loan ID</th>
							<th>Net Amount</th>
							<th>Loan Balance</th>
							<th>Payment Received</th>
							<th>Loan Type</th>	
							<th>Today Payment</th>	
							<th>Today Received Amount</th>	
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

				$due_payment = (double)$row['due_amount'];
				$startdate = $row['startdate'];
				$enddate = $row['enddate'];
				$loantype = $row['loantype'];
				$net_payment = $row['net_payment'];
				$name_full = $row['name_full'];
				$nic  = $row['nic'];
				$loanid  = $row['loanid'];
				$duration =$row['duration'];
				$loantypes = $row['loantypes'];

				if($loantypes == 1){
				    
					$today_obj = time();
					$start_date_obj = strtotime($start_date);
					$day_count_obj = $today_obj - $start_date_obj;
					$day_count = round($day_count_obj / (60 * 60 * 24));
					$day_count = $day_count+1;
          
					if($day_count>0){
						
					   if($day_count<=$duration){
					       
					   	     $sql2 = "SELECT
											Sum(loan_collecting.bill_amount) AS COUNT
									  FROM
											`loan_collecting`
									  WHERE
											loan_collecting.loanid = '$loan_id'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

                            $total_paid_amount = (double)$sql2_res['COUNT'];

							$today_payment = ($due_payment * $day_count) - $total_paid_amount;
							$loan_balance = $loan_amt - $total_paid_amount;
							
							$sql3 = "SELECT
                                        	loan_collecting.bill_amount
                                        FROM
                                        	`loan_collecting`
                                        WHERE
                                        	loan_collecting.loan_id = '$lend_id'
                                        AND loan_collecting.collect_date = CURDATE()";
                                        
                            $sql3_exec = mysqli_query($con_main,$sql3);
							$sql3_res = mysqli_fetch_assoc($sql3_exec);
							$today_received = (double)$sql3_res['bill_amount']; 
		?>
							<tr>
								<td><?php echo ($row['name_full']); ?></td>
								<td><?php echo ($row['nic']); ?></td>
								<td><?php echo ($row['loanid']); ?></td>
								<td><?php echo (number_format($row['net_payment'],2)); ?></td>
								<td><?php echo (number_format($loan_amount,2)); ?></td>
								<td><?php echo (number_format($sql2_res['loan_amount'],2)); ?></td>
								<td><?php echo ($loan_tp); ?></td>	
								<td><?php echo (number_format($today_payment,2)); ?></td>
								<td><?php echo (number_format($today_received,2)); ?></td>
								<td><?php echo ($startdate); ?></td>
								<td><?php echo ($enddate); ?></td>														
							</tr>
	<?php
	         $cash_tobe_collect1 = $cash_tobe_collect1 + $today_payment;
	         $cash_collected1 = $cash_collected1 + $today_received;
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
								Sum(loan_collecting.bill_amount) AS COUNT
							FROM
								`loan_collecting`
							WHERE
								loan_collecting.loan_id = '$lend_id'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

                            $total_paid_amount = (double)$sql2_res['COUNT'];
							$today_payment = ($due_payment * $day_count) - $total_paid_amount; 
							$loan_balance = $loan_amt - $total_paid_amount;

                           if($today_payment != 0){
                               
                               	$sql3 = "SELECT
                                        	loan_collecting.bill_amount
                                        FROM
                                        	`loan_collecting`
                                        WHERE
                                        	loan_collecting.loan_id = '$lend_id'
                                        AND loan_collecting.collect_date = CURDATE()";
                                        
                            $sql3_exec = mysqli_query($con_main,$sql3);
							$sql3_res = mysqli_fetch_assoc($sql3_exec);
							$today_received = (double)$sql3_res['bill_amount']; 
				  ?>
				            <tr>
								<td><?php echo ($row['CAL_NAME']); ?></td>
								<td><?php echo ($row['CUS_NIC']); ?></td>
								<td><?php echo ($row['LOAN_ID']); ?></td>
								<td><?php echo (number_format($row['NET_AMOUNT'],2)); ?></td>
								<td><?php echo (number_format($loan_balance,2)); ?></td>
								<td><?php echo (number_format($sql2_res['COUNT'],2)); ?></td>
								<td><?php echo ($loan_tp); ?></td>	
								<td><?php echo (number_format($today_payment,2)); ?></td>
								<td><?php echo (number_format($today_received,2)); ?></td>
								<td><?php echo ($start_date); ?></td>
								<td><?php echo ($end_date); ?></td>														
							</tr>
				<?php
				$cash_tobe_collect2 = $cash_tobe_collect2 + $today_payment;
				$cash_collected2 = $cash_collected2 + $today_received;
			}
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
								Sum(loan_collecting.bill_amount) AS COUNT
							FROM
								`loan_collecting`
							WHERE
								loan_collecting.loan_id = '$lend_id'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

                            $total_paid_amount = (double)$sql2_res['COUNT'];
							$today_payment = ($due_payment * $day_count) - $total_paid_amount; 
							$loan_balance = $loan_amt - $total_paid_amount;

                       if($today_payment!=0){
                           
                           $sql3 = "SELECT
                                        	loan_collecting.bill_amount
                                        FROM
                                        	`loan_collecting`
                                        WHERE
                                        	loan_collecting.loan_id = '$lend_id'
                                        AND loan_collecting.collect_date = CURDATE()";
                                        
                            $sql3_exec = mysqli_query($con_main,$sql3);
							$sql3_res = mysqli_fetch_assoc($sql3_exec);
							$today_received = (double)$sql3_res['bill_amount']; 
					?>

					 <tr>
						<td><?php echo ($row['CAL_NAME']); ?></td>
						<td><?php echo ($row['CUS_NIC']); ?></td>
						<td><?php echo ($row['LOAN_ID']); ?></td>
						<td><?php echo (number_format($row['NET_AMOUNT'],2)); ?></td>
						<td><?php echo (number_format($loan_balance,2)); ?></td>
						<td><?php echo (number_format($sql2_res['COUNT'],2)); ?></td>
						<td><?php echo ($loan_tp); ?></td>	
						<td><?php echo (number_format($today_payment,2)); ?></td>
						<td><?php echo (number_format($today_received,2)); ?></td>
						<td><?php echo ($start_date); ?></td>
						<td><?php echo ($end_date); ?></td>															
					</tr>
				<?php
				$cash_tobe_collect3 = $cash_tobe_collect3 + $today_payment; 
				$cash_collected3 = $cash_collected3 + $today_received; 
         }
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
								Sum(loan_collecting.bill_amount) AS COUNT
							FROM
								`loan_collecting`
							WHERE
								loan_collecting.loan_id = '$lend_id'";

							$sql2_exec = mysqli_query($con_main,$sql2);
							$sql2_res = mysqli_fetch_assoc($sql2_exec);

                            $total_paid_amount = (double)$sql2_res['COUNT'];
							$today_payment = ($due_payment * $day_count) - $total_paid_amount; 
							$loan_balance = $loan_amt - $total_paid_amount;

                        if($today_payment!=0){
                            
                            $sql3 = "SELECT
                                        	loan_collecting.bill_amount
                                        FROM
                                        	`loan_collecting`
                                        WHERE
                                        	loan_collecting.loan_id = '$lend_id'
                                        AND loan_collecting.collect_date = CURDATE()";
                                        
                            $sql3_exec = mysqli_query($con_main,$sql3);
							$sql3_res = mysqli_fetch_assoc($sql3_exec);
							$today_received = (double)$sql3_res['bill_amount']; 
					?>

					 <tr>
						<td><?php echo ($row['CAL_NAME']); ?></td>
						<td><?php echo ($row['CUS_NIC']); ?></td>
						<td><?php echo ($row['LOAN_ID']); ?></td>
						<td><?php echo (number_format($row['NET_AMOUNT'],2)); ?></td>
						<td><?php echo (number_format($loan_balance,2)); ?></td>
						<td><?php echo (number_format($sql2_res['COUNT'],2)); ?></td>
						<td><?php echo ($loan_tp); ?></td>	
						<td><?php echo (number_format($today_payment,2)); ?></td>
						<td><?php echo (number_format($today_received,2)); ?></td>
						<td><?php echo ($start_date); ?></td>
						<td><?php echo ($end_date); ?></td>															
					</tr>
				<?php
				$cash_tobe_collect4 = $cash_tobe_collect4 + $today_payment;
				$cash_collected4 = $cash_collected4 + $today_received;  
               }
		   	 }  
		}   

	}
}
}
$total_tobe_received = $cash_tobe_collect1 + $cash_tobe_collect2 + $cash_tobe_collect3 + $cash_tobe_collect4;
$total_collected = $cash_collected1 + $cash_collected2 + $cash_collected3 + $cash_collected4;
?>
    <tr>
		<td colspan="7"><strong><center>TOTAL</center></strong></td>			
			<td><strong><?php echo (number_format($total_tobe_received,2)); ?></strong></td>
			<td><strong><?php echo (number_format($total_collected,2)); ?></strong></td>			
		</td>
	</tr>
  </tbody>	
</table>                               
