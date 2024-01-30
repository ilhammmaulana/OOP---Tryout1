<?php

require_once 'Connection.php';


$data = Connection::table('students')->get();
$first = Connection::table('students')->findById('20092309');
var_dump($data);
echo "<br/>";
var_dump($first);