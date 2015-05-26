<?php
$dbpass="root";
$dbuser="root";
$dbname="chat2";


$conn = new mysqli("localhost", $dbuser, $dbpass, $dbname);

$Name = mysqli_real_escape_string($conn, $_POST['Username']);
$Inhalt = mysqli_real_escape_string($conn, $_POST['Nachricht']);
$tagauf = strpos($Inhalt,"<");
$tagzu = strpos($Inhalt,">");
if($tagauf!=$tagzu&&$tagauf!=null&&$tagzu!=null){

while($tagzu!=1){
    $tag = substr($Inhalt,$tagauf+1,$tagzu-$tagauf);
    $Inhalt = trim($Inhalt,$tag);
    $tagauf = strpos($Inhalt,"<")+1;
    $tagzu = strpos($Inhalt,">")+1;
}

}

$sql = "INSERT INTO chatposts (Inhalt, Name) VALUES ('".$Inhalt."', '".$Name."')";
$result = $conn->query($sql);
$conn->close();




?>