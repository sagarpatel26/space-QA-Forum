<?php
/**
 * sagarpatel
 * Date: 31-Mar-15
 * Time: 12:28 PM
 */
include_once("classes/_user.php");
$login_request = new _user();
$login_request->_map_POST();
$db_user = new _user();
$answer = $db_user->_get_fdb_ref_username($login_request->getUsername());
if ($answer)
{
    if (_user::cipher($login_request->getPassword()) == $db_user->getPassword())
    {
        session_start();
        session_set_cookie_params(30*60,"/",null,true);
        $_SESSION['uid']=$db_user->getUid();
        $_SESSION['username']=$db_user->getUsername();
        $_SESSION['qoffset'] = 0;
        header("Location: ../index.php");
        die();
    }
    else
    {
        setcookie("status","wrongpassword",time()+3,"/");
        header("Location: ../LoginRegistrationForm/login.php");
        die();
    }
}
setcookie("status","register",time()+3,"/");
header("Location: ../LoginRegistrationForm/login.php#toregister");
die();
