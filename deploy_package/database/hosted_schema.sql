
CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(50) NOT NULL,
  username VARCHAR(16) NOT NULL UNIQUE,
  email VARCHAR(254) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  phone CHAR(10) NOT NULL,
  age TINYINT UNSIGNED NOT NULL,
  city VARCHAR(40) NOT NULL,
  vaccination_status ENUM('Not vaccinated','Partially vaccinated','Fully vaccinated','Booster received') NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT chk_users_age CHECK (age BETWEEN 1 AND 120)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS covid_statistics (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  country_name VARCHAR(100) NOT NULL,
  total_cases BIGINT UNSIGNED NOT NULL,
  total_deaths BIGINT UNSIGNED NULL,
  recoveries BIGINT UNSIGNED NULL,
  vaccination_count BIGINT UNSIGNED NULL,
  active_hospitalizations BIGINT UNSIGNED NULL,
  data_source VARCHAR(255) NOT NULL,
  reported_at DATE NULL,
  is_demo_data BOOLEAN NOT NULL DEFAULT TRUE,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_covid_country_reported (country_name, reported_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS vaccination_registrations (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  full_name VARCHAR(50) NOT NULL,
  age TINYINT UNSIGNED NOT NULL,
  city VARCHAR(40) NOT NULL,
  contact_phone CHAR(10) NOT NULL,
  vaccination_status ENUM('Not vaccinated','Partially vaccinated','Fully vaccinated','Booster received') NOT NULL,
  vaccine_or_dose ENUM('Not applicable','Dose 1','Dose 2','Booster') NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_vaccination_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT chk_vaccination_age CHECK (age BETWEEN 1 AND 120),
  KEY idx_vaccination_user_created (user_id, created_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comments (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  comment_text VARCHAR(500) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_comment_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  KEY idx_comments_created (created_at),
  CONSTRAINT chk_comment_not_empty CHECK (CHAR_LENGTH(TRIM(comment_text)) > 0)
) ENGINE=InnoDB;

