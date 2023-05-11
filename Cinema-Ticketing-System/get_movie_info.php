<?php
// Connect to the database
include("connect.php");

// Retrieve the movie information
$movieId = $_GET['movieId']??null;
if (!$movieId) {
    // If movieId parameter is missing, report it and exit
    http_response_code(400);
    die("Error: movieId parameter is missing");
  }
$sql = "SELECT * FROM movie WHERE MovieID = $movieId";
$result = mysqli_query($conn, $sql);

if (!$result) {
  // If there was an error with the query, report it and exit
  $error = mysqli_error($conn);
  http_response_code(500);
  die("Error retrieving movie information: " . $error);
}

$movieInfo = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($conn);

// Return the movie information as a JSON object
header('Content-Type: application/json');
echo json_encode($movieInfo);

http_response_code(200);
echo "Movie information retrieved successfully!";

?>