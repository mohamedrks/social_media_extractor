<?php
/**
 * Created by PhpStorm.
 * User: rikazdev
 * Date: 10/2/14
 * Time: 9:12 AM
 */


$con = mysql_connect("localhost", "root", "");

if (!$con) {
    die('could no connect' . mysql_error());
}
mysql_select_db('social_media_schema', $con);

if(!empty($_REQUEST['startTime'])) { $timeStart= $_REQUEST['startTime']; } else { $timeStart = 0; }

if(!empty($_REQUEST['endTime'])) { $timeEnd= $_REQUEST['endTime']; } else { $timeEnd = time(); }

function convert($result) {

    $intermediate = array();

    while($item = mysql_fetch_assoc($result)) {

        $key = $item['account_name'];
        $date = $item['timestamps'];
        $value = $item['followers'];

        $intermediate[$key][] = array($date, $value);

    }

//    foreach($data as $item) {
//        list($key, $date, $value) = $item;
//        $intermediate[$key][] = array($date, $value);
//    }

    $output = array();

    foreach($intermediate as $key => $values) {
        $output[] = array(
            'key' => $key,
            'values' => $values
        );
    }

    return $output;

    // The rest of the function stays the same
}

$sqlQuery = "SELECT a.account_name, s.following , s.followers , s.timestamps FROM accounts a
              LEFT JOIN stats s ON a.account_name = s.account_id
              WHERE s.timestamps BETWEEN  '$timeStart'  AND  '$timeEnd'
             ORDER BY a.account_name, s.timestamps";



$result = mysql_query($sqlQuery, $con);

$values = array();
$count = 0;

if($result) {


    $jsonData = convert($result);
}

echo json_encode($jsonData);


mysql_close($con);



/* Output header */
//header('Content-type: application/json');

//echo json_encode($rowArr);


//if($_SERVER['REQUEST_METHOD'] == "POST"){
//    // Get data
//    $name = isset($_POST['name']) ? mysql_real_escape_string($_POST['name']) : "";
//    $email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) : "";
//    $password = isset($_POST['pwd']) ? mysql_real_escape_string($_POST['pwd']) : "";
//    $status = isset($_POST['status']) ? mysql_real_escape_string($_POST['status']) : "";
//
//    // Insert data into data base
//    $sql = "INSERT INTO `tuts_rest`.`users` (`ID`, `name`, `email`, `password`, `status`) VALUES (NULL, '$name', '$email', '$password', '$status');";
//    $qur = mysql_query($sql);
//    if($qur){
//        $json = array("status" => 1, "msg" => "Done User added!");
//    }else{
//        $json = array("status" => 0, "msg" => "Error adding user!");
//    }
//}else{
//    $json = array("status" => 0, "msg" => "Request method not accepted");
//}


//echo "</table>";
