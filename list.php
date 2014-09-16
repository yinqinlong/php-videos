<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include_once('config.php');
$db = new db();
$table = 'robber';
$page = max(1, (int)$_GET['page']);
$limit = 10;
$offset = ($page-1) * $limit;
$condition = array();
$videoList = $db->table($table)->getList($condition, $offset, $limit);
$countRecord = $db->table($table)->count($condition);
$totalPages = ceil($countRecord/$limit);
include('view/list.php');
