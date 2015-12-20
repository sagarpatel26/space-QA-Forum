<?php
/**
 * sagarpatel
 * Date: 03-Apr-15
 * Time: 4:49 PM
 */
session_start();
session_destroy();
header("Location: ../index.php");
die();
