<?php
/**
 * sagarpatel
 * Date: 3/7/2015
 * Time: 11:22 PM
 */

include_once('project_config.php');

class _error_handler
{
    static function go_to_errorpage()
    {
        //header('Location:'.ROOT.DS.'public'.DS.ERRORPAGE);
        header('Location: '.ERRORPAGE);
        die();
    }
} 