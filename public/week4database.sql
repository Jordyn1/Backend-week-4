CREATE DATABASE jordyn_week4;

use jordyn_week4;

CREATE TABLE works (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    artistname VARCHAR (20) NOT NULL,
    worktitle VARCHAR (50) NOT NULL,
    workdate VARCHAR (30),
    worktype VARCHAR (30),
    date TIMESTAMP
)