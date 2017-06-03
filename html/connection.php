<?php
$limit = 10;

#Timout
ini_set('mysql.connect_timeout',900);
ini_set('default_socket_timeout',900);

# Connect to database
$servername = "localhost"; // localhost on XAMPP
$username = "root";
$password = "";
$dbname = "funnel";

# Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
# Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
// looking into connection calling. they each do a job.

?>
