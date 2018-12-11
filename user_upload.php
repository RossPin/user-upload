#!/usr/bin/php
<?php
require 'functions.php';
require 'DB.php';
$options = getopt ('u:p:h:', ['file:', 'create_table', 'dry_run', 'help']);
$file = $options['file'] ?? null;
$host = $options['h'] ?? null;
$username = $options['u'] ?? null;
$password = $options['p'] ?? null;
$dry_run = array_key_exists('dry_run',$options);
echo "\n";
if (array_key_exists('help',$options)) {
  help();
}elseif (array_key_exists('create_table',$options)) {
  if ($host && $username) $conn = connect($host, $username, $password);
  else die("EXIT: Host and Username must be set with -h -u. see --help for details.\n");
  create_table($conn);
  $conn->close();
  die("Done\n");
}
if (validate_file($file)) $users = read_csv($file);
$users = format_names($users);
$users= check_emails($users);
if ($dry_run) die("•Dry Run option set, completed without writing to DB\n");
if ($host && $username) $conn = connect($host, $username, $password);
else die("EXIT: Host and Username must be set with -h -u. see --help for details.\n");
check_users_exists($conn);
insert($users, $conn);
$conn->close();
die("Done\n");
?>