#!/usr/local/bin/php

<!DOCTYPE html>
<html>
<head>
<title>Destroy your mouse</title>

<link href="destroyurmouse.css" rel="stylesheet" type="text/css" media="screen" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>


<script>
var finalscore;

//count number of clicks
var count=0;
function incrementCount(id)
{
	count++;
	id.innerHTML="Score : " + count;
}

var time=5;
var counter;

function timer()
{
  time=time-1;
  
  if (time <= 0)
  {
     clearInterval(counter);
     //counter ended, display 0 and final count value
	 document.getElementById('timer').innerHTML="0 sec";
	 //document.getElementById('countText').style.display="none";
	 //document.getElementById('finalCountText').style.display="block";
	 document.getElementById('finalScore').innerHTML="Your score is "+count;
	 finalscore = count;
	 document.getElementById('restartButton').style.display="block";
	 document.getElementById('shareFB').style.display="block";
	 
     return;
  }

  document.getElementById('timer').innerHTML=time + " sec";
}

function startGame()
{
	//countdown timer
	document.getElementById('startButton').style.display="none";
	document.getElementById('startText').style.display="none";
	//document.getElementById('finalCountText').style.display="none";
	//document.getElementById('countText').style.display="block";
	counter=setInterval(timer, 1000); //1000 will  run it every 1 second

}

function hideElements()
{
	document.getElementById('restartButton').style.display="none";
	document.getElementById('shareFB').style.display="none";
	//document.getElementById('countText').style.display="none";
}

function shareToFB()
{
	document.cookie="finalscore=" + finalscore;
}
	 
</script>

</head>
<body onLoad="hideElements()">

<div id="box" onClick="incrementCount(countText)">
<p id="countText">Score : 0</p>
<!--<p id="hiddenCountText">Score : 0</p>-->
<p id="timer">5 sec</p>
<button id="startButton" onClick="startGame()" onClick="hide">Start</button>
<p id="startText">Click as fast as you can inside the purple box</p>
</div>

<p id="finalScore"></p>
<a href="destroyurmouse.php"><button id="restartButton">Try Again</button></a>
<a href="fbactions.php"><button id="shareFB" onclick="shareToFB()">Share your score on Facebook</button></a>



</body>
</html>

