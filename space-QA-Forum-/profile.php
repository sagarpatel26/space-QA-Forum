<?php
include_once('scripts/classes/_user.php');
    if(!isset($_GET['username'])){
        header("Location: ../error.php?1");
        die();
    }
    $user = new _user();
    if (!$user->_get_fdb_ref_username($_GET['username'])){
        echo $_GET['username'];
        header("Location: ../error.php?2");
        die();
    }
    $user->setPassword('');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Space</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/space.profile.tmpl.css">

</head>
<body>


<nav id="my-nav-bar">
    <ul class="nav-bar-ul">
        <li class="nav-bar-li" id="logo">
            <img src="img-small.png" width="160" height="60" style="margin: -5px 0 -5px 65%;">
        </li>
        <li class="nav-bar-li" id="search-bar">
            <form>
                <input type="search" id="search-form" size="40" placeholder=" looking for something ?" />
            </form>
        </li>
		<a href="index.php">home</a>			
        <a href="scripts/logout.php" style="margin:20px 0 0 20%;padding-top:20px;">logout</a>
    </ul>
</nav>
<div id="initial-offseter">
    <br /><br /><br />
</div>

<div class="profile-block">

    <div class="profile">
        <span class="profile-description" ><span class="space" id="owner">@ <?php echo $user->getUsername();?>'s</span></span>
    </div>
    <br>

    <div class="prof-description">
        <span id="owner_name">Name: <?php echo $user->getFirstname() . ' ' . $user->getLastname()?></span>
    </div>
    <div class="prof-description">
        <span id="owner_email">E-mail: <?php echo $user->getEmail()?> </span>
    </div>


</div>

</body>
</html>
