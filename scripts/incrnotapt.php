<?php
/**
 * sagarpatel
 * Date: 03-Apr-15
 * Time: 11:01 AM
 */
include_once('classes/_answers.php');
session_start();
if (isset($_POST['aid']) )//&& isset($_SESSION['uid']))
{
    $aid = $_POST['aid'];
    $uid = $_SESSION['uid'];
    $ans = _answers::_chng_notapt($aid,$uid);
    if ($ans!=null)
        echo $ans->getNotApt();
    else
        echo 'err';
}
else
{
    echo 'err';
}