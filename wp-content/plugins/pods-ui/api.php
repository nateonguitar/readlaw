<?php
ob_start();
require_once(realpath('../../../wp-load.php'));
ob_end_clean();

// Sanitize input
foreach ($_POST as $key => $val) {
    $params[$key] = mysql_real_escape_string(stripslashes(trim($val)));
}

/*
==================================================
Actions: Reorder
// to eventually be added to api.php in Pods itself
==================================================
*/
if ('save_reorder' == $params['action'] && pods_access('pod_'.$params['dt']))
{
    $api = new PodAPI();
    $api->reorder_pod_item(array('datatype'=>$params['dt'],'order'=>$params['order'],'field'=>$params['field']));
    echo 'Success ;)';
}