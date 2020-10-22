<?php
header('Content-Type: application/json');

include ('config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$id = (isset($_REQUEST['summary_id']) && $_REQUEST['summary_id'] != NULL && !empty($_REQUEST['summary_id'])) ? $_REQUEST['summary_id'] : 0;


$query = "SELECT
summary_id,
ground_id,
team_id,
match_note,
match_score,
match_overs,
Inning,
match_result,
official_note,
playerName1,
playerName2,
playerName3,
player1_score,
player2_score,
player3_score,
bowler1,
bowler2,
bowler3,
bowler1_wickets,
bowler2_wickets,
bowler3_wickets
FROM
match_summary 
where summary_id=$id ";



$sql = mysqli_query ($con_main, $query);

if (!$sql){
    $result = false;
    $message .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
}

$num_rows = mysqli_num_rows($sql);

if ($num_rows > 0){
    $i = 0;

    while ($rows = mysqli_fetch_assoc ($sql)){
        $data[$i] = $rows;

        $i++;
    }
}else{
    $result = false;
    $message .= " Empty results ";
}

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);
?>