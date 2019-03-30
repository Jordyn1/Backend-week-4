use epiz_23680553_movie_tracker;

CREATE TABLE works (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    artistname VARCHAR (20) NOT NULL,
    worktitle VARCHAR (50) NOT NULL,
    workdate VARCHAR (30),
    worktype VARCHAR (30),
    date TIMESTAMP
);

use epiz_23680553_movie_tracker;

CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(50) NOT NULL,
 `password` varchar(255) NOT NULL,
 `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`)
 ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8
    );