
<div align="center" style="width:100%; padding: 2px auto 2px auto;">
  <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border-top: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>
      <td align="center" colspan="4" style="border-bottom: 1px solid #000;">
        <font style="font-size:21px; font-weight: bold;"><strong>NIRUGAMA ADVERTISING</strong></font>
      </td>
    </tr>
    <tr>
      <td align="center" rowspan="2" style="border-right: 1px solid #000;">
        <font style="font-size:18px; font-weight: bold;">COMMISSION SYSTEM</strong></font>
      </td>
      <td style="padding-left: 4px;">Date</td>
      <td>:</td>
      <td><?php echo (" ".date('d/m/Y')); ?></td>
    </tr>
    <tr>
      <td style="padding-left: 4px;">Time</td>
      <td>:</td>
      <td><?php echo (" ".date('h:i:s A')); ?></td>
    </tr>
    <tr>
      <td align="center" colspan="4" style="border-top: 1px solid #000; padding: 5px 0px 5px 0px;">
        <font style="font-size:18px; font-weight: bold;"><strong><?php echo ($report_type."Report"); ?></strong></font>
      </td>
    </tr>
  </table>
  <table width="98%" border="0" cellspacing="2" cellpadding="3" style="border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000;">
    <tr>
<td><?php if(!empty($department_str)){ ?><strong>Department:</strong><?php } ?></td>
      <td><?php echo (" ".$department_str); ?></td>
      <td><?php echo (" ".$job_level_str); ?></td>
      <td><strong>From :</strong><?php echo (" ".date('d/m/Y', strtotime($from))); ?></td>
      <td><strong>To :</strong><?php echo (" ".date('d/m/Y', strtotime($to))); ?></td>
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