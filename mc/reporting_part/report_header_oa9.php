
<div align="center" style="width:100%; padding: 2px auto 2px auto;">
  <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border-top: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>
      <td align="center" colspan="4" style="border-bottom: 1px solid #000;">
        <font style="font-size:21px; font-weight: bold;"><strong>B & A MICRO CREDIT</strong></font>
      </td>
    </tr>

    <tr style="height: 50px">
      <td align="center" colspan="4" style="border-top: 1px solid #000; padding: 5px 0px 5px 0px;">
      <font style="font-size:18px; font-weight: bold;"><strong><?php echo ($report_type."PROFIT & LOSS STATEMENT"); ?></strong></font>
      </td>
    </tr>

  </table>
  <table width="98%" border="0" cellspacing="2" cellpadding="1" style="border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>
      <td><strong>From :</strong><?php echo (" ".date('d/m/Y', strtotime($from))); ?></td>
    </tr>
    <tr>
      <td><strong>To :</strong><?php echo (" ".date('d/m/Y', strtotime($to))); ?></td>
    </tr>

    <tr>
      <td><?php if(!empty($epf_no)){ ?><strong>Employee:</strong><?php } ?></td>
      <td><?php if(!empty($epf_no)){ echo ($epf_no." - ".$emp_str); } ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

     <tr>
      <!-- <td><strong><?php echo (number_format($balance,2)); ?></strong></td> -->
    </tr>
  </table>
</div>