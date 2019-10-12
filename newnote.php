 <?php
 
$text = $_POST["text"];
$randstring=RandomString();

//The URL you want to send a cURL proxy request to.
$url = "https://avatars.dicebear.com/v2/jdenticon/{$randstring}.svg";
 
//The IP address of the proxy you want to send
//your request through.
//$proxyIP = '172.22.30.3';
 
//The port that the proxy is listening on.
//$proxyPort = '3128';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
 
//Set the proxy IP.
//curl_setopt($ch, CURLOPT_PROXY, $proxyIP);
 
//Set the port.
//curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
 
//Execute the request.
$icon = curl_exec($ch);
 
//Check for errors.
if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}

// Create connection

require_once('connection.php');

    $conn->select_db('notes');
$sql = "INSERT INTO notes (id, icon, text) VALUES (0, '$icon', '$text')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header('Location: index.php');

function RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
