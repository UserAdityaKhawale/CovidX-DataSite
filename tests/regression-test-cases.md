# Regression test suite

Run these after any fix to validation, account handling, session behavior, data handling, or persistence. Record the observed result and environment for each execution.

| ID | Workflow | Expected after fix | Status |
|---|---|---|---|
| TC-REGRESSION-01 | Register a new valid user | One account row; hashed password | NOT RUN |
| TC-REGRESSION-02 | Duplicate account attempt | Rejected by unique constraint and handled message | NOT RUN |
| TC-REGRESSION-03 | Login then visit dashboard | Authenticated session available | NOT RUN |
| TC-REGRESSION-04 | Login then open data/about | Public pages load with shared navigation | NOT RUN |
| TC-REGRESSION-05 | Search and sort country data | Search/sort still operate on displayed rows | NOT RUN |
| TC-REGRESSION-06 | Save vaccination record | Current user's record persists after reload | NOT RUN |
| TC-REGRESSION-07 | Post valid comment and refresh | One escaped comment remains visible | NOT RUN |
| TC-REGRESSION-08 | Submit invalid comment | No row inserted; validation shown | NOT RUN |
| TC-REGRESSION-09 | Logout then revisit protected page | Redirect; no cached protected response | NOT RUN |
| TC-REGRESSION-10 | Run `node tests/run-regex-tests.js` | 64 cases report actual PASS/FAIL | NOT RUN |
