<?php


require_once ('../../config.php');
require_once ('../../reporting_part/report_header_oa7.php');
 
	$query = "SELECT
				loan_lending.id AS LEND_ID,
				loan_lending.loanid AS LOAN_ID,
				loan_lending.start_date AS START_DATE,
				loan_lending.end_date AS END_DATE,
				loan_lending.total_due AS DURATION,
				loan_lending.loan_type AS LOAN_TYPE,
				loan_lending.due_amount AS DUE_PAYMENT,
				loan_lending.net_payment AS NET_AMOUNT,
				loan_customer.calling_name AS CAL_NAME,
				loan_customer.nic AS CUS_NIC,
				loan_type.type
			FROM
				loan_lending
			INNER JOIN loan_customer ON loan_lending.customer_id = loan_customer.id
			INNER JOIN loan_type ON loan_lending.loan_type = loan_type.id
			ORDER BY
				loan_lending.loan_type ASC";
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

				$due_payment = (double)$row['DUE_PAYMENT'];
				$start_date = $row['START_DATE'];
				$end_date = $row['END_DATE'];
				$loan_type = $row['LOAN_TYPE'];
				$loan_amt = $row['NET_AMOUNT'];
				$cus_name = $row['CAL_NAME'];
				$cus_nic  = $row['CUS_NIC'];
				$loan_id  = $row['LOAN_ID'];
				$lend_id = $row['LEND_ID'];
				$duration =$row['DURATION'];
				$loan_tp = $row['type'];

				if($loan_type == 1){

                   
					$today_obj = time();
					$start_date_obj = strtotime($start_date);
					$day_count_obj = $today_obj - $start_date_obj;
					$day_count = floor($day_count_obj / (60 * 60 * 24));
					$day_count = $day_count+1;
          
					if($day_count!=0){
						
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
							//echo($today_payment); 
							$loan_balance = $loan_amt - $total_paid_amount;
							

					  
					
				
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
            $day_count = ($day_count/7)+1;
            $day_count = floor($day_count);

                       if($day_count!=0){
            	 	
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

                          // if($today_payment != 0){

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
								<td><?php echo ($start_date); ?></td>
								<td><?php echo ($end_date); ?></td>														
							</tr>
				<?php
			//}
			 }
            }	 
            

            
	}else if($loan_type == 3){

		 $today_obj = time();
		 $start_date_obj = strtotime($start_date);
		 $day_count_obj = $today_obj - $start_date_obj;
		 $day_count = floor($day_count_obj / (60 * 60 * 24));
		 $day_count = ($day_count/14)+1;
		 $day_count = floor($day_count);

		    if($day_count!=0){

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

                     //  if($today_payment!=0){
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
						<td><?php echo ($start_date); ?></td>
						<td><?php echo ($end_date); ?></td>															
					</tr>
				<?php
        // }
       }		   	   
	}	   

	} else if($loan_type ==4){

		 $today_obj = time();
		 $start_date_obj = strtotime($start_date);
		 $day_count_obj = $today_obj - $start_date_obj;
		 $day_count = floor($day_count_obj / (60 * 60 * 24));
		 $day_count = ($day_count/30)+1;
		 $day_count = floor($day_count);

		 if($day_count!=0){

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

                      //  if($today_payment!=0){
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
						<td><?php echo ($start_date); ?></td>
						<td><?php echo ($end_date); ?></td>															
					</tr>
				<?php
              // }
		   	 }  
		}   

	}
}
?>
	</tbody>	
</table>                               
