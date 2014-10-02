<?php
/**
 * Created by PhpStorm.
 * User: rikazdev
 * Date: 10/1/14
 * Time: 10:57 AM
 */
include 'simple.php';


$con = mysqli_connect("localhost", "root", "", "social_media_schema");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    echo "<br>";
} else {
    echo "Succesfully connected to DB ";
    echo "<br>";
}


$account_names = mysqli_query($con, "SELECT account_name FROM accounts");
//$time = times();

$date = new DateTime('now', new DateTimeZone('Asia/colombo'));
echo $date->format('d-m-Y H:i:s');

echo $time;
while ($row = mysqli_fetch_array($account_names, MYSQL_NUM)) {
//    print_r($row[0]);
    $var_account_name = $row[0];

    $dom = new DOMDocument;
    $temp_html = $dom->loadHTMLFile("sourceFile.html");
    $books = $dom->getElementsByTagName('span');
    foreach ($books as $book) {
        $num = $book->getElementsByTagName('span')->item(1)->nodeValue;
        $nam = $book->getElementsByTagName('span')->item(2)->nodeValue;


        if(!strcmp(trim($nam),"followers"))
        {
            echo trim($num);
            echo trim($nam).'<br>';

        }
        elseif(!strcmp(trim($nam),"following"))
        {
            echo trim($num);
            echo trim($nam).'<br>';
        }

            //insert into database
       // insert($time, $followers, $followings, $account_id);

    }


}

echo "completed crowler process " . '<br>';

mysqli_close($con);