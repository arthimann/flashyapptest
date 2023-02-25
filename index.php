<?php

require_once 'vendor/autoload.php';

use Src\Database\Db;

$db = Db::getInstance();

// Example of retrieve all data
$db->from('users')->select();

// Example of selecting exists record specific columns
$db->from('users')->where('username', 'gala')->select('username', 'foo');

// Example of update exists record
$db->set('users')->where('username', 'gal')->update('username', 'foo');

// Example of inserting a new record
$db->into('users')->insert(['username' => 'john', 'age' => 25]);

// Example of deleting method
$db->from('users')->where('username', 'gal')->delete();
