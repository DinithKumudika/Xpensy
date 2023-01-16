<?php

declare(strict_types = 1);

function getTransactionFiles(string $dir_path): array
{
     $files = [];

     foreach(scandir($dir_path) as $file){
          if(is_dir($file)){
               continue;
          }
          $files[] = $dir_path . $file;
     }

     return $files;
}

function getTransactions(string $file_name, ?callable $transaction_handler =  null): array 
{
     if(!file_exists($file_name)){
          trigger_error('File "' . $file_name . '"does not exist.', E_USER_ERROR);
     }

     $file = fopen($file_name, "r");

     fgetcsv($file);

     $transactions = [];

     while(($transaction = fgetcsv($file)) !== false){
          if($transaction_handler != null){
               $transaction = $transaction_handler($transaction);
          }
          $transactions [] = $transaction;
     }

     return $transactions;
}

function readTransaction(array $transaction): array{
     $date = $transaction[0];
     $checkNo = $transaction[1];
     $description = $transaction[2];
     $amount = $transaction[3];

     $amount = (float) str_replace(['$', ','], '', $amount);

     return [
          'date' => $date,
          'checkNo' => $checkNo,
          'description' => $description,
          'amount' => $amount
     ];
}

function getTotals(array $transactions): array
{
     $totals = [
          'netTotal' => 0,
          'totalIncome' => 0,
          'totalExpense' => 0
     ];

     foreach($transactions as $transaction){
          $totals['netTotal'] = $transaction['amount'];

          if($transaction['amount'] >= 0){
               $totals['totalIncome'] += $transaction['amount'];
          }
          else{
               $totals['totalExpense'] += $transaction['amount']; 
          }
     }

     return $totals;
}