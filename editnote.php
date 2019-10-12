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


<h1> Edit Note <?php echo $id ?></h1>
<div style="width:10%; height:10%;"><?php echo $row["icon"] ?></div>

 <div style="margin-top:6%">
 <div style="align:center">
  <form action="submitnote.php" method="post" style="width:30%">
  <div class="form-group">
    <label for="text">Text:</label>
    <textarea class="form-control" id="text" name="text" cols="40" rows="7"><?php echo $row["text"] ?></textarea>
  </div>

<input type="hidden" id="ida" name="ida" value="<?php echo $id ?>">
  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
<a href="index.php" class="btn btn-primary btn-sm">Discard</a>
</form> </div>

</body>
</html>