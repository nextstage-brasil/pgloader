# pgloader
Loader CSV Files into Postgresql Database

## Usage
php pgloader.php -h localhost -u postgres -w 123456 -p 5432 -d my_database -s public -x /path/to/csv_to_import -t false -n tablename

# keys
    'h' => 'Host',
    'u' => 'User',
    'w' => 'Password',
    'p' => 'port',
    'd' => 'Database',
    's' => 'Schema',
    't' => 'Truncate table',
    'x' => 'Path to files',
    'n' => 'Tablename, case not use filename'

As an output, a schema will be created and each CSV file within the directory will be a table. All fields will be of the text type to enable the second stage of data maintenance (done by you ;) )
