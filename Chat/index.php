<head>
 
 <title>ITA2a Chatroom!</title>
 <link rel="shortcut icon" href="favicon.ico">
 <link href="/style.css" type="text/css" rel="stylesheet" />
 <script language="javascript" type="text/javascript">
 
    var x;
    var zeit;
    var antwort;
    if (window.XMLHttpRequest)
    {
        x=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        x=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    var y;
    
    if (window.XMLHttpRequest)
    {
        y=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        y=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    function sendMessage(){
    
    x.open("POST","send.php");
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    x.send("Nachricht="+document.chatform.eingabe.value+"&Username=Peter");
    document.chatform.eingabe.value=" ";
    
    }
    
    function getMessage(){
        setInterval(function(){
            if(y.readyState == 4 && y.status == 200) {
                if(y.responseText!=""){
                antwort = y.responseText;
                ausgaben=antwort.split(";");
                zeit=ausgaben[0];
                var inhalt = ausgaben[2];
                document.getElementById("inhalt").innerHTML = ausgaben[1]+": "+ausgaben[2]+"<br/>"+document.getElementById("inhalt").innerHTML;
                }
            }
            y.open("POST","answer.php");
            y.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            y.send("Zeit="+zeit);
            
            
        }, 30) 
    }
 
 </script> 
 </head>
 <form name="chatform" action="" method="" onsubmit="return false;">
 <body onload="getMessage()">
    <table id="besttableeuw" border="" style="width: 1000px; height: 800px; max-width: 1000px; max-height: 800px;">
    <tr>
        <td rowspan="2"><div id="inhalt" style="height:750px; width:750px; overflow-y: auto;">
                Chatinhalt
        </div></td>
        
        <td width="250px" height="200px"><div id="user">
                Rooms
        </div></td>
    </tr>
    <tr>
            <td width="250px" height="550px"><div id="user">
                Users
        </div></td>
    </tr>
    <tr>
        <td height="50px"  colspan="2">
                <input name="eingabe" style="height:100%; width: 90%; border: none;" onkeydown="if (event.keyCode == 13) {sendMessage(); return false;}"/> <input type="button" value="Send" name="senden" style="height:100%; width:9%; align: right;" onclick="sendMessage()"/>
            
        </td>
    </tr>
    </table>
</form>
</body>