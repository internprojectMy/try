<?php 
  $from = (isset($_REQUEST['from'])) ? $_REQUEST['from'] : "";
  $to = (isset($_REQUEST['to'])) ? $_REQUEST['to'] : "";

  $where = "";

  if (!empty($from) && !empty($to)){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= (!empty($from) && !empty($to)) ? "collection_adds.add_collect_date BETWEEN '$from' AND '$to' " : "";
  }
 ?>

<table class="table table-striped table-vcenter table-condensed">
<thead>
    <tr>
        <th class="text-center">Name</th>
        <th class="text-center">Team Name</th>
        <th class="text-center">No Of Adds</th>
    </tr>
</thead>

<tbody>
<?php

  $add_count = "SELECT
                       Max(collection_adds.no_of_adds) AS MAXIMUM,
                       collection_adds.team_id
                FROM
                       collection_adds ".$where."
                GROUP BY
                       collection_adds.team_id"; 

$add_count_result = mysqli_query($con_main,$add_count);
while($row = mysqli_fetch_assoc($add_count_result)){

    $addcount = $row['MAXIMUM'];
    $team = $row['team_id'];

    $max_add = "SELECT
                     collection_agents.fname,
                     collection_team.team_name
               FROM
                     collection_adds
              INNER JOIN collection_agents ON collection_adds.agentid = collection_agents.id
              INNER JOIN collection_team ON collection_adds.team_id = collection_team.id
              WHERE
                    collection_adds.no_of_adds = '$addcount' AND
                    collection_adds.team_id = '$team'";

$max_add_result = mysqli_query ($con_main, $max_add);
$row2 = mysqli_fetch_assoc($max_add_result);
?>
<tr>
    <td class="text-center"><?php echo ($row2['fname']); ?></td>
    <td class="text-center"><?php echo ($row2['team_name']); ?></td>
    <td class="text-center"><?php echo ($row['MAXIMUM']); ?></td>
</tr>

<?php
}
?>


</tbody>
</table>