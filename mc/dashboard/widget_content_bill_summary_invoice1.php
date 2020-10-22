<?php 
  
 ?>

<table class="table table-striped table-vcenter table-condensed">
<thead>
  <tr class="row100 head">
    <th class="column100 column1" data-column="column1"></th>
    <th class="column100 column2" data-column="column2">Customer Name</th>
    <th class="column100 column3" data-column="column3">NIC</th>
    <th class="column100 column4" data-column="column4">Loan ID</th>
    <th class="column100 column5" data-column="column5">Net Payment</th>
    <th class="column100 column6" data-column="column6">Payment Received</th>
    <th class="column100 column7" data-column="column7">Start Date</th>
    <th class="column100 column8" data-column="column8">End Date</th>
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
   <tr class="row100">
       <td class="column100 column1" data-column="column1"><?php echo ($row['calling_name']);?></td>
       <td class="column100 column1" data-column="column2"><?php echo ($row['nic']);?></td>
       <td class="column100 column1" data-column="column3"><?php echo ($row['loanid']); ?></td>
       <td class="column100 column1" data-column="column4"><?php echo ($row['net_payment']); ?></td>
       <td class="column100 column1" data-column="column5"><?php echo ($row['total_due']); ?></td>
       <td class="column100 column1" data-column="column6"><?php echo ($row['start_date']); ?></td>
       <td class="column100 column1" data-column="column7"><?php echo ($row['end_date']); ?></td>
   </tr>
<?php
}
}
?>
</tbody>
</table>



