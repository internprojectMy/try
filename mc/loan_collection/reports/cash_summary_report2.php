<?php

$from = $_REQUEST['from'];
$expenses_type = $_REQUEST['expenses_type'];
$to = $_REQUEST['to'];
$search = $_REQUEST['search'];
$nic = $_REQUEST['nic'];
$branch_id = $_REQUEST['branch_id'];
// $branch_id = $_REQUEST['branch_name'];
require_once ('../../config.php');

require_once ('../../reporting_part/report_header_oa8.php');
 
    $query = "SELECT
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
    loan_lending.collector_name,
    loan_lending.center_name,
    loan_lending.`status`
FROM
    `loan_lending`";



?>      


<div class="col-md-6" style="width: 50%; float: left;">


<table style="border-collapse:collapse;" border="1" id="report" width="99%">
                        <thead>
                            <tr>
<th colspan="5">CASH IN</th>
<!-- <th colspan="4">CASH OUT</th>
 --></tr>

<tr>
<th colspan="">Loan ID</th>
<th colspan="">Loan amount</th>
<th colspan="">net amount</th>
<th colspan="">Rate</th>
<th colspan="">pre month amount</th>
<th colspan="">interest for month</th>
<th colspan=""></th>

</tr>
                        </thead>
           
    <?php

            $tot_amt = 0;
            $tot_interest2 = 0;
            $sql = mysqli_query ($con_main, $query);
            
        
            while ($row = mysqli_fetch_array ($sql)){
                
                $duration = $row['duration'];
                $loan_amount = $row['loan_amount'];
                $net_payment = $row['net_payment'];
                $interest_amount = $row['interest_amount'];
                $interest_rate = $interest_amount;

                $interest = $net_payment - $loan_amount;
                $dived_amount =  $net_payment / $duration;              
                $amount = $net_payment - $dived_amount;
                $interest_cost = $interest / $duration;
                $new_insterest_month = $dived_amount - $interest_cost;
        
    ?>
            <tr>
                <td><?php echo ($row['loanid']); ?></td>
                <td><?php echo ($loan_amount); ?></td>
                <td><?php echo (number_format($row['net_payment'],2)); ?></td>                  
                <td><?php echo ($interest_rate); ?></td>
                <td><?php echo ($dived_amount); ?></td>
                <td><?php echo ($interest_cost); ?></td>
                <td><?php echo ($new_insterest_month); ?></td>
                                        
            </tr>
    <?php
        }
    ?>



        



    <tr>
        <td colspan="3"><strong><center>TOTAL</center></strong></td>            
            
            <!-- <td><strong><?php //echo (number_format($tot_interest,2)); ?></strong></td> -->    
            <td><strong><?php echo (number_format($tot_interest2 + $tot_interest + $tot_interest5 + $tot_interest6 ,2)); ?></strong></td>           
        </td>


    </tbody>    
</table> 
</div>


<div class="col-md-6" style="width: 50%; float: right;">



</div>









    


