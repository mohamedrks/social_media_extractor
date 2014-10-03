<?php
/**
 * Created by PhpStorm.
 * User: rikazdev
 * Date: 10/1/14
 * Time: 10:57 AM
 */
include 'simple.php';

function scrape_insta($username) {
    $insta_source = file_get_contents('http://instagram.com/'.$username);
    $shards = explode('window._sharedData = ', $insta_source);
    $insta_json = explode('"}};', $shards[1]);
    $insta_array = json_decode($insta_json[0].'"}}', TRUE);
    return $insta_array;
}



$con = mysqli_connect("localhost", "root", "", "social_media_schema");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    echo "<br>";
} else {
    echo "Succesfully connected to DB ";
    echo "<br>";
}


$account_names = mysqli_query($con, "SELECT account_name FROM accounts");

$currenttime = time();
echo $currenttime;

while ($row = mysqli_fetch_array($account_names, MYSQL_NUM)) {

    $following = 0;
    $followers = 0;
    $var_account_name = $row[0];

    echo '<pre>';

    $counts = scrape_insta($var_account_name)['entry_data']['UserProfile'][0]['user']['counts'];
    print_r($counts);
    echo '</pre>';
    mysqli_query($con, "INSERT INTO stats (account_id, following, followers,timestamps) VALUES ('$var_account_name',".$counts['followed_by'].",".$counts['follows'].",'$currenttime')");

}

echo "completed crowler process " . '<br>';

mysqli_close($con);