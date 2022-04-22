Setup your database and run `composer install` and `php artisan migrate`.

The main import command expects a file called example_stock.csv to be in the storage/app/public/csv folder.

Manually create a csv folder in storage/app/public and add the example_stock.csv for the purpose of the demo.

Once in place this can then be imported into the database using the command `php artisan stoneacre:import-cars-csv`.

This command also takes one argument which would be to supply a different filename of a csv in the storage/app/public/csv folder.

To export cars run the `php artisan stoneacre:export-cars-csv` command.

With no arguments this command will export Ford cars or you can pass the make of another car as a single argument instead.

To test run `php artisan test`.

The env.example has the default mailer set to log and configuration values for FTP.
