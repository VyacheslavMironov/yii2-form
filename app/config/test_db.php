<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'pgsql:host=localhost;dbname=user_info_test';
$db['username'] = 'raptor7117';
$db['password'] = 'lama2022';
$db['charset'] = 'utf8';

return $db;
