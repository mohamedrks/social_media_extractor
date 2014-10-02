<?php
/**
 * Created by PhpStorm.
 * User: rikazdev
 * Date: 10/2/14
 * Time: 9:12 AM
 */

$con = mysqli_connect("localhost", "root", "", "social_media_schema");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    echo "<br>";
} else {
    echo "Succesfully connected to DB ";
    echo "<br>";
}


$timeStart = '1412229747'; //$_REQUEST['startTime'];
$timeEnd = '1412231828'; //$_REQUEST['endTime'];

//$sqlQuery = "SELECT a.account_name, s.* FROM accounts a LEFT JOIN stats s ON a.account_id = s.account_id
//WHERE s.time BETWEEN " . $timeStart . " AND " . $timeEnd;

$sqlQuery = "SELECT a.account_name, s.* FROM accounts a
              LEFT JOIN stats s ON a.account_name = s.account_id
              WHERE s.timestamps BETWEEN  '$timeStart'  AND  '$timeEnd' group by a.account_name";

$results = mysqli_query($con, $sqlQuery);

echo $results;

while ($row = mysql_fetch_assoc($query)) {
    echo  $row['account_name'];

}
/* Output header */
header('Content-type: application/json');

//echo json_encode($rowArr);

@mysql_close($conn);



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

