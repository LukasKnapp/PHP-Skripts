<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<?php
$dbserver = "localhost";
$dbpw = "root";
$dbuser = "root";
$dbname = "videoverwaltung";

$conn = new mysqli($dbserver, $dbuser, $dbpw, $dbname);


if(isset($_POST["speichern"])){

$sqlString  = "SELECT * FROM videos";

$result = $conn->query($sqlString) or die("fehler!");
$nr = ($result->num_rows)+1;

$titel = $_POST['titel'];
$beschreibung = $_POST['beschreibung'];
$datum = $_POST['datum'];
$zeit = $_POST['uhrzeit'];
$sender = $_POST['sender'];
$genre = $_POST['genre'];
$dauer = $_POST['dauer'];

$sqlString  = "INSERT INTO videos (Titel, Beschreibung, Datum, Uhrzeit, Dauer, Sender, Genre, Nr) VALUES ('".$titel."','".$beschreibung."','".$datum."','".$zeit."','".$dauer."','".$sender."','".$genre."',".$nr.")";

$result = $conn->query($sqlString) or die("fehler!");    
}

if(isset($_POST["loeschen"])){

$sqlString  = "DELETE FROM videos WHERE V_ID=";

$l=$_POST['l'];

foreach($l as $a => $b){
        //echo $sqlString.$a;
        $result = $conn->query($sqlString.$a) or die("fehler!");
        echo "UPDATE videos SET Nr = Nr-1 WHERE V_ID >".$a;
        $result = $conn->query("UPDATE videos SET Nr = Nr-1 WHERE V_ID >".$a) or die("fehler!");
}

//$result = $conn->query($sqlString) or die("fehler!");
}

?> 
<head>
    <title>AufnahmeVerzeichnis</title>

    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="generator" content="Webocton - Scriptly (www.scriptly.de)" />

    <link href="style.css" type="text/css" rel="stylesheet" />
    <script language="javascript" type="text/javascript">
    sql
    
    
   </script>
</head>

<body>
<table border="0" summary="">
<form name="videos" action="" method="post">
<?php
$sqlString  = "SELECT * FROM sender";

$result = $conn->query($sqlString);
echo "<tr> <td>Sender:</td> <td><select name='sender'>";

foreach($result as $i){
        echo "<option value='".$i['S_ID']."'>".$i["SenderName"]."</option>";

}

echo "</select></td></tr>";
 ?>
 
<tr> <td>Datum:</td> <td> <input name="datum" placeholder="YYYY-MM-DD" title="YYYY-MM-DD"/></td></tr>
<tr> <td>Uhrzeit:</td> <td> <input name="uhrzeit" placeholder="HH:mm" title="HH:mm"/></td></tr>
<tr> <td>Dauer:</td> <td> <input name="dauer" placeholder="in Minuten" title="in Minuten"/></td></tr>
 
<?php 
$sqlString  = "SELECT * FROM genre";

$result = $conn->query($sqlString);
echo "<tr> <td> Genre: </td> <td> <select name='genre'>";

foreach($result as $i){
        echo "<option value='".$i['G_ID']."'>".$i["GenreName"]."</option>";

}

echo "</select></td></tr>";

 ?>
 
<tr> <td>Titel:</td> <td> <input name="titel" title="Titel"/></td>
<tr valign="top"> <td>Beschreibung:</td> <td> <textarea name="beschreibung" title="Beschreibung" rows="15" cols="30"></textarea></td></tr>
<tr><td></td><td></td><td><input type="submit" name="speichern"/></td></tr>
</table> 
 </form>
<form name="sortierung" method="post" action="">
<select name="wert">
    <option value="Nr">Nummer</option>
    <option value="Titel">Titel</option>
    <option value="Sender">Sender</option>
    <option value="Genre">Genre</option>
    <option value="Datum">Datum</option>
    <option value="Uhrzeit">Uhrzeit</option>
    <option value="Dauer">Dauer</option>
</select>
<select name="reihenfolge">
    <option value="DESC">absteigende Reihenfolge</option>
    <option value="ASC">aufsteigende Reihenfolge</option>
</select>
<input type="submit" name="sortieren" value="sortieren"/>
</form>
<form name="loeschen" action="" method="post">
<table border="1" cellpadding="0" cellspacing="0" summary="">
<?php
if(isset($_POST['sortieren'])){
    $sqlString  = "SELECT * FROM videos ORDER BY ".$_POST['wert']." ".$_POST['reihenfolge'];    
}
else{
    $sqlString  = "SELECT * FROM videos";
}

$result = $conn->query($sqlString);
echo "<tr><b><td>Nr</td><td>Titel</td><td>Sender</td><td>Genre</td><td>Datum</td><td>Uhrzeit</td><td>Dauer</td><td>Beschreibung</td><td><input type='submit' name='loeschen' value='l&ouml;schen'/></td></b></tr>";
while($row = $result->fetch_assoc()) {
    
    $resultS = $conn->query("SELECT SenderName FROM sender WHERE S_ID ='".$row['Sender']."'");
    $resultG = $conn->query("SELECT GenreName FROM genre WHERE G_ID ='".$row['Genre']."'");
    $rowS = $resultS->fetch_assoc();
    $rowG = $resultG->fetch_assoc();
    
    
    echo "<tr><td>".$row['Nr']."</td><td>".$row['Titel']."</td><td>".$rowS['SenderName']."</td><td>".$rowG['GenreName']."</td><td>".$row['Datum']."</td><td>".$row['Uhrzeit']."</td><td>".$row['Dauer']."</td><td>".$row['Beschreibung']."</td><td><input type='checkbox' name='l[".$row['V_ID']."]'/></td></tr>";
}             
$conn->close();
 ?>
</form>
</table>
</body>
</html>