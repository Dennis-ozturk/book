<?php
$apiData = $api->getApiData();

// Lägger till i headern i filen så den laddas ner senare
$column = array();
foreach ($apiData['results'] as $list) {
    foreach ($list as $key => $value) {
        $column[] = $key;
    }
}

//Hämtar uniqa columner från api datan
$uniqueColumn = array_unique($column);

//Vilken typ det är som ska laddas ner
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename=' . $_SESSION['filename']);

// cachar inte filen
header('Pragma: no-cache');
header('Expires: 0');

// Skapar en pointer till filen
$file = fopen('php://output', 'w');

// Skickar kolumnen till headern
fputcsv($file, $uniqueColumn);

$data = array();
$isbnNumbers = array();
$search = array();
$newFilter = [];
$listOfBooks = [];

foreach ($apiData['results'] as $list) {
    $data[] = $list;
}
$check = true;
$checks = preg_match('/\b(\.csv)\b/', $_SESSION['filename'], $output);
empty($output) ? $check = false : '';

if ($check) {
    $file_id = $_SESSION['filename'];
    $path = realpath('./') . '/books/' . $file_id;

    move_uploaded_file($file_id, "$path");
}

$filename = "books/" . $file_id;

//För varje isbn nummer i filen så ska den läsa det och lägga det till i listan $search
$row = 1;
if (($handle = fopen($_SESSION['filename'], "r")) !== FALSE) {
    while (($data2 = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data2);
        $row++;
        for ($c = 0; $c < $num; $c++) {
            $search[] = $data2[$c];
        }
    }
    fclose($handle);
}

//Tar bort tomma elements i listan om det finns
$filterEmptyElements = (array_filter($search, function ($value) {
    return $value !== '';
}));

//Om det fanns tomma elements så skapar vi en ny lista med den rena listan
foreach ($filterEmptyElements as $key => $value) {
    $newFilter[] = $value;
}

//Lägger till varje information genom att kalla på varje isbn nummer för sig
foreach ($newFilter as $key => $value) {
    $listOfBooks[] = $api->isbn($value);
}

//Lägger till i filen
for ($i = 0; $i < sizeof($listOfBooks); $i++) {
    fputcsv($file, $listOfBooks[$i]['results'][0]);
}

// // Stänger filen
fclose($file);

//header('Location: success.php?tid=' . $_SESSION['charge_id'] . '&product=' . $_SESSION['charge_description']);
