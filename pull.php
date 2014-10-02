<?php
/**
 * Created by PhpStorm.
 * User: rikazdev
 * Date: 9/12/14
 * Time: 9:42 AM
 */

include 'simple.php';
//connect

$con=mysqli_connect("localhost","root","","laravel");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
    echo "Succesfully connected to DB ";
}


// Create DOM from URL or file

$html = file_get_html('http://www.tradingeconomics.com/australia/indicators');

// Find all images

$category ="";

foreach($html->find('tr') as $element) {

 $arrayIndicatorRow = array();
 $arrayHeaderRow = array();

    foreach($element->find('th') as $cell) {

        //echo strip_tags($cell->innertext);
        array_push($arrayHeaderRow,strip_tags($cell->innertext));
    }

    if (!empty($arrayHeaderRow)) {
        $category = $arrayHeaderRow[0];
    }

    foreach($element->find('td') as $cell) {

        //echo strip_tags($cell->innertext);


            array_push($arrayIndicatorRow,strip_tags($cell->innertext));
    }

    //print_r($arrayIndicatorRow);
    //echo '<br>';
    // insert values from array to db table
    if($arrayIndicatorRow[0] != null){
        mysqli_query($con,"INSERT INTO indicators (Category,Name, Last, Previous,Average,LastUpdated,Frequency) VALUES ('$category','$arrayIndicatorRow[0]','$arrayIndicatorRow[1]' ,'$arrayIndicatorRow[2]','$arrayIndicatorRow[3]','$arrayIndicatorRow[5]','$arrayIndicatorRow[6]')");
    }

}

echo "completed crowler process ".'<br>';

mysqli_close($con);




