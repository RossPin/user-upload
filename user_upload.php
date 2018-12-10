#!/usr/bin/php
<?php
$options = getopt ("u:p:h:", ["file:", "create_table", "dry_run", "help"]);
$file = $options['file'];
$host = $options['h'];
$username = $options['u'];
$password = $options['p'];
?>