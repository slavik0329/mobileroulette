

<?
include ("connection.php");

include ("classes/users.class.php");
include ("classes/chat.class.php");
$user=new users();
$chat=new chat();
$count=$user->getusercount();     
if (!$chat->chatclosed($_REQUEST['idchat']))
    {
    if ($partner=$chat->getchatpartner($_REQUEST['idchat'], $_REQUEST['iduser']))
        echo "<b>Chatting with $partner</b>";
    else
        echo "<b>Waiting for chat partner</b>";
    }
else
    echo "<b>Partner has left the chat</b>";

echo " - $count Users Online!";    
$con=new connection();
$con->execute("select * from text where idchat='" . $_REQUEST['idchat'] . "' ");
$count=$con->numRows();
/*
if ($count > 12)
    $start=$count - 12;
else
    $start=0;
*/
$con->execute("select * from text where idchat='" . $_REQUEST['idchat'] . "'");

while ($con->fetch())
    {
    $name = $user->getname($con->rows['iduser']);
    $txt=stripslashes($con->rows['text']);
    echo "<div style='margin:2px; padding:5px; width:290px; color:#333333; font-size:11px; font-family:\"lucida grande\",tahoma,verdana,arial,sans-serif; background-color:#ECEFF5; '><span style='font-weight:bold;color:#3B5998; text-transform:capitalize; margin-right:3px;'>$name</span>  {$txt}</div>";
    }
    if ($chat->chatclosed($_REQUEST['idchat']) )
        echo "<div style='margin:2px; padding:5px; width:290px; color:#333333; font-size:11px; font-family:\"lucida grande\",tahoma,verdana,arial,sans-serif; background-color:#ECEFF5; '><span style='font-weight:bold;color:#3B5998; text-transform:capitalize; margin-right:3px;'></span> Your partner has left the chat</div>";

    
     $con->execute("update users set time='" . time() . "' where iduser='{$_POST['iduser']}'");       
if (!$chat->chatclosed($_REQUEST['idchat']) && $chat->getchatpartnerid($_POST['idchat'], $_POST['iduser']))
    {

    $timeout=time() - 10;
    $con->execute(
        "select time from users where iduser='" . $chat->getchatpartnerid($_POST['idchat'], $_POST['iduser']) . "'");
    $con->fetch();

    if ($con->rows['time'])
        {
        if ($con->rows['time'] < $timeout)
            $chat->closeroom($_POST['idchat']);
        }
    }
    


    
?>     


