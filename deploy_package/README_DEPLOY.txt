# Co-Shield deployment package

1. Create/sign in to a free PHP/MySQL hosting account and create a free subdomain.
2. In its MySQL Databases panel, create a database. Copy the exact host, database name, username, and password shown there.
3. Open that database in phpMyAdmin. Import `database/hosted_schema.sql`, then `database/hosted_seed.sql` into the same created database.
4. In the file manager, open the site's `htdocs` directory and upload/extract this package so `index.php` is directly inside `htdocs`.
5. In `htdocs/config`, copy `database.local.php.example` to `database.local.php`. Edit the copy and enter the four database values from step 2. Do not share that file or its password.
6. Open the assigned HTTPS URL. Register using fictional details only; this academic demo stores names, phone numbers, ages, vaccination status, and comments.

The dashboard figures are an undated snapshot from the supplied STQA report, not current statistics. The hosted SQL omits CREATE DATABASE/USE so it can be imported into a database whose name is assigned by the host.
