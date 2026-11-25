-- LEMP Project: Database Schema
-- No credentials or passwords are stored in this file.

CREATE DATABASE IF NOT EXISTS example_database;

USE example_database;

CREATE TABLE IF NOT EXISTS todo_list (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    content VARCHAR(255) NOT NULL
);
