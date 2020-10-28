<?php namespace AdamLewandowskiRekrutacjaHRtec;

require_once 'XmlToCsvConverter.php';

if (sizeof($argv) !== 4) {
    print 'Invalid number of arguments (3 required => csv:simple/csv:extended URL PATH)';
    return;
}
if ($argv[1] !== 'csv:simple' && $argv[1] !== 'csv:extended') {
    print('Invalid argument #1');
    return;
}
$overrideCsv = $argv[1] === 'csv:simple';

// pasted from https://stackoverflow.com/questions/3809401/what-is-a-good-regular-expression-to-match-a-url/17773849#17773849
$urlRegex = '(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})';

if (!preg_match($urlRegex, $argv[2])) {
    print('Invalid argument #2 (Regex check for url failed)');
    return;
}
$url = $argv[2];

$csvFileRegex = '/^.*\.(csv)$/i';
if (!preg_match($csvFileRegex, $argv[3])) {
    print('Invalid argument #3 (Regex check for .csv extension failed)');
    return;
}
$file = $argv[3];

$converter = new XmlToCsvConverter();
$converter->readXmlFromUrl($url)->extractDataFromXml()->saveDataToCsv($file, $overrideCsv);
print('Application has finished successfully');

