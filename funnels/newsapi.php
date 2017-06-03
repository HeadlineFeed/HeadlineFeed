<?php
include '/html/connection.php';

# production EMV file that calls this.
$sql_select = "SELECT * FROM api WHERE id = 1";
$result = $conn->query($sql_select);
$keyRow = $result->fetch_assoc();

// api_decode($sortBy, "Source Name", "API name", category, lang);

function api_decode($sortBy, $sourceName, $source, $category, $language){
  global $keyRow;
  $NEWSAPI_url = "https://newsapi.org/v1/articles?source=" . $source . "&sortBy=" . $sortBy . "&apiKey=" . $keyRow['api_key'];

  $error_api = "error";
  if (strpos(file_get_contents($NEWSAPI_url), $error_api) === true) {
    #echo "<p>There is an error and " . $sortBy . " does not work with" . $sourceName . ".</p>"; // reporting
  } else {
    #echo "<p>Source: <strong>" . $sourceName . "</strong> - No Errors</p>"; // reporting
    $api_content = file_get_contents($NEWSAPI_url);
    $api = json_decode($api_content, true);

/*
    print '<pre>'; // reporting
    print_r($api); // reporting
    print '<pre>'; // reporting
*/

    // This is the NEWSAPI funnel.
     for ($x = 0; $x < count($api['articles']); $x++) {
       global $conn;
       // this collects the data and removes foreign characters if needed.
       $dateTimeNEWSAPI = $api['articles'][$x]['publishedAt'];
       $dateTimeNEWSAPI = str_replace(array('T', 'Z'), ' ', $dateTimeNEWSAPI);
       $dateTimeNEWSAPI = str_replace(array('/'), '-', $dateTimeNEWSAPI);
       //$dateTimeNEWSAPI = str_replace(array('0000-00-00 00:00:00'), '1000-01-01 00:00:00', $dateTimeNEWSAPI);

       // Make a INSERT $storeDateTimeGuardian[$x] to table function and call it later.
       $headlineNEWSAPI = $api['articles'][$x]['title'];
       $urlNEWSAPI = $api['articles'][$x]['url'];

       // This removes possible code adding safety.
       $dateTimeNEWSAPI = htmlentities($dateTimeNEWSAPI, ENT_IGNORE, "UTF-8");
       $headlineNEWSAPIIgnore = htmlentities($headlineNEWSAPI, ENT_IGNORE, "UTF-8");
       $urlNEWSAPIIgnore = htmlentities($urlNEWSAPI, ENT_IGNORE, "UTF-8");

       // Removes strings in headlines
       $headlineNEWSAPI = $conn->real_escape_string($headlineNEWSAPIIgnore);
       // Removes strings in URLs like
       $urlNEWSAPI = $conn->real_escape_string($urlNEWSAPIIgnore);
       #echo "$dateTimeNEWSAPI "; // reporting
       // Inserting data into temp_table
       $sql = "INSERT IGNORE INTO temp_table (srcDateTime, source, category, headline, url)
       VALUES ('$dateTimeNEWSAPI', '$sourceName', '$category', '$headlineNEWSAPI', '$urlNEWSAPI')";

        // check if data has been put into temp_table and notify user.
        if ($conn->query($sql) === TRUE) {
            #echo "Record added to Temporary Table.<br>"; // reporting
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
            #echo "$dateTimeNEWSAPI"; // reporting
        }
     }
  }
}

// Types of Sorts
$latest = "latest";
$top = "top";
$popular = "popular";

