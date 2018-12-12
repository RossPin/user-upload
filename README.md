## Details

PHP script to parse a csv file of users and add to mySQL database.

PHP MySQL extensions required, this can be installed on ubuntu with:
    apt-get install php-mysql

Script is run by executing user_uploads.php.
functions.php and DB.php contain functions that are required by user_uploads.php.

CSV file must contain columns of: name, surname and email. columns can be in any order but must be labeled on the first row.

CSV file name can be provided by via --file directive.

Data will be saved into a dedicated MySQL database named 'user_upload' in 'users' table. If 'user_upload' DB does not exist on the MySQL server it will be created on connection.

MySQL server credentials can be provided via -h, -u and -p directives for connection to MySQL.
'users' table can be created/reset with --create_table.

User will be prompted to provide File and MySQL credentials if required and not set by directives.

## Directives

 --file [csv file name] – the name of the CSV to be parsed.
 --create_table – this will cause the MySQL users table to be built (and no further action will be taken).
 --dry_run – this will be used with the --file directive to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered.
 -u – MySQL username.
 -p – MySQL password.
 -h – MySQL host.
 --help – will output the above list of directives with details.
