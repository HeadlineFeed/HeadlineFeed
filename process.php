<?php
include 'html/connection.php';
include 'html/shortURL.php';

/*
|--------------------------------------------------------------------------
| API Process
|--------------------------------------------------------------------------
|
| This process calls the news_api and then processes the data into our format.
| And after that sends it to the temp_table in the database.
| Then it moves, sorts, and applies our date and time and sends it to the
| public_table in the database.
|
*/

// NEWSAPI.org
include 'funnels/newsapi.php';

echo "<h2>Processor</h2>";
$dataInTemp = false;

function transfer_headlines(){
  global $dataInTemp, $conn;
  if ($dataInTemp == false) {
    # Assigns our dateTime
    $currentTimeStamp = date('Y-m-d G:i:s');

    // Moves temp_table to public_table
    if($result = $conn->query("SELECT * FROM temp_table ORDER BY srcDateTime DESC")) {

      // Counts in the temp_table
      if($count = $result->num_rows) {
       #echo '<p>Records in que: <strong>',$count,'</strong></p>'; // reporting

        // Loops through all the results from temp_table
        while($row = $result->fetch_object()) {
          # array push
          # build up a comma seperated list and do batch delete if needed // use a subquery
          // Store each column in a variable
          $ourDateTime = $currentTimeStamp;
          $srcDateTime = $row->srcDateTime;
          $sourceName = $row->source;
          $category = $row->category;
          $headlineNEWSAPIIgnore = $row->headline;
          $srcURLIgnore = $row->url;

          // Removes strings in headlines
          $ourHeadline = $conn->real_escape_string($headlineNEWSAPIIgnore);
          // Removes strings in URLs like
          $srcURL = $conn->real_escape_string($srcURLIgnore);
					$srcURL = shst($srcURL);

          // Inserting data into public_table
          $publicCheck = mysqli_query($conn, "SELECT * FROM `public_table` WHERE url = '" . $srcURL . "' OR headline = '" . $ourHeadline . "'");

        // Checks for duplicates and inserts if there is no duplicate.
          if (mysqli_num_rows($publicCheck) > 0) {
               // delete data from temp_table if it is a duplicate
               $sql_delete = $conn->query("DELETE FROM `temp_table` WHERE url = '" . $srcURL . "' OR headline = '" . $ourHeadline . "'");
               // $sql_resetAI = $conn->query('ALTER TABLE temp_table AUTO_INCREMENT = 1');
               #echo "<p style=\"color:red;\">Record exists - Deleted from Temporary Table.</p>"; // reporting
           } else {
               // move data into public_table
               $sql = "INSERT INTO public_table (ourDateTime, srcDateTime, source, category, headline, url)
               VALUES ('$ourDateTime', '$srcDateTime', '$sourceName', '$category', '$ourHeadline', '$srcURL')";

               // check if the move to public_table was successful or return an error
               if ($conn->query($sql) === true) {
                 $sql_delete = $conn->query("DELETE FROM temp_table WHERE url = '" . $srcURL . "' OR headline = '" . $ourHeadline . "'");
                 #echo "<p style=\"color:green;\">Record added - Deleted from Temporary Table.</p>"; // reporting
               } else {
                    echo "<strong>Error: </strong>" . $sql . "<br>" . $conn->error . "<br><strong>END OF ERROR</strong><br><br>";
               }
           }
        }
        // Free up $result
        $result->free();
      }
    } else {
      die($conn->error);
    }
  }
}

transfer_headlines();

$conn->close();
?>
