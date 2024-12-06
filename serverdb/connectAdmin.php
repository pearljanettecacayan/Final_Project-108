<?php

$user = "postgres";
$pass = "12345";

$db = new PDO("pgsql:host=localhost;dbname=shopping", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);