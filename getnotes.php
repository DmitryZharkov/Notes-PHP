<?php

$off=$_GET["off"];
$sort=$_GET["sort"];
$SearchString = $_GET["SearchString"];

require_once('connection.php');

    $conn->select_db('notes');
    
    $sql ="SELECT count(*) as total from notes WHERE text LIKE '%$SearchString%'";
    $result = $conn->query($sql);
	$data=$result->fetch_assoc();    
    
$sql ="SELECT id, icon, text FROM notes WHERE text LIKE '%$SearchString%' "." ORDER BY ".$sort." LIMIT 10 OFFSET ".$off;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $rows[] = array('data' => $row);
    }
    $rows[] = array('data' => $data);
    echo json_encode($rows);
} else {
    echo json_encode(array());
}
?>
