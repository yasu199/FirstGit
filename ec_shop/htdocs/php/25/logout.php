<?php
require_once '../../../include/conf/const.php';
require_once '../../../include/model/model25/common_function.php';
require_once '../../../include/model/model25/ec_function.php';
require_once '../../../include/model/model25/err_check_function.php';
$top = './top.php';
session_start();
session_logout();
header_other_page($top);
?>