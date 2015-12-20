<?php
/**
 * sagarpatel
 * Date: 3/7/2015
 * Time: 11:11 PM
 */

include_once('project_config.php');
include_once('_error_handler.php');

class _database
{
    static private $_connection;

    static function get_connection()
    {
        if (!self::$_connection) {
            self::$_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if (self::$_connection->error) {
                echo '<h1> hi </h1>';
                error_log(self::$_connection->error);
                _error_handler::go_to_errorpage();
            }
        }
        return self::$_connection;
    }
} 