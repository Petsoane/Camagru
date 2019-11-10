<?php
/**
 * This class is used to handle all the functions that take
 * care of all the database information.
 */

class DB
{
    # Properties.
    protected $username;
    protected $password;
    protected $dbname;
    protected $host;
    protected $pdo;
    protected $dsn;

    # Create a constructor that is only accessed by it's
    # Childern
    protected function __construct($dbname)
    {
        $this->username = 'root';
        $this->password = 'theophylus';
        $this->dbname = $dbname;
        $this->host = 'localhost';
        $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $this->pdo = new PDO($this->dsn, $this->username, $this->password);
        $this->pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /** create_databse($dbname)
     *  is used to create a database even when the object is not created.
     */
    public static function create_database($dbname = 'camagru')
    {
        $sql = "CREATE DATABASE IF NOT EXISTS`$dbname`";
        $pdo = new PDO("mysql:host=localhost", 'root', 'theophylus');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec($sql);
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute([$dbname]);
        // echo "<br><br>The databse is creates successfully<br><br>";
        self::create_tables($dbname);
        $pdo = null;
    }

    /** create_tables($dbname)
     * Creates the tables need for the start of the site.
     */
    public static function create_tables($dbname)
    {
        $sql_users = "CREATE TABLE IF NOT EXISTS users(
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username varchar(255) NOT NULL,
                firstName varchar(255) NOT NULL,
                lastName varchar(255) NOT NULL,
                email varchar(100) NOT NULL,
                passwd varchar(255) NOT NULL,
                verified INT(6) NOT NULL DEFAULT '0'
            )";
        $sql_posts = "CREATE TABLE IF NOT EXISTS posts(
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT UNSIGNED NOT NULL,
                image_name varchar(255) NOT NULL
            )";
        $sql_likes = "CREATE TABLE IF NOT EXISTS likes(
                image_id INT UNSIGNED NOT NULL,
                user_id INT UNSIGNED NOT NULL
            )";
        $sql_comments = "CREATE TABLE IF NOT EXISTS comments(
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT UNSIGNED NOT NULL,
                image_id INT UNSIGNED NOT NULL,
                comment varchar(255)
            )";

        $pdo = new PDO("mysql:host=localhost;dbname=" . $dbname, 'root', 'theophylus');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $pdo = new PDO("mysql:host=localhost;dbname=" . $dbname, 'root', 'theophylus');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare($sql_users);
            $stmt->execute();
            $stmt = $pdo->prepare($sql_posts);
            $stmt->execute();
            $stmt = $pdo->prepare($sql_likes);
            $stmt->execute();
            $stmt = $pdo->prepare($sql_comments);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "There was an error creating the tables," . $e->getMessage();
            die("Fatal");
        }
        $pdo = null;
    }

    public function run_ret($sql, $params = null)
    {
        $count = -1;
        $values = null;

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            $count = $stmt->rowCount();
            $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return array('count' => $count, 'results' => $values);
        } catch (PDOException $e) {
            echo "There was an error in database.run_ret() <br> " . $e->getMessage();
            die("<br>fatal");
        }
    }

    public function run($sql, $params = null)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

        } catch (PDOException $e) {
            echo "There was an error in database.run() <br> " . $e->getMessage();
            die("<br>fatal");
        }
    }
}
