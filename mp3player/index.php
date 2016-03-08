

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">

<head>
    <title>MP3-Player</title>

    <link href="style.css" type="text/css" rel="stylesheet" />
    <link href="/style.css" type="text/css" rel="stylesheet" />


    <script language="javascript" type="text/javascript">
        var change=false;
        var dauernd;
        var nowplaying=0;
        var autoplay=false;
        var scrolling;
        var element;
    
        Number.prototype.toHHMMSS = function () {
            var seconds = Math.floor(this),
                hours = Math.floor(seconds / 3600);
                seconds -= hours*3600;
            var minutes = Math.floor(seconds / 60);
                seconds -= minutes*60;
            if(hours>0){
    
                if (hours   < 10) {hours   = "0"+hours;}
                if (minutes < 10) {minutes = "0"+minutes;}
                if (seconds < 10) {seconds = "0"+seconds;}
                return hours+':'+minutes+':'+seconds;
            }
            else{
                if (hours   < 10) {hours   = "0"+hours;}
                if (minutes < 10) {minutes = "0"+minutes;}
                if (seconds < 10) {seconds = "0"+seconds;}
                return minutes+':'+seconds;
            }
        }
    
        <?php
        $dir="MP3";
        
        
        
        if(isset($_GET['Folder'])) {
            $dir=$_GET['Folder'];
        }
    
        $filesx = scandir($dir);
    
        echo "var list=[];".PHP_EOL;
        foreach($filesx as $file){
            if(strpos($file,".mp3")>-1){
                echo 'list.push("'.$dir.'/'.$file.'");'.PHP_EOL;
            }
        }
        
           
    
        ?>
        
        <?php

        $filesx = scandir($dir);

        echo "var folders=[];".PHP_EOL;
        foreach($filesx as $file){
            if(strpos($file,".")<1){
                echo 'list.push('.$file.');'.PHP_EOL;
            }
        }


        ?>
    
        function scrollthrough(idn){
                element = document.getElementById("item"+idn);
                scrolling = setInterval(scroll, 10);
         
        }
        
        function setback(){
            element.scrollLeft=0;
            clearInterval(scrolling);
        }
        
        function scroll(){
                element.scrollLeft+=1;               
        }
    
        function test(){
            dauernd=setInterval(updateStuff,10);
            document.getElementById('player').src=list[nowplaying];
        }
    
        function toggleap(){
            if(autoplay){
                autoplay=false;
                document.getElementById('ap').src="images/autoplayoff.png";
            }
            else{
                autoplay=true;
                document.getElementById('ap').src="images/autoplay.png";
            }
        }
    
        function changed(){
            change=false;
            document.getElementById('player').play();
        }
    
        function next(){
            nowplaying++;
            if(nowplaying>list.length-1){
                nowplaying=0;
            }
            playfile(nowplaying);
        }
    
        function prev(){
            nowplaying--;
            if(nowplaying<0){
                nowplaying=list.length-1;
            }
            playfile(nowplaying);
        }
    
        function playfile(file){
            nowplaying=file;
            document.getElementById('player').src=list[nowplaying];
            document.getElementById('player').play();
    
    
            for(var i=0;i<=list.length-1;i++){
                var test = 'item'+i;
                if(i==file*1){
                    document.getElementById(test).setAttribute('selected','true');
                }
                else{
                document.getElementById(test).setAttribute('selected','false');
                }
    
            }
        }
    
        function custompauseplay(){
    
            if(document.getElementById('player').paused){
                document.getElementById('player').play();
                document.getElementById('pauseplay').src="images/pause.png";
            }
            else{
                document.getElementById('player').pause();
                document.getElementById('pauseplay').src="images/play.png";
            }
    
        }
    
        function customvolume(){
            document.getElementById('player').volume=document.getElementById('volume').value/100;
        }
    
        function mute(){
            if(document.getElementById('player').muted){
                document.getElementById('player').muted=false;
                document.getElementById('volbutton').src = "images/volume.png";
            }
            else{
                document.getElementById('player').muted=true;
                document.getElementById('volbutton').src = "images/mute.png";
            }
        }
    
        function changetime(){
                document.getElementById('player').currentTime=document.getElementById('player').duration/1000*document.getElementById('duration').value;
                document.getElementById('player').pause();
        }
    
        function updateStuff(){
            if(document.getElementById('player').duration.toHHMMSS()!="NaN:NaN"){
                    if(!change){
                        document.getElementById('duration').value=document.getElementById('player').currentTime/document.getElementById('player').duration*1000;
                    }
    
                    document.getElementById('time').innerHTML=document.getElementById('player').currentTime.toHHMMSS()+"/"+document.getElementById('player').duration.toHHMMSS();
            }else{
                document.getElementById('time').innerHTML="00:00/00:00";
            }
    
    
            if(document.getElementById('player').paused){
                document.getElementById('pauseplay').src="images/play.png";
            }
            else{
                document.getElementById('pauseplay').src="images/pause.png";
            }
    
            if(document.getElementById('player').currentTime.toHHMMSS()==document.getElementById('player').duration.toHHMMSS()&&autoplay){
                next();
            }
        }
        
        function selectfolder(foldername){
            window.location.href="localhost/mp3player/index.php?folder="+<?php $dir ?>+folders[foldername];   
        }


    </script>

