<?php
function help(){
  echo "user_upload.php can be used with the following options\n\n";
  echo "• --file [csv file name] – this is the name of the CSV to be parsed\n";
  echo "• --create_table – this will cause the MySQL users table to be built (and no further action will be taken)\n";
  echo "• --dry_run – this will be used with the --file directive to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered\n";
  echo "• -u – MySQL username\n";
  echo "• -p – MySQL password\n";
  echo "• -h – MySQL host\n";
  die("\n");
}

function read_csv($filename){
  $csv_file = fopen($filename, "r");
  $keys = fgetcsv($csv_file );
  $keys = validate_csv_columns($keys);
  $users = [];
  while ($row = fgetcsv($csv_file )) {
    foreach($keys as $i=>$key) {
      $user[$key] = $row[$i];
    }
    $user['line'] = count($users)+2; //record line from CSV for error messages
    array_push($users, $user);
  }
  fclose($csv_file);  
  return $users;
}

function validate_file($filename){
  $info = pathinfo($filename);
  if (!$filename) die("EXIT: No --file option provided, use --help for details\n");
  elseif ($info["extension"] != "csv") die("EXIT: Provided file must be of type CSV.\n");
  elseif (!file_exists($filename)) die("EXIT: File $filename not found.\n");
  else return true; //file valid if script not killed in above tests
}

function validate_csv_columns($keys){
  if ($keys) {
    foreach($keys as $i=>$key){
      $keys[$i] = trim(strtolower($key));
    }
    if (in_array('name', $keys) && in_array('surname', $keys) && in_array('email', $keys)) return $keys;
  }
  die("EXIT: CSV must contain 'name', 'surname' and 'email' columns.\n");
}

function format_names($users){
  return array_map(function($user){
    $user['name'] = format_name($user['name']);
    $user['surname'] = format_name($user['surname']);
    return $user;   
  },$users);
}

function format_name($name){  
  $name = trim(preg_replace("/[^\w'-]+/", "", strtolower($name))); //set to lowercase and remove non alpa characters except for allowed special characters (' and -)
  foreach (["'" , "-"] as $char){
    $words = explode($char, $name); // split name into words divided by special charcter
    foreach ($words as $i=>$word) {
      $words[$i] = ucwords($word); //capitalise words
    }
    $name = implode($char, $words); // join words back into name
  }   
  return $name;
}

function check_emails($users){
  //returns array of users with emails formated and entries with invalid emails removed
  return array_reduce($users, function($acc, $user){
    $user['email'] = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
    if (validate_email($user)) array_push($acc, $user);
    return $acc;
  }, []);
}

function validate_email($user){  
  if (filter_var($user['email'], FILTER_VALIDATE_EMAIL) === false) {
    //output message if invalid email
    echo "• {$user['email']} is not valid email address. User {$user['name']} {$user['surname']} at CSV line {$user['line']} will not be added to DB.\n";
    return false;
  } else return true;
}

function set_DB_config($options){
  return [
  'host' => $options['h'] ?? trim(readline("Enter MySQL host:")),
  'username' => $options['u'] ?? trim(readline("Enter MySQL username:")),
  'password' => $options['p'] ?? trim(readline_hidden("Enter MySQL password:"))
  ];
}

function readline_hidden( $prompt = '' )
{
  echo $prompt;
  echo "\033[30;40m";
  $input = readline();
  echo "\033[0m";
  return $input;
}
?>