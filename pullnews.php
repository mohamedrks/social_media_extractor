<?php
/**
 * Created by PhpStorm.
 * User: rikazdev
 * Date: 9/12/14
 * Time: 2:48 PM
 */



$con = mysqli_connect("localhost", "root", "", "laravel");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Succesfully connected to DB ";
}

echo "<br>";
$stock_quotes = mysqli_query($con, "SELECT 	stock_symbol FROM user_subscriptions");

while ($row = mysqli_fetch_array($stock_quotes)) {
    echo $var_quote_symbol = $row['stock_symbol'];
    echo "<br>";

    $title_availability = false;

    //mysqli_query($con,"INSERT INTO indicators (Category,Name, Last, Previous,Average,LastUpdated,Frequency) VALUES ('$category','$arrayIndicatorRow[0]','$arrayIndicatorRow[1]' ,'$arrayIndicatorRow[2]','$arrayIndicatorRow[3]','$arrayIndicatorRow[5]','$arrayIndicatorRow[6]')");

    //$xml = (" http://feeds.finance.yahoo.com/rss/2.0/headline?s=.$var_quote_symbol.&region=US&lang=en-US");
    $xml = ("http://feeds.finance.yahoo.com/rss/2.0/headline?s=aapl&region=US&lang=en-US");
    $xmlDoc = new DOMDocument();
    $xmlDoc->load($xml);

    //get elements from "<channel>"
    $x = $xmlDoc->getElementsByTagName('item');
    for ($i = 0; $i <= 50; $i++) {
        $item_title = $x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
        $item_pubDate = $x->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;
        $item_link = $x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
        $item_desc = $x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
        echo("<p><a href='" . $item_link . "'>" . $item_title . "</a>");
        echo("<br>");
        echo($item_desc . "<br>");
        echo($item_pubDate . "</p>");

        if ($item_desc != null) {

            $results = mysqli_query($con, "SELECT Title FROM news_articles WHERE Title='$item_title'");
            $existing_news_titles = mysqli_fetch_array($results);

            if (count($existing_news_titles) == 0) {
                mysqli_query($con, "INSERT INTO news_articles (Title, Link, Pubdate, Description) VALUES ('$item_title','$item_link','$item_pubDate' ,'$item_desc')");

                $news_article_id = mysqli_fetch_array(mysqli_query($con, "SELECT Id from news_articles where Title='$item_title'"));

                //echo array_values($news_article_id)[0];
                $new_article_id = array_values($news_article_id)[0];
                if ($new_article_id > 0) {
                    mysqli_query($con, "INSERT INTO news_symbol (news_article_id, stock_symbol) VALUES ('$new_article_id','$var_quote_symbol')");
                }
            }

        }


    }
}

mysqli_close($con);