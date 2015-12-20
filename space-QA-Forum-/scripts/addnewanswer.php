<?php
/**
 * sagarpatel
 * Date: 03-Apr-15
 * Time: 3:55 PM
 */
include_once('utils/utils.php');
include_once('classes/_answers.php');
session_start();
if (isset($_POST['ad']) && isset($_POST['qid']) && isset($_SESSION['uid']))
{
    $ad = cleanString($_POST['ad']);
    $qid = $_POST['qid'];
    $uid = $_SESSION['uid'];
    if (strlen($ad)!=0)
    {
        $ans = new _answers();
        $ans->setDescription($ad);
        $ans->setAQid($qid);
        $ans->setAUid($uid);
        if($ans->_insert_db())
            header("Location: ../index.php");
        else
            header("Location: ../index.php");
        die();
    }
    setcookie('fonas',1,time()+3);
    header("Location: ../index.php");
    die();
}
