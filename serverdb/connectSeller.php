<?php

$user = "seller";
$pass = "dyanna";

$db = new PDO("pgsql:host=localhost;dbname=shopping", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);