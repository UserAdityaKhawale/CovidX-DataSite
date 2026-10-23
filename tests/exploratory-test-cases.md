# Exploratory testing session guide

No exploratory session is claimed as executed in the authoring environment. Perform in XAMPP, record browser/build and actual observations, and create a bug report only for a defect that is observed.

| Session | Exploration | Observe |
|---|---|---|
| EXP-01 | Refresh after registration, comment, and vaccination form submit | Duplicate writes, redirect, preserved state |
| EXP-02 | Use browser Back/Forward after logout and reopen a protected URL in another tab | Session enforcement and cache behavior |
| EXP-03 | Repeat-submit forms rapidly | Duplicate database entries and feedback |
| EXP-04 | Try leading/trailing spaces and prohibited characters | Client/server validation consistency |
| EXP-05 | Search for empty, mixed-case, and absent country strings | Empty search and no-results state |
| EXP-06 | Stop MySQL while opening data and submitting forms | Helpful failure states; no stack traces |
| EXP-07 | Browse at narrow viewport, keyboard-only, and zoomed text | Overflow, focus visibility, logical order |
| EXP-08 | Submit markup-shaped comments | No script execution; encoded output |

For each session capture date, environment, steps, actual behavior, and any associated bug ID.
