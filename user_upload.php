#!/usr/bin/php
<?php
require 'functions.php';
$options = getopt ('u:p:h:', ['file:', 'create_table', 'dry_run', 'help']);
$file = $options['file'] ?? null;
$host = $options['h'] ?? null;
$username = $options['u'] ?? null;
$password = $options['p'] ?? null;
$dry_run = array_key_exists('dry_run',$options);
if (array_key_exists('help',$options)) {
  help();
}elseif (array_key_exists('create_table',$options)) {
  die("create table\n");
}
if (validate_file($file)) $users = read_csv($file);
$users = format_names($users);
$users= check_emails($users);
if ($dry_run) die("\nDry Run option set, exiting without writing ot the DB\n");
?>