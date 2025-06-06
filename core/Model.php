<?php

namespace Core;

class Model extends Database
{
    protected static string $table = '';
    protected static mixed $statement = null;

    public static function init()
    {
        if (!isset(self::$connection)) {
            self::$connection = Database::connect(require_once __DIR__ . '/../config/database.php');
        }
    }

    public function hasMany(Model $model): Model
    {
        self::init();
        $sql = "SELECT * FROM " . static::$table . " INNER JOIN " . $model::$table . " ON " . static::$table . "." . $model::$table . "_id = " . $model::$table . ".id";
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute();
        return new static;
    }

    public function belongsTo(Model $model): Model
    {
        $sql = "SELECT * FROM " . static::$table . " INNER JOIN " . $model::$table . " ON " . static::$table . "." . $model::$table . "_id = " . $model::$table . ".id";
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute();
        return new static;
    }

    public function hasOne(Model $model): Model
    {
        $sql = "SELECT * FROM " . static::$table . " INNER JOIN " . $model::$table . " ON " . static::$table . "." . $model::$table . "_id = " . $model::$table . ".id";
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute();
        return new static;
    }

    public function belongsToMany(Model $model): Model
    {
        $sql = "SELECT * FROM " . static::$table . " INNER JOIN " . $model::$table . " ON " . static::$table . "." . $model::$table . "_id = " . $model::$table . ".id";
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute();
        return new static;
    }
    /**
     * @return Model
     */
    public static function all(): Model
    {
        $sql = "SELECT * FROM " . static::$table;
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute();
        return new static;
    }

    /**
     * @param int $id
     * @return Model
     */
    public static function find(int $id): Model
    {
        self::init();
        $sql = "SELECT * FROM " . static::$table . " WHERE id = :id";
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute(['id' => $id]);
        return new static;
    }
    /**
     * @param array<int,mixed> $data
     */
    public static function create(array $data): self
    {
        self::init();
        $sql = "INSERT INTO " . static::$table . " (";
        foreach ($data as $key => $value) {
            $sql .= $key . ',';
        }
        $sql = substr($sql, 0, -1) . ') VALUES (';
        foreach ($data as $key => $value) {
            $sql .= ':' . $key . ',';
        }
        $sql = substr($sql, 0, -1) . ')';
        $query = self::$connection->prepare($sql);
        $query->execute($data);
        return new static;
    }

    /**
     * @param int $id
     * @param array<int,mixed> $data
     * @return Model
     */
    public static function update(int $id, array $data): Model
    {
        self::init();
        $sql = "UPDATE " . static::$table . " SET ";
        foreach ($data as $key => $value) {
            $sql .= $key . ' = :' . $key . ',';
        }
        $sql = substr($sql, 0, -1) . ' WHERE id = :id';
        $query = self::$connection->prepare($sql);
        $data['id'] = $id;
        $query->execute($data);
        return new static;
    }

    /**
     * @param int $id
     * @return Model
     */
    public static function delete(int $id): Model
    {
        self::init();
        $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute(['id' => $id]);
        return new static;
    }

    /**
     * @param string $key
     * @param string $operator
     * @param string $value
     * @return Model
     */
    public static function where(string $key, string $operator, string $value): Model
    {
        self::init();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . $key . " " . $operator . " :value";
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute(['value' => $value]);
        return new static;
    }

    public static function get()
    {
        return self::$statement->fetch();
    }

    public static function getAll()
    {
        return self::$statement->fetchAll();
    }

    public static function first()
    {
        return self::$statement->fetchColumn();
    }

    /**
     * @param string $table
     * @param string $key
     * @param string $value
     * @return Model
     */
    public static function join(string $table, string $key, string $value): Model
    {
        self::init();
        $sql = "SELECT * FROM " . static::$table . " INNER JOIN " . $table . " ON " . static::$table . "." . $key . " = " . $table . "." . $value;
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute();
        return new static;
    }

    /**
     * @param string $key
     * @return Model
     */
    public static function groupBy(string $key): Model
    {
        self::init();
        $sql = "SELECT * FROM " . static::$table . " GROUP BY " . $key;
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute();
        return new static;
    }

    /**
     * @param string $key
     * @param string $order
     * @return Model
     */
    public static function orderBy(string $key, string $order = 'ASC'): Model
    {
        self::init();
        $sql = static::$table . " ORDER BY " . $key . " " . $order;
        self::$statement = self::$connection->prepare($sql);
        self::$statement->execute();
        return new static;
    }

    public static function count()
    {
        return self::$statement->rowCount();
    }
    /**
     * @return Model
     * @param mixed $query_string
     * @param mixed $params
     */
    public static function execute(mixed $query_string, mixed $params): Model
    {
        self::init();
        $query = self::$connection->prepare($query_string);
        $query->execute($params);
        return new static;
    }
}
