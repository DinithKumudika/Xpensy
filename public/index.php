<?php

declare(strict_types = 1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('BASE_ROOT', $root);
define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'data' . DIRECTORY_SEPARATOR . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' .DIRECTORY_SEPARATOR);

require APP_PATH . 'App.php';

// get all the transaction files
$files = getTransactionFiles(FILES_PATH); 

$transactions = [];

foreach($files as $file){
     $transactions = array_merge($transactions, getTransactions($file, 'readTransaction'));
}

$totals = getTotals($transactions);

require VIEWS_PATH . 'transactions.php';





