<?php
/**
 * Created by PhpStorm.
 * User: Jaime
 * Date: 23/04/2016
 * Time: 05:32 PM
 */

setcookie("Francisco","", time() - (86400 * 30), "/");
setcookie("coco","", time() - (86400 * 30), "/");
session_start();
session_destroy();
echo "cookies borradas";
?>