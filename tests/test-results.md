# Test execution record

## Environment observed during implementation

- Windows workspace: `D:\Covid 19 Site`
- XAMPP installed at `C:\xampp`: PHP 8.4.27, Apache 2.4.65, MariaDB 10.11.
- Project served from `C:\xampp\htdocs\covid-information-website` at `http://127.0.0.1/covid-information-website/`.
- Schema and report-labeled seed data imported into `covid_db`.

## Automated regex suites

- JavaScript: **64 cases; 64 passed; 0 failed** against `assets/js/validation.js`.
- PHP: **64 cases; 64 passed; 0 failed** using XAMPP PHP 8.4.27 and `tests/regex-test.php`.
- PHP syntax: all application and test PHP files checked with `php -l`; no syntax errors found.

## Local HTTP and workflow smoke checks

`tests/run-xampp-smoke.ps1` ran against the local Apache/MariaDB instance. **16 checks passed; 0 failed.** Coverage included registration and login, session ID rotation, report snapshot rendering, data page unknown-value handling, vaccination save and reload, rejected script-tag comment input, valid comment save and reload, logout, and redirect from a protected page after logout. The generated test account was deleted after the run.

Public page checks also returned HTTP 200 for the dashboard, data, about, login, and registration pages. Signed-out requests for vaccination and comments correctly redirected to login.

## Remaining manual checks

- Review responsive layout at desktop and phone widths, keyboard navigation, and screen-reader labels.
- Exercise duplicate registration and invalid login scenarios manually.
- Confirm the local server and database remain running when you want to use the site. Local URL is not public internet hosting.
