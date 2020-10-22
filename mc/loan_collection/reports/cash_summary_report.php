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

// CAPITAL ACCOUNT
            
$query8 = "SELECT
                capital.id,
                capital.category,
                capital.amount,
                capital.`comment`,
                capital.date,
                capital.expenses_type,
                capital.`status`
            FROM
            capital
            WHERE
            capital.date BETWEEN '$from' AND '$to' AND
            capital.expenses_type = '$expenses_type'";

// LOAN LENDING

$query4 = "SELECT
                loan_lending.loantypes,
                loan_lending.net_payment,
                loan_lending.loan_amount,
                loan_lending.`status`,
                loan_lending.loan_date,
                loan_customer.member_number,
                loan_customer.name_full,
                loan_lending.expenses_type
            FROM
                loan_lending
            INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
            INNER JOIN expenses_type ON loan_lending.expenses_type = expenses_type.expenses_type
            WHERE
                loan_lending.startdate BETWEEN '$from'
            AND '$to'
            AND loan_lending.expenses_type = '$expenses_type'";

// CASH COLLECTING
 
    $query = "SELECT
            	cash_collecting.id,
            	cash_collecting.branch_name,
            	cash_collecting.center_name,
            	cash_collecting.loanid,
            	cash_collecting.name_full,
            	cash_collecting.nic,
            	cash_collecting.net_payment,
            	cash_collecting.paid,
            	cash_collecting.total,
            	cash_collecting.today,
            	cash_collecting.type,
            	cash_collecting.types,
            	cash_collecting.`status`,
            	cash_collecting.expenses_type
            FROM
            	cash_collecting
            INNER JOIN branch ON branch.branch_id = cash_collecting.branch_name
            INNER JOIN expenses_type ON cash_collecting.expenses_type = expenses_type.expenses_type
            WHERE
            	cash_collecting.branch_name = '$branch_id'
            AND cash_collecting.today BETWEEN '$from'
            AND '$to'
            AND cash_collecting.expenses_type = '$expenses_type'";

// DOCUMENT CHARGES

$query2 = "SELECT
            	document_charges.id,
            	document_charges.loanno,
            	document_charges.loan_amount,
            	document_charges.document_rate,
            	document_charges.document_amount,
            	document_charges.`status`,
            	document_charges.doc_date,
            	document_charges.type,
            	loan_customer.name_full,
            	branch.branch_id,
            	document_charges.expenses_type
            FROM
            	document_charges
            INNER JOIN loan_lending ON loan_lending.loanid = document_charges.loanno
            INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
            INNER JOIN branch ON branch.branch_id = loan_customer.branch_name
            INNER JOIN expenses_type ON document_charges.expenses_type = expenses_type.expenses_type
            WHERE
            	loan_customer.branch_name = '$branch_id'
            AND document_charges.doc_date BETWEEN '$from'
            AND '$to'
            AND expenses_type.expenses_type = '$expenses_type'";


//      $sql_2 = mysqli_query($con_main, $query2);
//     $query_rows = mysqli_num_rows($sql_2);
//     while ($row = mysqli_fetch_array ($sql_2)){

//                 $tot_amt9 = $tot_amt9 + $row[''];
//                 $tot_interest9 = $tot_interest9 + $row['document_amount'];

// }

 $query3 = "SELECT
                loan_transactionexp.id,
                loan_transactionexp.category,
                loan_transactionexp.amount,
                loan_transactionexp.expencestype,
                loan_transactionexp.comment,
                loan_transactionexp.other,
                loan_transactionexp.entered_date,
                loan_transactionexp.entered_by,
                loan_transactionexp.type,
                loan_transactionexp.expcat,
                loan_expenses.category AS cat1,
                loan_transactionexp.branch_name
                FROM
                loan_transactionexp
                INNER JOIN loan_expenses ON loan_transactionexp.category = loan_expenses.id
                LEFT JOIN branch ON branch.branch_name = loan_transactionexp.branch_name
                WHERE
                loan_transactionexp.entered_date BETWEEN '$from' AND '$to' AND
                loan_transactionexp.expencestype = '$expenses_type' AND
                loan_transactionexp.branch_name = '$branch_id'";



// $sql_3 = mysqli_query($con_main, $query3);
//     $query_rows = mysqli_num_rows($sql_3);

//      while ($row = mysqli_fetch_array ($sql_3)){

//                 $tot_amt1 = $tot_amt1 + $row[''];
//                 $tot_interest1 = $tot_interest1 + $row['amount'];

//    }




// $sql_4 = mysqli_query($con_main, $query4);
// $query4_rows = mysqli_num_rows($sql_4); 

// while ($row = mysqli_fetch_array($sql_4)) {

//     $tot_amt6 = $tot_amt6 + $row[''];
//     $tot_interest6 = $tot_interest6 + $row['net_payment']; 
// }

