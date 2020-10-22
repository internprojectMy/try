
<div align="center" style="width:100%; padding: 2px auto 2px auto;">
  <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border-top: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr style="height: 50px">
      <td align="center" colspan="4" style="border-bottom: 1px solid #000;">
        <font style="font-size:21px; font-weight: bold;"><strong>B & A MICRO CREDIT</strong></font>
      </td>
    </tr>

    <tr style="height: 50px">
      <td align="center" colspan="4" style="border-top: 1px solid #000; padding: 5px 0px 5px 0px;">
      <font style="font-size:18px; font-weight: bold;"><strong><?php echo ($report_type."LOAN PAYMENT DETAILS REPORT"); ?></strong></font>
      </td>
    </tr>

  </table>
  <table width="98%" border="0" cellspacing="2" cellpadding="1" style="border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>
      <td><strong>Customer Name : </strong><?php echo ($cus_name); ?></td>
      <td><strong>Customer NIC : </strong><?php echo ($cus_nic); ?></td>
       <td><strong>Loan Type : </strong><?php echo ($type); ?></td>
       <td><strong>Loan Start Date : </strong><?php echo ($start); ?></td>
    </tr>
    <tr  style="height: 50px">
       <td><strong>Loan Start Date : </strong><?php echo ($end); ?></td>
        <td><strong>Investment Amount : </strong><?php echo (number_format($amount,2)); ?></td>  
        <td><strong>Net Amount : </strong><?php echo (number_format($balance_amount,2)); ?></td> 
        <td><strong>Due Amount : </strong><?php echo (number_format($due,2)); ?></td>
    </tr>
    
    <tr style="height: 50px">
        <td><strong>Duration : </strong><?php echo ($duea); ?></td>
        <td><strong>Remaining Balance : </strong><?php echo (number_format($loan_balance1,2)); ?></td>
    </tr>
  </table>
</div>