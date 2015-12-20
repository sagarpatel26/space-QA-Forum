<?php
/**
 * sagarpatel
 * Date: 31-Mar-15
 * Time: 3:12 PM
 */
include_once("../classes/_user.php");
$response = array(
    'valid' => false,
    'message' => 'Post argument "user" is missing.'
);

if( isset($_POST['username']) )
{

    $requesting_username = $_POST['username'];
    $answer = _user::_check_existing_username($requesting_username);
    if( $answer )
    {
        // User name is registered on another account
        $response = array('valid' => false, 'message' => 'This username is already registered.');
    } else
    {
        // User name is available
        $response = array('valid' => true);
    }
}
echo json_encode($response);