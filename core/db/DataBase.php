<?php

namespace App\core\db;

use App\core\Application;
use PDO;

class DataBase
{
    public PDO $PDO;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        try {
            $this->PDO = new PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function applyMigrations(): void
    {
        $this->createMigrations();
        $appliedMigrations = $this->getApplyMigrations();

        $newMigrations = [];
        $files = scandir(Application::getROOT_DIR() . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::getROOT_DIR() . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            echo "Applying migration $migration" . PHP_EOL;
            $instance->up();
            echo "\nApplied migration $migration" . PHP_EOL;
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied");
        }
    }

    private function createMigrations(): void
    {
        $this->PDO->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;");
    }

    private function getApplyMigrations(): false|array
    {
        $statement = $this->PDO->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function prepare($sql): false|\PDOStatement
    {
        return $this->PDO->prepare($sql);
    }

    private function saveMigrations(array $migrations): void
    {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->PDO->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    private function log($message): void
    {
        echo '[' . date('Y-m-d H:i:s') . ']' . $message . PHP_EOL;
    }
}