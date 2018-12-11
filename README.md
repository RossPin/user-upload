PHP script to parse a csv file of users and add to mySQL database.

PHP MySQL extensions required, this can be installed on ubuntu with:
    apt-get install php-mysql

CSV file must contain columns of: name, surname and email. columns can be in any order but must be labeled on the first row.
Data will be saved into a dedicated MySQL database named 'user_upload' in 'users' table. If 'user_upload' DB does not exist on the MySQL server it will be created on connection.
MySQL server credentials must be supplied via -h, -u and -p directives for connection to MySQL.
'users' table can be created/reset with --create_table. 

##Directives

• --file [csv file name] – the name of the CSV to be parsed
• --create_table – this will cause the MySQL users table to be built (and no further action will be taken)
• --dry_run – this will be used with the --file directive to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered
• -u – MySQL username
• -p – MySQL password
• -h – MySQL host
• --help – will output the above list of directives with details.