// api_decode($sortBy, "Source Name", "API name", category, lang);
//api_decode("top", "ABC News (AU)",           "abc-news-au",              "General", "en");
//api_decode("top", "Ars Technica",            "ars-technica",             "Technology", "en");
api_decode($top, "Associated Press",        "associated-press",         "General", "en");
api_decode($top, "BBC News",                "bbc-news",                 "General", "en");
//api_decode($top, "BBC Sport",               "bbc-sport",                "Sport", "en");
//api_decode($top, "Bild",                    "bild",                     "General", "de");
api_decode($top, "Bloomberg",               "bloomberg",                "Business", "en");
api_decode($top, "Business Insider",        "business-insider",         "Business", "en");
//api_decode($top, "Business Insider (UK)",   "business-insider-uk",      "Business", "en");
//api_decode($top, "Buzzfeed",                "buzzfeed",                 "Entertainment", "en");
//api_decode($top, "CNBC",                    "cnbc",                     "Business", "en");
api_decode($top, "CNN",                     "cnn",                      "General", "en");
//api_decode($top, "Daily Mail",              "daily-mail",               "Entertainment", "en");
//api_decode($top, "Engadget",                "engadget",                 "Technology", "en");
//api_decode($top, "Entertainment Weekly",    "entertainment-weekly",     "Entertainment", "en");
api_decode($top, "ESPN",                    "espn",                     "Sport", "en");
//api_decode($top, "ESPN Cric Info",          "espn-cric-info",           "Sport", "en");
//api_decode($top, "Financial Times",         "financial-times",          "Business", "en");
//api_decode($top, "Focus",                   "focus",                    "General", "de");
//api_decode($top, "Football Italia",         "football-italia",          "Sport", "en");
//api_decode($top, "Fortune",                 "fortune",                  "Business", "en");
//api_decode($top, "FourFourTwo",             "four-four-two",            "Sport", "en");
//api_decode($top, "Fox Sports",              "fox-sports",               "Sport", "en");
//api_decode($top, "Google News",             "google-news",              "General", "en");
//api_decode($top, "Gruenderszene",           "gruenderszene",            "Technology", "de");
//api_decode($top, "Hacker News",             "hacker-news",              "Technology", "en");
//api_decode($top, "IGN",                     "ign",                      "Gaming", "en");
//api_decode($top, "Independent",             "independent",              "General", "en");
//api_decode($top, "Mashable",                "mashable",                 "Entertainment", "en");
//api_decode($top, "Metro",                   "metro",                    "General", "en");
//api_decode($top, "Mirror",                  "mirror",                   "General", "en");
//api_decode($top, "MTV News",                "mtv-news",                 "Music", "en");
//api_decode($top, "MTV News (UK)",           "mtv-news-uk",              "Music", "en");
//api_decode($top, "National Geographic",     "national-geographic",      "Science and Nature", "en");
//api_decode($top, "New Scientist",           "new-scientist",            "Science and Nature", "en");
//api_decode($top, "Newsweek",                "newsweek",                 "General", "en");
//api_decode($top, "New York Magazine",       "new-york-magazine",        "General", "en");
//api_decode($top, "NFL News",                "nfl-news",                 "Sport", "en");
//api_decode($top, "Polygon",                 "polygon",                  "Gaming", "en");
//api_decode($top, "Recode",                  "recode",                   "Technology", "en");
//api_decode($top, "Reddit",                  "reddit-r-all",             "General", "en");
//api_decode($top, "Reuters",                 "reuters",                  "General", "en");
//api_decode($top, "Sky News",                "sky-news",                 "General", "en");
//api_decode($top, "Sky Sports News",         "sky-sports-news",          "Sport", "en");
//api_decode($top, "Spiegel Online",          "spiegel-online",           "General", "de");
//api_decode($top, "T3n",                     "t3n",                      "Technology", "de");
//api_decode($top, "TalkSport",               "talksport",                "Sport", "en");
api_decode($top, "TechCrunch",              "techcrunch",               "Technology", "en");
//api_decode($top, "TechRadar",               "techradar",                "Technology", "en");
//api_decode($top, "The Economist",           "the-economist",            "Business", "en");
//api_decode($top, "The Guardian AU",         "the-guardian-au",          "General", "en");
//api_decode($top, "The Guardian UK",       "the-guardian-uk",          "General", "en");
//api_decode($top, "The Hindu",               "the-hindu",                "General", "en");
//api_decode($top, "The Huffington Post",     "the-huffington-post",      "General", "en");
//api_decode($top, "The Lad Bible",           "the-lad-bible",            "Entertainment", "en");
api_decode($popular, "The New York Times",      "the-new-york-times",       "General", "en");
//api_decode($top, "The Next Web",            "the-next-web",             "Technology", "en");
//api_decode($top, "The Sport Bible",         "the-sport-bible",          "Sport", "en");
//api_decode($top, "The Telegraph",           "the-telegraph",            "General", "en");
//api_decode($top, "The Times of India",      "the-times-of-india",       "General", "en");
//api_decode($top, "The Verge",               "the-verge",                "Technology",  "en");
api_decode($top, "The Wall Street Journal", "the-wall-street-journal",  "Business", "en");
api_decode($top, "The Washington Post",     "the-washington-post",      "General", "en");
//api_decode($top, "Time",                    "time",                     "General", "en");
//api_decode($top, "USA Today",               "usa-today",                "General", "en");
//api_decode($top, "Wired.de",                "wired-de",                 "Technology", "de");

?>
