<?php
/**
 * Created by PhpStorm.
 * User: rikazdev
 * Date: 10/2/14
 * Time: 9:12 AM
 */

$timeStart = $_REQUEST['startTime'];
$timeEnd = $_REQUEST['endTime'];

$sqlQuery = "SELECT a.account_name, s.* FROM accounts a LEFT JOIN statistics s ON a.account_id = s.account_id
WHERE s.time BETWEEN ".$timeStart." AND ".$timeEnd;


$query = mysql_queryi($con, $sqlQuery);

$rowArr = mysql_fetch_array($query);

echo json_encode($rowArr);
