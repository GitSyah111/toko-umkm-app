# Database Reset Workflow

## Objective
To reset the database, run migrations and seeders, and verify the successful creation and seeding of tables by reporting their record counts.

## Steps for the Agent

1. **Reset Database and Run Seeders:**
   - Run the command: `php artisan migrate:fresh --seed`
   - Wait for the command to finish executing. Ensure it completes without errors.

2. **Verify and Count Records:**
   - Execute the following command to retrieve the list of all tables and their respective record counts:
     ```bash
     php artisan tinker --execute="\$tables = array_map('current', DB::select('SHOW TABLES')); foreach(\$tables as \$table) { echo \$table . ': ' . DB::table(\$table)->count() . ' records\n'; }"
     ```

3. **Report Results:**
   - Present the list of tables along with their record counts to the user.
   - Confirm whether the tables have been successfully created and populated as expected.
