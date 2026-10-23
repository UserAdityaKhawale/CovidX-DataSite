USE covid_db;
-- These values are transcribed from the undated dashboard mock-up embedded in
-- Aditya Miniproject STQA.pdf. They are academic demo values, not live data.
-- Death count and reporting date were not supplied and are intentionally NULL.
INSERT INTO covid_statistics
  (country_name,total_cases,total_deaths,recoveries,vaccination_count,active_hospitalizations,data_source,reported_at,is_demo_data)
VALUES
  ('India',44998520,NULL,44646120,2206750000,1824,'Undated dashboard mock-up in supplied STQA project report',NULL,TRUE)
ON DUPLICATE KEY UPDATE
  total_cases=VALUES(total_cases), total_deaths=VALUES(total_deaths), recoveries=VALUES(recoveries),
  vaccination_count=VALUES(vaccination_count), active_hospitalizations=VALUES(active_hospitalizations),
  data_source=VALUES(data_source), is_demo_data=TRUE;
