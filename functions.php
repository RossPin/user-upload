<?php
function help(){
  echo "user_upload.php can be used with the following options\n\n";
  echo "• --file [csv file name] – this is the name of the CSV to be parsed\n";
  echo "• --create_table – this will cause the MySQL users table to be built (and no further action will be taken)\n";
  echo "• --dry_run – this will be used with the --file directive in the instance that we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered\n";
  echo "• -u – MySQL username\n";
  echo "• -p – MySQL password\n";
  echo "• -h – MySQL host\n";
  die("\n");
}

function read_csv($filename){
  $csv_file = fopen($filename, "r");
  $keys = fgetcsv($csv_file );
  while ($row = fgetcsv($csv_file )) {
      echo "$row[0], $row[1], $row[2]\n";
  }
  fclose($csv_file);
}

function validate_file($filename){
  $info = pathinfo($filename);
  if (!$filename) die("No --file option provided, use --help for details\n");
  elseif ($info["extension"] != "csv") die("Provided file must be of type CSV.\n");
  elseif (!file_exists($filename)) die("File $filename not found.\n");
  else return true; //file valid if script not killed in above tests
}
?>