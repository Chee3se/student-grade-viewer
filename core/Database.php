<?php

namespace core;

use PDO;

class Database
{
    private static ?PDO $pdo = null;
    /**
     * @return PDO
     *
     * Creates a new PDO connection if it doesn't exist and returns the connection.
     */
    public static function connect($config): PDO
    {
        if (self::$pdo === null) {
            $dsn = $config['driver'] . ":host=" . $config['host'] . ";dbname=" . $config['database'] . ";charset=" . $config['charset'];
            try {
                self::$pdo = new PDO($dsn, $config['username'], $config['password']);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO('mysql:host=localhost;dbname=your_database_name', 'username', 'password');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
    /**
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     *
     * Prepares and executes a SQL statement with the given parameters.
     */
    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     *
     * Executes a SQL statement and returns the result as an associative array.
     */
    public static function fetchAll(string $sql, array $params = []): array | null
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     *
     * Executes a SQL statement and returns the first row of the result set.
     */
    public static function fetch(string $sql, array $params = []): ?array
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * @param string $sql
     * @param array $params
     * @return bool
     *
     * Executes a SQL statement and returns true if the statement affected one or more rows.
     */
    public static function execute(string $sql, array $params = []): bool
    {
        $stmt = self::query($sql, $params);
        return $stmt->rowCount() > 0;
    }
}