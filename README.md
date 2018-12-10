PHP script to parse a csv file of users and add to mySQL database.

##Directives

• --file [csv file name] – the name of the CSV to be parsed
• --create_table – this will cause the MySQL users table to be built (and no further action will be taken)
• --dry_run – this will be used with the --file directive in the instance that we want to run the
script but not insert into the DB. All other functions will be executed, but the database won't
be altered
• -u – MySQL username
• -p – MySQL password
• -h – MySQL host
• --help – will output the above list of directives with details.