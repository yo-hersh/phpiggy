-- CREATE TABLE IF NOT EXISTS `users`(
--     `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     `email` VARCHAR(255) NOT NULL,
--     `password` VARCHAR(255) NOT NULL,
--     `age` TINYINT UNSIGNED NOT NULL,
--     `country` VARCHAR(255) NOT NULL,
--     `social_media_url` VARCHAR(255) NOT NULL,
--     `created_at` DATETIME NOT NULL,
--     `updated_at` DATETIME NOT NULL
-- );
-- ALTER TABLE
--     `users` ADD UNIQUE `users_email_unique`(`email`);
-- CREATE TABLE IF NOT EXISTS `transactions`(
--     `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     `description` VARCHAR(255) NOT NULL,
--     `amount` DECIMAL(8, 2) NOT NULL,
--     `date` DATETIME NOT NULL,
--     `created_at` DATETIME NOT NULL,
--     `updated_at` DATETIME NOT NULL,
--     `user_id` BIGINT UNSIGNED NOT NULL,
--     FOREIGN KEY(`user_id`) REFERENCES users(`id`)
-- );
CREATE TABLE IF NOT EXISTS users(
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    age TINYINT(3) UNSIGNED NOT NULL,
    country VARCHAR(255) NOT NULL,
    social_media_url VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL default CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY(email)
);
CREATE TABLE IF NOT EXISTS transactions(
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NULL,
    amount DECIMAL(10, 2) NOT NULL,
    date DATETIME NOT NULL,
    created_at DATETIME NOT NULL default CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_id BIGINT(20) UNSIGNED NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id)
);