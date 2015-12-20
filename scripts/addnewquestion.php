<?php
include_once("classes/_user.php");
include_once("classes/_questions.php");
include_once("classes/_answers.php");
session_start();

if (!isset($_SESSION['uid']))
{
    header('Location: LoginRegistrationForm/login.php');
    die("user not logged in");
}
else
{
    if (isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
    }
    if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }
    if (isset($_SESSION['qoffset'])){
        $qoffset = $_SESSION['qoffset'];
    }
    $qdes = $_POST['qd'];
    if (strlen($qdes)==0) {
        header("Location: ../index.php");
        setcookie("zero",1,time()+3,"/");
        die();
    }
    $newq = new _question();
    $newq->setDescription($qdes);
    $newq->setQUid($uid);
    if ($newq->_insert_db())
        header("Location: ../index.php");
    else
        header("Location: ../error.php");
    die();
}
