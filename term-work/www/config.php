<?php
define('DB_A', '127.0.0.1');
define('DB_U', 'root');
define('DB_P', '');
define('DB_N','www');
define('BASE_URL', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
define('CURRENT_URL', $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']);
