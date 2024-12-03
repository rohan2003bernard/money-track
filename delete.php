<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "track";

global $conn ;
$conn = new mysqli($servername, $username, $password, $dbname);
if(isset($_GET["sno"])){
$s=$_GET["sno"];
$del_q="DELETE from info where s_no=$s";
$result=$conn->query($del_q);

if ($result) {
    header("Location :http://localhost/money_track/display.php?page=spent");
} else {
    echo "Error: " . $conn->error;
}

}
?>