#!/usr/local/bin/php

<html>
<head>
<title>FB test</title>
<?php 

   $app_id = '391755174254167';
   $app_secret = 'b9f7290d664d43cbf90b043095df718d';
   $my_fburl = 'http://www.cise.ufl.edu/~ssardal/fb/fbactions.php';
   $my_url = 'http://www.cise.ufl.edu/~ssardal/fb/destroyurmouse.php';
   //$my_url_post = 'http://www.cise.ufl.edu/~ssardal/fb/linkedindata.php';
?>
</head>
<body>

<?php 

   session_start();
   
   $code = $_REQUEST["code"];

	//print 'code is '.$code;

   if(empty($code)) {
   	$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
   	
   	
   	$dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
   			. $app_id . "&redirect_uri=" . urlencode($my_fburl) . "&state="
   					. $_SESSION['state']."&scope=read_stream,publish_stream";
   
   	
   	echo("<script> top.location.href='" . $dialog_url . "'</script>");
   	
   	}

	if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_fburl)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     //file_get_contents reads the file at the url and returns a string
     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

	$_SESSION['access_token'] = $params['access_token'];

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];

     
     //get user permission to post
     //currently asking at signup, need to figure out a way to prompt in the middle of the flow
     
     // POSTING TO TIMELINE
     $link='http://www.cise.ufl.edu/~ssardal/fb/destroyurmouse.php';
     $picture = 'http://www.cise.ufl.edu/~ssardal/fb/mouse.jpg';
     $appname = urlencode('I scored '.$_COOKIE["finalscore"].' on DestroyUrMouse');
     $appcaption = urlencode('Who\'s got the fastest clicks');
     $appdesc = urlencode('Test your mouse click speed');
          
     /* Feed dialogue */
     $post_url = "https://www.facebook.com/dialog/feed?app_id=". $app_id 
     		. "&redirect_uri=" . urlencode($my_url) 
     		. "&link=" . $link
     		. "&picture=" .$picture
     		. "&name=" .$appname
     		. "&caption=" .$appcaption
     		. "&description=" .$appdesc;
     
     echo("<script> top.location.href='" . $post_url . "'</script>");
     
     
     /* Logout button 
     echo("<br><a href='logout.php'>Click to log out</a>");
     */

   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }   	

 ?>

</body>
</html>