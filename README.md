
 <img width="2972" height="1726" alt="image" src="https://github.com/user-attachments/assets/89f24ad6-31d9-4717-843c-3675bdbb7343" />

 
 # COVID-19 Information Website

An academic STQA mini-project implementation using PHP 8.2+, MySQL/MariaDB, HTML, CSS and vanilla JavaScript. The website includes registration, login, a dashboard, country data, COVID-19 information, vaccination status records and a comments area.

## Current implementation status

- PHP pages, shared templates, server-side validation, CSRF checks, session handling and SQL schema are implemented.
- The report's India dashboard figures are included as **undated academic demonstration data**. They are never described as current/live statistics. The report does not supply a deaths count or reporting date, so those values are left unavailable.
- Vaccination records are saved to the local demonstration database. The form does not book an appointment or contact a provider.
- The 64 regex cases are executable against the browser-side JavaScript validation rules. Run them with `node tests/run-regex-tests.js`.
- Installed locally with XAMPP under `C:\xampp`; Apache and MariaDB are running, the schema and seed are imported, and the site is available at `http://127.0.0.1/covid-information-website/`.

## Requirements

- XAMPP with Apache, MySQL/MariaDB and PHP 8.2 or later.
- PHP extensions: PDO MySQL, mbstring, and standard session support.
- Node.js (only to run the JavaScript regex validation suite).

## Run locally with XAMPP

1. Copy this folder into XAMPP's `htdocs`, for example `C:\xampp\htdocs\covid-information-website`.
2. Open XAMPP Control Panel and start **Apache** and **MySQL**.
3. In phpMyAdmin, import `database/database.sql` first, then import `database/seed_demo_data.sql`. This creates `covid_db` and inserts the report-labeled India demonstration snapshot.
4. The default local connection is `127.0.0.1`, database `covid_db`, username `root`, and an empty password (common XAMPP defaults). For a non-default local setup, set `COVID_DB_HOST`, `COVID_DB_NAME`, `COVID_DB_USER`, and `COVID_DB_PASS` in Apache's environment. Never commit real credentials.
5. Open `http://127.0.0.1/covid-information-website/` in a browser. Do not open PHP pages with `file://`.
6. Create a demonstration account, sign in, save a vaccination status record, and post a comment. Use fictional personal details for demonstrations.

## Online demo deployment

`covid-site-upload.zip` is a ready-to-upload package for a PHP/MySQL shared host. It includes schema and seed SQL adapted for hosts that assign database names, plus a `database.local.php.example` template for credentials. Follow `README_DEPLOY.txt` inside the ZIP. The credentials file is protected by `config/.htaccess` and is not included with real secrets.

Use fictional profile and vaccination details on the public demo; it stores those values in its database.
## Data and sources

The STQA report's embedded dashboard mock-up shows 44,998,520 reported cases, 1,824 active hospitalizations, 44,646,120 discharged and 2,206,750,000 administered doses for India. It contains no reporting date and no death count. These values are therefore seeded only as an undated mock-up snapshot with `is_demo_data = TRUE`; they must not be used as present-day statistics. The data page preserves unknown death and date values as unavailable.

The About page links to the [WHO COVID-19 fact sheet](https://www.who.int/news-room/fact-sheets/detail/coronavirus-disease-%28covid-19%29), the [WHO COVID-19 questions and answers](https://www.who.int/news-room/questions-and-answers/item/coronavirus-disease-covid-19), and the [India MoHFW COVID-19 portal](https://covid19dashboard.mohfw.gov.in/). The published national query helpline is shown as 1075; check the Ministry portal for current availability and scope. Health information is educational, not a substitute for professional advice.

## Testing

Run `node tests/run-regex-tests.js` to execute all 64 cases (eight each for name, username, email, password, phone, age, city and comment) against the JavaScript rules actually used by the forms. The runner reports each case's expected value, observed value and status. It exits non-zero if a case fails or the count differs from 64.

The corresponding PHP rules are in `includes/validation.php`; client-side validation is for quick feedback only. In XAMPP, all 64 PHP regex cases pass, all PHP files pass syntax checks, and `tests/run-xampp-smoke.ps1` exercises registration through logout against the local database. See `tests/test-results.md` for the executed scope and remaining manual checks.

## Security and limitations

- PDO prepared statements are used for application queries. Passwords use `password_hash()` and `password_verify()`.
- PHP validation is authoritative; CSRF tokens protect forms that change state. Session IDs rotate after login, and protected pages use no-store cache headers.
- User content is escaped using `htmlspecialchars()` before rendering. HTML tags in comments are also rejected as an additional validation rule.
- This project is an academic local demonstration. It is not a clinical service, appointment system, live statistics service, or security-certified product.
- Live statistics fetching is intentionally not required. To present current figures, load a reputable, dated official data extract and record its source, period, and limitations.

## Project tree

```text
index.php                     Dashboard
login.php / register.php     Authentication
data.php / about.php         Country data and health information
vaccination.php              Authenticated vaccination status record
comments.php / logout.php    Authenticated comments and POST logout
config/database.php          Shared PDO connection
includes/                    Bootstrap, templates, auth, CSRF, validation
assets/css/style.css         Responsive dark-mode design
assets/js/validation.js      Client-side validation
database/database.sql        Schema for covid_db
database/seed_demo_data.sql  Clearly labeled report snapshot
tests/                       Regex cases, runner, and STQA records
```

## Troubleshooting

- **Database connection message:** confirm MySQL is running, `covid_db` was imported, and the `COVID_DB_*` connection settings match your local XAMPP setup.
- **Blank page or PHP error:** enable PHP error logging in the local XAMPP configuration and inspect Apache's `logs/error.log`; do not expose stack traces on a public server.
- **Missing CSS:** open the project through the localhost URL above and confirm `assets/css/style.css` is present.
- **Login says credentials are invalid:** register an account through the site first. No demo account or plaintext password is seeded.
- **No country data:** import `seed_demo_data.sql` after `database.sql`. Only India is in the supplied report mock-up, so the initial demonstration table contains one row.

