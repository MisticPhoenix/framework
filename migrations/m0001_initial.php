<?php


class m0001_initial
{
    public function up(): void
    {
        $db = \App\core\Application::$app->db;
        $SQL = "CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                firstName VARCHAR(255) NOT NULL,
                lastName VARCHAR(255) NOT NULL,
                password VARCHAR(512) NOT NULL,
                status TINYINT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;";
        $db->PDO->exec($SQL);
    }

    public function down()
    {
        $db = \App\core\Application::$app->db;
        $SQL = "DROP TABLE users";
        $db->PDO->exec($SQL);
    }
}