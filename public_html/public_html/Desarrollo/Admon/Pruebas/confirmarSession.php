<?php
/**
 * Created by PhpStorm.
 * User: Jaime
 * Date: 23/04/2016
 * Time: 05:56 PM
 */
session_start();
//echo("{$_SESSION['username']}");
print_r($_SESSION);
print_r(scandir(session_save_path()));
?>