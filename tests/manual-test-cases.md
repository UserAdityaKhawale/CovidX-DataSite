# Functional and manual test cases

Statuses below are intentionally left **NOT RUN** until the app is running in XAMPP.

| ID | Scenario | Preconditions / steps | Expected result | Actual result / status |
|---|---|---|---|---|
| TC-REG-01 | Valid registration | Open Register; enter unique valid fields; submit | Account inserted; password column contains a hash; redirect to login | NOT RUN |
| TC-REG-02 | Duplicate username or email | Register once, then repeat same username or email | Duplicate rejected; no second row | NOT RUN |
| TC-REG-03 | Invalid/empty registration | Omit required field or provide malformed email/phone/age | Field error; database unchanged | NOT RUN |
| TC-LOGIN-01 | Valid login | Register then sign in with correct password | Session regenerated; dashboard opens | NOT RUN |
| TC-LOGIN-02 | Invalid credentials | Submit an incorrect password | Generic rejection without account disclosure | NOT RUN |
| TC-HOME-01 | Dashboard figures | Import demo seed and open Home | Report snapshot shown with undated/demo label | NOT RUN |
| TC-DATA-01 | Country table | Open COVID-19 Data | Seeded India row, unknown death/date shown as unavailable | NOT RUN |
| TC-DATA-02 | Country search | Search `India`, then unmatched term | Matching row shown; unmatched message shown | NOT RUN |
| TC-DATA-03 | Sort cases/deaths | Use both sortable headers | Rows reordered by displayed numeric value | NOT RUN |
| TC-ABOUT-01 | Health information | Open About; inspect sources and helpline | Guidance and linked official sources shown | NOT RUN |
| TC-VAX-01 | Save vaccination record | Sign in; submit valid status form | Record stored under current user; no appointment claimed | NOT RUN |
| TC-VAX-02 | Invalid vaccination record | Submit empty or invalid fields | Errors shown; no row inserted | NOT RUN |
| TC-COMM-01 | Post/view comment | Sign in; post a valid note; refresh | Comment persisted and safely displayed | NOT RUN |
| TC-COMM-02 | Reject unsafe comment | Try empty, >500 char, or `<script>` input | Request rejected; markup cannot execute | NOT RUN |
| TC-SESS-01 | Restrict user tools | Sign out; directly open vaccination/comments | Redirect to login; no protected content cached | NOT RUN |
| TC-SESS-02 | Logout | Sign in; submit Log out; browser Back | Session destroyed; protected response not cached | NOT RUN |
| TC-CSRF-01 | Missing/invalid CSRF | Submit state-changing form without valid token | Request rejected; no database mutation | NOT RUN |
| TC-UI-01 | Responsive/keyboard UI | Resize to mobile; navigate via keyboard | Layout fits; visible focus; logical control order | NOT RUN |
