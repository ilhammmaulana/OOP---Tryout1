<?php


class Connection
{
    private static $dbname = 'tryout_1_web';
    private static $host = 'localhost';
    private static $username = 'root';
    private static $password = '';
    public static $table_name = '';
    private static $connection;
    private static $sql;
    private static $primary_key = 'id';


    public static function table($name)
    {
        self::$table_name = $name;
        $sqlToGetPrimaryKey = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '" . $name . "'
        AND COLUMN_KEY = 'PRI'";

        try {
            $connection = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
            self::$connection = $connection;
            self::$sql = "SELECT * FROM " . self::$table_name . " ";
            $stmt = $connection->prepare($sqlToGetPrimaryKey);
            $stmt->execute();
            self::$primary_key = $stmt->fetch(PDO::FETCH_ASSOC)['COLUMN_NAME'];

            return new self();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // AHSDJDSAHJK
    public static function get()
    {
        $result = self::$connection->query(self::$sql);
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function where($field, $value)
    {
        self::$sql = self::$sql . " WHERE `$field` = '$value'";
    }
    public function findById($id)
    {
        self::$sql = self::$sql . " WHERE `" . self::$primary_key . "` = '$id'";
        $stmt = self::$connection->prepare(self::$sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function create($data = [])
    {
    }
}