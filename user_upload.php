#!/usr/bin/php
<?php
$options = getopt ('u:p:h:', ['file:', 'create_table', 'dry_run', 'help']);
$file = $options['file'] ?? null;
$host = $options['h'] ?? null;
$username = $options['u'] ?? null;
$password = $options['p'] ?? null;
if (array_key_exists('help',$options)) {
  die("help\n");
}
if (array_key_exists('dry_run',$options)) {
  die("dry run\n");
}
if (array_key_exists('create_table',$options)) {
  die("create table\n");
}
?>