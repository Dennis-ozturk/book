<?php
session_start();
require_once('db/db.php');
require_once('classes/user.inc.php');
require_once('classes/api.inc.php');
require_once('classes/customer.inc.php');
require_once('classes/transactions.inc.php');
require_once('vendor/stripe/stripe-php/init.php');
$api = new Api;

$apiData = $api->getApiData();
// output headers so that the file is downloaded rather than displayed
$column = array();
foreach ($apiData['results'] as $list) {
    foreach ($list as $key => $value) {
        $column[] = $key;
    }
}

$uniqueColumn = array_unique($column);

header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="demo.csv"');

// // do not cache the file
header('Pragma: no-cache');
header('Expires: 0');

// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');

// send the column headers
fputcsv($file, $uniqueColumn);

$data = array();
$isbnNumbers = array();
$search = array();
$newFilter = [];
$listOfBooks = [];

foreach ($apiData['results'] as $list) {
    $data[] = $list;
}

// for($i = 0; $i < sizeof($data); $i++){
//     echo $data[$i]['ISBN'] . ',';
//     echo '<br>';
// }


$row = 1;
if (($handle = fopen("books/file.csv", "r")) !== FALSE) {
    while (($data2 = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data2);
        $row++;
        for ($c = 0; $c < $num; $c++) {
            $search[] = $data2[$c];
        }
    }
    fclose($handle);
}

$filterEmptyElements = (array_filter($search, function ($value) {
    return $value !== '';
}));


foreach ($filterEmptyElements as $key => $value) {
    $newFilter[] = $value;
}

// var_dump($newFilter);

foreach ($newFilter as $key => $value) {
    $listOfBooks[] = $api->isbn($value);
}

$smaller = [];

for ($i = 0; $i < sizeof($listOfBooks); $i++) {
    fputcsv($file, $listOfBooks[$i]['results'][0]);
}

// // Closing file
fclose($file);
