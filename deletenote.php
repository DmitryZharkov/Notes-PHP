<?php
session_start();
$id=$_GET["id"];

require_once('connection.php');

    $conn->select_db('notes');

$sql ="DELETE FROM notes WHERE id='$id'";
$result = $conn->query($sql);

$conn->close();
header('Location: index.php');
?>