</head>

<body bgcolor="#620000" onload="test()">
<div class="holding">
<table id="structure">
<th align="center" id="head" colspan="2"></th>
<tr>
<td id="content" width="85%">
    <table><tr>
    <div id="playerdiv">
        <audio id="player" onseeked="changed()"></audio>
        
        <div name="playercontrols" style="max-width:400px;">
        
            <div id="progress"><input type="range" id="duration" oninput="changetime()" onchange="changetime()" onmouseup="changed()" style=" width:400px; padding:0px; margin:0px;" max="1000" value="0"/><p id="time" align="right"></p></div>
            
            <div id="controldiv" style="position: relative; left:0px;">
                <img src="images/prev.png" height="24" width="24" onclick="prev()" style=" margin:0px; margin-right: 12px;" title="vorheriger Titel"/>
                <img src="images/play.png" height="24" width="24" onclick="custompauseplay()" style="margin:0px; margin-right: 12px;" id="pauseplay"/>
                <img src="images/next.png" height="24" width="24" onclick="next()" style=" margin:0px; margin-right: 12px;" title="n&auml;chster Titel"/>
                <img src="images/autoplayoff.png" height="24" width="24" onclick="toggleap()" style=" margin:0px; margin-right: 200px;" title="Autoplay" id="ap"/>
            </div>
            
            <div id="sounddiv" style="position: relative; right:-280px; top:-30px; max-width:120px; width:120px;">
                <img src="images/volume.png" height="24" width="24" onclick="mute()" style="margin:0px;" id="volbutton"/>
                <input type="range" id="volume" onchange="customvolume()" oninput="customvolume()" style="margin:0px;" value="100" />
            </div>
        </tr>
        
        <tr>
            <div id="playerlist">
            <b style="color:#FFF;">
            <?php
                        
            $listitem=0;

            foreach($filesx as $file){
                if(strpos($file,".")<1){
                    echo "\n<tr><div id='folder".$listitem."' class='item' onmouseout='setback()' onmouseover='scrollthrough(\"".$listitem."\")' onclick='selectfolder(\"".$listitem."\")'>".$file."</div></tr>";
                    $listitem++;
                }
            }
        
            $listitem=0;
        
            foreach($filesx as $file){
                if(strpos($file,".mp3")>-1){
                    echo "\n<tr><div id='item".$listitem."' class='item' onmouseout='setback()' onmouseover='scrollthrough(\"".$listitem."\")' onclick='playfile(\"".$listitem."\")'>".$file."</div></tr>";
                    $listitem++;
                }
            }
            
            
            ?>
        </div>
    </tr>
    </table>
    </div>
    </div>
</td>
<td id="navigation" width="auto">
<ul class="menu">
    <a href="/"><li class="btn">Home</li ></a>
    <a href="/mp3player"><li class="ubtn" selected>MP3-Player</li ></a>
<ul>
</td>
</tr>
</table>
</div>
</body>
</html>