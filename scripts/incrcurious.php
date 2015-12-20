<?php
/**
 * sagarpatel
 * Date: 03-Apr-15
 * Time: 11:01 AM
 */
include_once('classes/_questions.php');
session_start();
if (isset($_POST['qid']) )//&& isset($_SESSION['uid']))
{
    $aid = $_POST['qid'];
    $uid = $_SESSION['uid'];
    $q = _question::_chng_curious($aid,$uid);
    if ($q!=null)
        echo $q->getCurious();
    else
        echo 'err';
}
else
{
    echo 'err';
}