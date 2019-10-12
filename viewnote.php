<html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<?php
session_start();
$id=$_GET["id"];

require_once('connection.php');

    $conn->select_db('notes');
$sql ="SELECT icon, text FROM notes WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

$row = $result->fetch_assoc();

} else {
    echo "0 results";
}
?>
<body>

<div class="container" style="text-align:center">
<h1  style="text-align:center"> Note <?php echo $id ?></h1>
<div style="width:10%;margin: 20px auto"><?php echo $row["icon"] ?></div>
<div id="container">
<p><?php echo $row["text"] ?></p></div>
<a href="index.php" class="btn btn-primary btn-sm">Home</a>
</div>


</body>
</html>