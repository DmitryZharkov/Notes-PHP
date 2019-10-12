 <?php

session_start();

$text = $_POST["text"];
$id = $_POST["ida"];

// Create connection

require_once('connection.php');

$conn->select_db('notes');

$sql = "UPDATE notes SET text='$text' WHERE id='$id'";
$result = $conn->query($sql);

$conn->close();

header('Location: index.php');

?>