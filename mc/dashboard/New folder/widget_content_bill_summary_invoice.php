<?php 
  
 ?>

<table class="table table-striped table-vcenter table-condensed">
<thead>
    <tr>
        <th class="text-center">Customer Name</th>
        <th class="text-center">NIC</th>
        <th class="text-center">Loan ID</th>
        <th class="text-center">Net Payment</th>
        <th class="text-center">Total Due</th>
        <th class="text-center">Start Date</th>
        <th class="text-center">End Date</th>
        
    </tr>
</thead>

<tbody>
<?php
  $add_count = "SELECT
                    loan_lending.loanid,
                    loan_customer.calling_name,
                    loan_customer.nic,
                    loan_lending.start_date,
                    loan_lending.net_payment,
                    loan_lending.total_due,
                    loan_lending.end_date,
                    Sum(
                      loan_collecting.bill_amount
                    ) AS SUM
                  FROM
                    loan_lending
                  INNER JOIN loan_customer ON loan_lending.customer_id = loan_customer.id
                  INNER JOIN loan_collecting ON loan_lending.id = loan_collecting.loan_id
                  GROUP BY
                    loan_lending.loanid,
                    loan_customer.calling_name,
                    loan_customer.nic,
                    loan_lending.start_date,
                    loan_lending.net_payment,
                    loan_lending.total_due,
                    loan_lending.end_date";

 $add_count_result = mysqli_query($con_main,$add_count);

 while($row = mysqli_fetch_assoc($add_count_result)){

       $end = $row['end_date'];
       $today = date("Y-m-d");

       $diff = abs(strtotime($end)-strtotime($today));
       $days = $diff/(60*60*24);
       if($days<=5){
   ?>
   <tr>
       <td class="text-center"><?php echo ($row['calling_name']);?></td>
       <td class="text-center"><?php echo ($row['nic']);?></td>
       <td class="text-center"><?php echo ($row['loanid']); ?></td>
       <td class="text-center"><?php echo ($row['net_payment']); ?></td>
       <td class="text-center"><?php echo ($row['total_due']); ?></td>
       <td class="text-center"><?php echo ($row['start_date']); ?></td>
       <td class="text-center"><?php echo ($row['end_date']); ?></td>
   </tr>
<?php
}
}
?>
</tbody>
</table>



