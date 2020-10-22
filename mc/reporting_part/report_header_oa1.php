<!--  -->
<div align="center" style="width:100%; padding: 2px auto 2px auto;">
  <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border-top: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>
      <td align="center" colspan="4" style="border-bottom: 1px solid #000;">
        <font style="font-size:21px; font-weight: bold;"><strong>B & A MICRO CREDIT</strong></font>
      </td>
    </tr>
    <!-- <tr>
      <td align="center" rowspan="2" style="border-right: 1px solid #000;">
        <font style="font-size:18px; font-weight: bold;">CUSTOMERS LOAN DETAILS</strong></font>
      </td>
      <td style="padding-left: 4px;">Date</td>
      <td>:</td>
      <td><?php echo (" ".date('d/m/Y')); ?></td>
    </tr>
    <tr>
      <td style="padding-left: 4px;">Time</td>
      <td>:</td>
      <td><?php echo (" ".date('h:i:s A')); ?></td>
    </tr> -->

    <tr style="height: 50px">
      <td align="center" colspan="4" style="border-top: 1px solid #000; padding: 5px 0px 5px 0px;">
        <font style="font-size:18px; font-weight: bold;"><strong><?php echo ($report_type."CUSTOMERS LOAN DETAILS"); ?></strong></font>
      </td>
    </tr>
  </table>
  <table width="98%" border="0" cellspacing="2" cellpadding="3" style="border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>       
         <td><strong>Customer Name :</strong><?php echo ($cus_name); ?></td>
         <td><strong>Customer Contact :</strong><?php echo ($customer_mobile1); ?></td>
        <td><strong>Customer Spouse :</strong><?php echo ($spouse_name); ?></td>
        <td><strong>Customer Spouse Contact:</strong><?php echo ($spouse_contact); ?></td> 
 
  </tr>
    <tr>
      <td><?php if(!empty($epf_no)){ ?><strong>Employee:</strong><?php } ?></td>
      <td><?php if(!empty($epf_no)){ echo ($epf_no." - ".$emp_str); } ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>