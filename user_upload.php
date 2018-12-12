#!/usr/bin/php
<?php
require 'functions.php';
require 'DB.php';
$options = getopt ('u:p:h:', ['file:', 'create_table', 'dry_run', 'help']);
$dry_run = array_key_exists('dry_run',$options);
echo "\n";
if (array_key_exists('help',$options)) {
  help();
}elseif (array_key_exists('create_table',$options)) {
  $DB_config = set_DB_config($options);
  if ($DB_config['host'] && $DB_config['username']) $conn = connect($DB_config['host'], $DB_config['username'], $DB_config['password']);
  else die("EXIT: Host and Username must be set to connect to the DB. see --help for details.\n");
  create_table($conn);
  $conn->close();
  die("Done\n");
}
$file = $options['file'] ?? readline("Enter filename of CSV to be read:");
if (validate_file($file)) $users = read_csv($file);
$users = format_names($users);
$users= check_emails($users);
if ($dry_run) die("•Dry Run option set, completed without writing to DB\n");
$DB_config = set_DB_config($options);
if ($DB_config['host'] && $DB_config['username']) $conn = connect($DB_config['host'], $DB_config['username'], $DB_config['password']);
else die("EXIT: Host and Username must be set to connect to the DB. see --help for details.\n");
check_users_exists($conn);
insert($users, $conn);
$conn->close();
die("Done\n");
?>