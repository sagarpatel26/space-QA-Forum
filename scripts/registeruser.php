<?php
/**
 * sagarpatel
 * Date: 31-Mar-15
 * Time: 4:29 PM
 */
include_once("classes/_user.php");
$new_user = new _user();
$new_user->_map_POST();
if ($new_user->_check_form_data()==0)
{
    if ($new_user->_insert_db())
    {
        setcookie("status","successfullyregistered",time()+3,"/");
        header("Location: ../LoginRegistrationForm/login.php");
        die();
    }
}
setcookie("status","clearall",time()+3,"/");
header("Location: ../LoginRegistrationForm/login.php#toregister");
die();