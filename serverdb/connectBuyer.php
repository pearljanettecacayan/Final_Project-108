<?php

$user = "buyer";
$pass = "pearl";

$db = new PDO("pgsql:host=localhost;dbname=shopping", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);