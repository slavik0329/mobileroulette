<?
include("connection.php");
include("classes/users.class.php");
include("classes/chat.class.php");


$chat= new chat();

if ($_POST['txt'])
$chat->writechat($_REQUEST['chatid'],$_POST['user'],$_POST['txt']);

?>
