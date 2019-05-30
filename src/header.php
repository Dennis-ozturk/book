<?php
ob_start();
session_start();
include_once 'db/db.php';
include_once 'classes/user.inc.php';
include_once 'classes/api.inc.php';
$user = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<?php require_once('login.php'); ?>