$query5 = "SELECT
            	excess_entry.category,
            	excess_entry.text,
            	excess_entry.date,
            	excess_entry.`status`,
            	excess_entry.expenses_type
            FROM
            	excess_entry
            INNER JOIN expenses_type ON excess_entry.expenses_type = expenses_type.expenses_type
            WHERE
            	excess_entry.`status` = '1'
            AND excess_entry.date BETWEEN '$from'
            AND '$to'
            AND expenses_type.expenses_type = '$expenses_type'";


// $sql_5 = mysqli_query($con_main, $query5);
// $query5_rows = mysqli_num_rows($sql_5);

// while ($row = mysqli_fetch_array ($sql_5)){

//                 $tot_amt5 = $tot_amt5 + $row[''];
//                 $tot_interest5 = $tot_interest5 + $row['category'];

// }


$query6 = "SELECT
            	loan_lending.loantypes,
            	loan_lending.net_payment,
            	loan_lending.loan_amount,
            	loan_lending.`status`,
            	loan_lending.loan_date,
            	loan_customer.member_number,
            	loan_customer.name_full,
            	loan_lending.expenses_type
            FROM
            	loan_lending
            INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
            INNER JOIN expenses_type ON loan_lending.expenses_type = expenses_type.expenses_type
            WHERE
            	loan_lending.startdate BETWEEN '$from'
            AND '$to'
            AND loan_customer.branch_name = '1'
            AND loan_lending.expenses_type = '$expenses_type'";


// $sql_6 = mysqli_query($con_main, $query6);
// $query6_rows = mysqli_num_rows($sql_6); 

//  while ($row = mysqli_fetch_array ($sql_6)){

//                 $tot_amt6 = $tot_amt6 + $row[''];
//                 $tot_interest6 = $tot_interest6 + $row['amount'];


// }


$query7 = "SELECT
            other_income.id,
            other_income.category,
            other_income.amount,
            other_income.`comment`,
            other_income.date,
            other_income.expenses_type,
            other_income.`status`
            FROM
            other_income
            INNER JOIN expenses_type ON other_income.expenses_type = expenses_type.expenses_type
            WHERE
            other_income.date BETWEEN '$from' AND '$to' AND
            expenses_type.expenses_type = '$expenses_type'";





?>      







<div class="col-md-6" style="width: 50%; float: left;">


<table style="border-collapse:collapse;" border="1" id="report" width="99%">
    <thead>
        <tr>
            <th colspan="5">CASH IN</th>
        </tr>

        <tr>
        <th colspan="">Date</th>
        <th colspan="">Description</th>
        <th colspan="">Type</th>
        <th colspan="">Amount</th>
        </tr>
    </thead>

        <!-- CAPITAL ACCOUNT -->

    <?php
            $total_cash_in = 0;
            $tot_interest8 = 0;
            $sql_8 = mysqli_query ($con_main, $query8);
            
        
            while ($row8 = mysqli_fetch_array ($sql_8)){

                $tot_interest8 = $tot_interest8 + $row8['amount'];
                $total_cash_in =  $tot_interest8;
    ?>
            <tr>
                    <td><?php echo ($row8['date']); ?></td>
                    <td><?php echo ($row8['comment']); ?></td>
                    <td><?php echo ($row8['category']); ?></td>
                    <td style="text-align: right;"><?php echo (number_format($row8['amount'],2)); ?></td>           
            </tr>
    <?php
        }
    ?>

    <!-- CASH COLLECTING -->

    <?php
            
            $tot_interest = 0;
            $sql = mysqli_query ($con_main, $query);
            
        
            while ($row = mysqli_fetch_array ($sql)){

                
                $tot_interest = $tot_interest + $row['paid'];
                $total_cash_in =  $tot_interest + $tot_interest8;
    ?>
            <tr>
                <td><?php echo ($row['today']); ?></td>
                <td><?php echo ($row['name_full']); ?></td>
                <td><?php echo ($row['type']); ?></td>
                <td style="text-align: right;"><?php echo (number_format($row['paid'],2)); ?></td>                 
            </tr>
    <?php
        }
    ?>




