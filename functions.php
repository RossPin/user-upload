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
?>