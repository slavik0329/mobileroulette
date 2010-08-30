<?
include("connection.php");
include("classes/users.class.php");
include("classes/chat.class.php");
  
  
 
$user= new users();
if (!$user->isuser($_REQUEST['device']))
{
header("location: newuser.php?device=".$_REQUEST['device']);
exit();
}

$con= new connection();
$con->execute("update users set time='" . time() . "' where iduser='{$user->id}'");       

$chat= new chat();
$chat->closedeadrooms();


if(!$chatid=$_GET['idchat'])
{
if ($chatid=$chat->findchat($user->id))
{
    //echo "found chat";
    $chat->joinchat($chatid,$user->id);

}else{
$chatid=$chat->createchat($user->id);
//echo "created chat";
}
//echo $chatid;
}


$count=$user->getusercount();
?>   
<meta name = "viewport" content = "width=device-width, minimum-scale=1, maximum-scale=1 "> 
<link rel="stylesheet" type="text/css" href="style.css" />

<script src="js/jquery.js"></script>   

<div id="chattext"></div>
<form onsubmit="return sendtext();">
<input type="text" id="txt" placeholder="Write a message..." style="width:248px;"><input type="submit"  value="Send">
</form>
    <br/>
    
    <a href="chat.php?device=<? echo $_GET['device'];?>">Next Chat Partner!</a>
    <p/>
    <a href="changename.php?device=<? echo $_GET['device'];?>">Change User Name</a>
    <p/>
<div id="news" style="width:305px; padding:2px;">
Make sure to tell your friends about Roulette Chat!
</div>    
<script>
        function sendtext()
        {
            var text=document.getElementById("txt").value;
            $.ajax({  type: "POST",url: "writechat.php",  data: "txt="+text+"&user=<? echo $user->id;?>&chatid=<? echo $chatid;?>",  cache: false
            
             , success: function(html){
    document.getElementById("txt").value="";
    document.getElementById("txt").focus();
    
  }
            
            }); 
        return false;
        }       
         function gettext()
        {
            
           
            $.ajax({  type: "POST",url: "talk.php",  data: "idchat=<? echo $chatid;?>&iduser=<? echo $user->id;?>",  cache: false
            
             , success: function(html){
$("#chattext").html(html);
    
  }
            
            }); 
        }
         gettext();
         setInterval("gettext()",2000);

</script>


<div style="height:300px;"></div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7871572-8");
pageTracker._trackPageview();
} catch(err) {}</script>