<!-- DOCUMENT CHARGES -->

    <?php

            
            $tot_interest2 = 0;

            $sql2 = mysqli_query ($con_main, $query2);
        
            while ($row2 = mysqli_fetch_array ($sql2)){

                $tot_interest2 = $tot_interest2 + $row['document_amount'];
                $total_cash_in = $tot_interest + $tot_interest8 + $tot_interest2;

    ?>
                <tr>
                    <td><?php echo ($row2['doc_date']); ?></td>
                    <td><?php echo ($row2['name_full']); ?></td>
                    <td><?php echo ($row2['type']); ?></td>
                    <td style="text-align: right;"><?php echo (number_format($row2['document_amount'],2)); ?></td>                  
                </tr>
    <?php
            }
    ?>

       <!--  <?php

       
            $tot_interest56 = 0;
            $sql = mysqli_query ($con_main, $query);
            $sql_5 = mysqli_query ($con_main, $query5);
        
            while ($row = mysqli_fetch_array ($sql_5)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest56 = $tot_interest56 + $row['category'];

    ?>
                <tr>
                    <td><?php echo ($row['date']); ?></td>
                    <td><?php echo ($row['text']); ?></td>
                    <td><?php echo ($row['']); ?></td>
                    <td><?php echo (number_format($row['category'],2)); ?></td>                 
                </tr>
    <?php
            }
    ?>



            <?php

        
            $tot_interest6 = 0;
            $sql = mysqli_query ($con_main, $query);
            $sql_6 = mysqli_query ($con_main, $query6);
        
            while ($row = mysqli_fetch_array ($sql_6)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest6 = $tot_interest6 + $row['amount'];

    ?>
                <tr>
                    <td><?php echo ($row['entered_date']); ?></td>
                    <td><?php echo ($row['comment']); ?></td>
                    <td><?php echo ($row['expcat']); ?></td>
                    <td><?php echo (number_format($row['amount'],2)); ?></td>                   
                </tr>
    <?php
            }
    ?> -->
    
       <!--  <?php

       
            $tot_interest8 = 0;
            $sql_8 = mysqli_query ($con_main, $query7);
            
        
            while ($row = mysqli_fetch_array ($sql_8)){

                $tot_amt = $tot_amt + $row[''];
                $tot_interest8 = $tot_interest8 + $row['amount'];
                
    ?>
            <tr>
                    <td><?php echo ($row['date']); ?></td>
                    <td><?php echo ($row['comment']); ?></td>
                    <td><?php echo ($row['category']); ?></td>
                    <td><?php echo (number_format($row['amount'],2)); ?></td>           
            </tr>
    <?php
        }
    ?> -->
    
    


    <tr>
        <td colspan="3"><strong><center>TOTAL</center></strong></td>            
            
            <!-- <td><strong><?php //echo (number_format($tot_interest,2)); ?></strong></td> -->    
            <td style="text-align: right;"><strong><?php echo (number_format($total_cash_in ,2)); ?></strong></td>           
        </td>


    </tbody>    
</table> 
</div>


<div class="col-md-6" style="width: 50%; float: right;">

<table style="border-collapse:collapse;" border="1" id="report" width="100%">
    <thead>
        <tr>
            <th colspan="5">CASH OUT</th>
<!-- <th colspan="4">CASH OUT</th>
 -->    </tr>

        <tr>
        <th colspan="">Date</th>
        <th colspan="">Description</th>
        <th colspan="">Expense Type</th>
        <th colspan="">Amount</th>
        </tr>
    </thead>



    <?php

    $total_cash_out = 0;
    $tot_interest4 = 0;

    $sql4 = mysqli_query($con_main, $query4);

    while ($row4 = mysqli_fetch_array($sql4)) 
    {
        $tot_interest4 = $tot_interest4 + $row4['loan_amount'];
        $total_cash_out =  $tot_interest4;
    ?>
        <tr>
            <td><?php echo ($row4['loan_date']); ?></td>
            <td><?php echo ($row4['member_number']); ?></td>
            <td><?php echo ($row4['loantypes']); ?></td>
            <td style="text-align: right;"><?php echo (number_format($row4['loan_amount'], 2)); ?></td>                    
        </tr>
    <?php
    }
    ?> 
           
    <?php

            $tot_interest3 = 0;
            $sql3 = mysqli_query ($con_main, $query3);
            
        
            while ($row3 = mysqli_fetch_array ($sql3)){

                $tot_interest3 = $tot_interest3 + $row3['amount'];
                $total_cash_out = $tot_interest4 + $tot_interest3;
                
    ?>
            <tr>
                    <td><?php echo ($row3['entered_date']); ?></td>
                    <td><?php echo ($row3['comment']); ?></td>
                    <td><?php echo ($row3['cat1']); ?></td>
                    <td style="text-align: right;"><?php echo (number_format($row3['amount'],2)); ?></td>           
            </tr>
    <?php
        }
    ?>
    

    <tr>
        <td colspan="3"><strong><center>TOTAL</center></strong></td>            
            
            <!-- <td><strong><?php //echo (number_format($tot_interest,2)); ?></strong></td> -->    
            <td style="text-align: right;"><strong><?php echo (number_format($total_cash_out,2)); ?></strong></td>    
           <!--  <td><strong><?php echo (number_format($cash_in + $cash_out ,2)); ?></strong></td>  -->     
        </td>
    </tr>



    </tbody>    
</table>
</div>









    


