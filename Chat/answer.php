<?php
$dbpass="root";
$dbuser="root";
$dbname="chat2";

$conn = new mysqli("localhost", $dbuser, $dbpass, $dbname);
$lastID = $conn->insert_id;

$sql = "SELECT Zeit, Inhalt, Name FROM chatposts ORDER BY ID DESC LIMIT 0, 1";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    if(isset($_POST["Zeit"])&&$row["Zeit"]!=$_POST["Zeit"]){
        echo $row["Zeit"].";";
        echo $row["Name"].";";
        echo $row["Inhalt"].";";
        }
    }
$conn->close();




?>