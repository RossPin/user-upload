#!/usr/bin/php
<?php
require 'functions.php';
require 'DB.php';
$options = getopt ('u:p:h:', ['file:', 'create_table', 'dry_run', 'help']);
$dry_run = array_key_exists('dry_run',$options);
$create_table = array_key_exists('create_table',$options);
echo "\n";
if (array_key_exists('help',$options)) {
  help();
}
if (!$create_table) $file = $options['file'] ?? trim(readline("Enter filename of CSV to be read:"));
if (!$dry_run) {
  $DB_config = set_DB_config($options);
  if ($DB_config['host'] && $DB_config['username']) $conn = connect($DB_config['host'], $DB_config['username'], $DB_config['password']);
  else die("EXIT: Host and Username must be set to connect to the DB. see --help for details.\n");
}
if ($create_table) {
  create_table($conn);
  $conn->close();
  die("Done\n");
}
if (validate_file($file)) $users = read_csv($file);
$users = format_names($users);
$users= check_emails($users);
if ($dry_run) die("• Dry Run option set, completed without writing to DB\n");
check_users_exists($conn);
insert($users, $conn);
$conn->close();
die("Done\n");
?>