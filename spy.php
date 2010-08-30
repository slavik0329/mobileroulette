<?

 include("connection.php");
 include("classes/users.class.php");
 $con= new connection();
 $con->execute("select idchat, user1, user2 from chat where closed<>'Y' and full='Y'");
 while ($con->fetch())
 {
$user=new users();
$names=$user->getname($con->rows['user1'])." - ".$user->getname($con->rows['user2']);
     echo "<a href='spy.php?id={$con->rows['idchat']}'>{$con->rows['idchat']}</a> $names - <a href='chat.php?device=abc2&idchat={$con->rows['idchat']}'>Hop IN</a><br/>";
 }
 
 
 
 if ($_GET['id'])
 
 {
     
     $con->execute("select * from text where idchat='{$_GET['id']}'");
     while ($con->fetch())
     {
         $user= new users();
     $name=$user->getname($con->rows['iduser']);
     echo  "<b>$name</b> - {$con->rows['text']}<br/>";
     }
     
 }
 


?>
