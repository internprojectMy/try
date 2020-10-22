<?php
header('Content-Type: application/json');

require_once('config.php');

$responce = array();
$message = "";
$data = "";
$result = true;
$op = $_REQUEST['operation'];
$id = $_REQUEST['summary_id'];
$ground_id = $_REQUEST['ground_id'];
$team_id = $_REQUEST['team_id'];
$match_note = $_REQUEST['match_note'];
$match_score = $_REQUEST['match_score'];
$match_overs= $_REQUEST['$match_overs'];
$Inning = $_REQUEST['Inning'];
$match_result = $_REQUEST['match_result'];
$official_note = $_REQUEST['official_note'];
$playerName1 = $_REQUEST['playerName1'];
$playerName2 = $_REQUEST['playerName2'];
$playerName3 = $_REQUEST['playerName3'];
$player1_score = $_REQUEST['player1_score'];
$player2_score = $_REQUEST['player2_score'];
$player3_score = $_REQUEST['player3_score'];
$bowler1 = $_REQUEST['bowler1'];
$bowler2 = $_REQUEST['bowler2'];
$bowler3 = $_REQUEST['bowler3'];
$bowler1_wickets = $_REQUEST['bowler1_wickets'];
$bowler2_wickets = $_REQUEST['bowler2_wickets'];
$bowler3_wickets = $_REQUEST['bowler3_wickets'];

$uniqe_id = $_REQUEST['uniqe_id'];

if ($uniqe_id == '0') {

    $insert = "INSERT INTO `match_summary` (
                `ground_id`,
                `team_id`,
                `match_note`,
                `match_score`,
                `match_overs`,
                `Inning`,
                `match_result`,
                `official_note`,
                `playerName1`,
                `playerName2`,
                `playerName3`,
                `player1_score`,
                `player2_score`,
                `player3_score`,
                `bowler1`,
                `bowler2`,
                `bowler3`,
                `bowler1_wickets`,
                `bowler2_wickets`,
                `bowler3_wickets`
                
            )
            VALUES
                (
                    '$ground_id',
                    '$team_id',
                    '$match_note',
                    '$match_score',
                    '$match_overs',
                    '$Inning',
                    '$match_result',
                    '$official_note',
                    '$playerName1',
                    '$playerName2',
                    '$playerName3',
                    '$player1_score',
                    '$player2_score',
                    '$player3_score',
                    '$bowler1',
                    '$bowler2',
                    '$bowler3',
                    '$bowler1_wickets',
                    '$bowler2_wickets',
                    '$bowler3_wickets'

                )";
}else if ($op =="update"){
    if($is_main_module == 1 && (empty($summary_id) || $summary_id == 0)){
 $summary_id = $id;
    }
    $update = "UPDATE `match_summary`
    SET `ground_id`='$ground_id',
    `team_id` = '$team_id',
    `match_note` = '$match_note',
    `match_score` = '$match_score',
    `match_overs` = '$match_overs',
    `Inning` = '$Inning',
    `match_note` = 'match_note',
    `official_note` = 'official_note',
    `playerName1` ='playerName1',
    `playerName2` = 'playerName2',
    `playerName3` ='playerName3',
    `player1_score` = 'player1_score',
    `player2_score`= 'player2_score',
    `player3_score`='player3_score',
    `bowler1`='bowler1',
    `bowler2`='bowler2',
    `bowler3`='bowler3',
    `bowler1_wickets`='bowler1_wickets',
    `bowler2_wickets`='bowler2_wickets',
    `bowler3_wickets`='bowler3_wickets'
    WHERE (`summary_id` = $id)";
}

    $sql = mysqli_query($con_main, $insert, $update);
    $inserted_id = mysqli_insert_id($con_main);




if ($sql) {
    $result = true;
    $message = "Success";
    $data = $inserted_id;
} else {
    $result = false;
    $message = "Error SQL: (" . mysqli_errno($con_main) . ") " . mysqli_error($con_main);
}

$responce['operation'] = $op;
$responce['result'] = $result;
$responce['data'] = $data;
$responce['message'] = $message;
$responce['query'] = $insert;

echo (json_encode($responce));


mysqli_close($con_main);
