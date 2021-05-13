<?php

require __DIR__ . '/vendor/autoload.php';

$chaves = [
    'h' => 'Host',
    'u' => 'User',
    'w' => 'Password',
    'p' => 'port',
    'd' => 'Database',
    's' => 'Schema',
    't' => 'Truncate table',
    'x' => 'Path to files',
    'n' => 'Tablename, case not use filename'
];

$default = [
    'h' => 'localhost',
    'u' => 'postgres',
    'w' => '',
    'p' => '5432',
    'd' => 'postgres',
    's' => 'public',
    't' => 'false',
    'x' => '~/$HOME',
    'n' => 'false'
];

// Documentação
$help = ["Loader to Postgresql by Nextstage Brasil. Params: "];
$help[] = "Usage: \n\tphp pgloader.php -h localhost -u postgres -w 123456 -p 5432 -d my_database -s public -x /dados/csv_to_import -t false -n tablename";
//$help[] = "\tphp pgloader.php --help";
//$help[] = "\tphp pgloader.php --version";
$help[] = "Options: ";

$options = [];
foreach ($chaves as $key => $val) {
    $help[] = "\t-$key\t" . $val . ". Default: '" . $default[$key] . "'";
    $options[$key] = "$key:";
}
$help [] = '';
//var_export($options);
$args = getopt(implode('', $options));
//var_export($args);
// pegar parametros mantendo o default
$data = (object) array_replace($default, $args);
$data->t = isset($data->t) ? true : false;
//var_export($data);

if (!is_dir($data->x)) {
    echo "\nERROR: Directory not found. " . $data->x . PHP_EOL;
    echo implode("\n", $help);
    die();
}

ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL & ~E_NOTICE);

// conexão
try {
    $con = new \NsUtil\ConnectionPostgreSQL($data->h, $data->u, $data->w, $data->p, $data->d);
    $pgloader = new NsUtil\PgLoadCSV($con, $data->s, false, $data->t);
} catch (Exception $exc) {
    echo "\nERROR: " . $exc->getMessage();
    die();
}
echo PHP_EOL;

// somente se diretorio existir
$table = (($data->n != 'false') ? $data->n : false);
$pgloader->run(realpath($data->x), $table);

