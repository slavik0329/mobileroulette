<?
include ("connection.php");

include ("classes/users.class.php");
  
if ($_POST['user'])
    {
    $con =new connection();
    $name=cleantxt($_POST['user']);

    $user=new users();

    if ($user->isuser($_POST['device']))
        {
        $user->changeuser($name, $_POST['device']);
        }

    header ("Location: chat.php?device={$_POST['device']}");
    }
?>

<html>
    <head>
        <meta name = "viewport" content = "width=device-width, minimum-scale=1, maximum-scale=1 ">
    </head>

    <body style = "">
        <h2><font color="#333333">Change Username</font></h2>

        <meta name = "viewport" content = "width=device-width">
        <form method = "post">
            <font color="#333333">Please Enter a new Username (1-20 Characters)</font>

            <br/>

            <input type = "text" name = "user"> <input type = "submit" onclick = "this.value='Creating...';">
            <input name = "device" type = "hidden" value = "<? echo $_GET['device']; ?>">
            <input name = "ver" type = "hidden" value = "<? echo $_GET['ver']; ?>">
        </form>
    </body>
</html>