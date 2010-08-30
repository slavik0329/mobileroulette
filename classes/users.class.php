<?
class users
    {
    public $id;

    function getusercount()
    {
        $con= new connection();
        $con->execute("SELECT count(*) as num from users where `time`>(unix_timestamp()-10)");
        $con->fetch();
        return $con->rows['num'];
    }
    function createuser($name, $uuid)
        {
        $con=new connection();
        $con->execute(
            "insert into users (name, uuid,ip, time) values ('$name', '$uuid', '{$_SERVER['REMOTE_ADDR']}', '" . time()
                . "')");
        }
    function changeuser($name, $uuid)
        {
        $con=new connection();
        $con->execute(
            "update users set name='$name' where uuid='$uuid'");
        }
    function getname($userid)
    {
      $con= new connection();
      $con->execute("select name from users where iduser='$userid'") ;
      $con->fetch();
      return $con->rows['name']; 
    }

    function isuser($uuid)
        {
        $con=new connection();
        $con->execute("select * from users where uuid='$uuid'");
        $con->fetch();

        if ($id=$con->rows['iduser'])
            {
            $this->id=$id;
            return $id;
            }
        else
            return false;
        }
        function useralive($userid)
        {
            $con= new connection();
            $con->execute("select time from users where iduser='$userid'");
            $con->fetch();
            $time1=  $con->rows['time'];
            if ($time1<(time()-13))
            return false;
            else
            return true;
        }
    }
?>
