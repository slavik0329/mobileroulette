<?

class chat 
{
    function gettalk($idchat)
    {
      
        
        
    }                   
    function findchat($iduser)
    {
         $con= new connection();
         $con->execute("select idchat from chat where full<>'Y' and closed<>'Y' and user1<>'$iduser' order by rand()");
         $con->fetch();
         
         if ($id=$con->rows['idchat'])
         return $id;
         else
         return false;
    }
    function createchat($iduser)
    {
        $con= new connection();
                $con->execute("update chat set closed='Y' where user1='$iduser' or user2='$iduser'");

        $con->execute("insert into chat (user1, time) values ('$iduser', '".time()."')");
        $id= mysql_insert_id();
        return $id;
    }    
    function joinchat($idchat, $iduser)
    {
        $con= new connection();
          $con->execute("update chat set closed='Y' where user1='$iduser' or user2='$iduser'");
        if ($con->execute("update chat set user2='$iduser' where idchat='$idchat'"))
        $con->execute("update chat set full='Y' where idchat='$idchat'");
    }
    function inchat($iduser)
    {
        $con= new connection();
        $con->execute("select idchat from chat where user1='$iduser' or user2='$iduser'");
        $con->fetch();
        if ($id=$con->rows['iduser'])
        return $id;
        else
        return false;
    }
    function writechat($idchat,$iduser, $text)
    {
        $con = new connection();
        $text= cleantxt($text);
        $con->execute("insert into text (idchat, iduser, text, time, ip) values ('$idchat', '$iduser', '$text', '".time()."', '".$_SERVER['REMOTE_ADDR']."')");
    }
    function chatclosed($idchat)
    {
        $con=new connection();
        $con->execute("select * from chat where idchat='$idchat'");
       $con->fetch();
        if ($con->rows['closed']=='Y')
        return true;
        else
        return false;
    }
    function getchatpartner($idchat, $iduser)
    {
        $con= new connection();
        $con->execute("select * from chat where idchat='$idchat'");
        $con->fetch();
        $user= new users();
         if ($con->rows['user2'])
         {
            if ($iduser==$con->rows['user1'])
         return $user->getname($con->rows['user2']);  
                else
    return $user->getname($con->rows['user1']);     
         }
         else
         return false;        
        
    }
    function getchatpartnerid($idchat, $iduser)
    {
        $con= new connection();
        $con->execute("select * from chat where idchat='$idchat'");
        $con->fetch();
        $user= new users();
         if ($con->rows['user2'])
         {
            if ($iduser==$con->rows['user1'])
         return $con->rows['user2'];  
                else
    return $con->rows['user1'];     
         }
         else
         return false;        
        
    }
    function closeroom($idchat)
    {
        $con= new connection();
        $con->execute("update chat set closed='Y' where idchat='$idchat'");
    }
    
    function closedeadrooms()
    {
        $con= new connection();
        $con->execute("select idchat, user1, user2, full from chat where closed<>'Y'");
        while($con->fetch())
        {
        $user= new users();
        if ($user->useralive($con->rows['user1'])==false)
        $this->closeroom($con->rows['idchat']);
        if ($user->useralive($con->rows['user2'])==false && $con->rows['full']=='Y')
        $this->closeroom($con->rows['idchat']);
        
        }
    }
    
    
}

?>
