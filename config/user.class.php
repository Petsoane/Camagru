<?php
/** User
 * Is a class that acts as an intermidiary between the user
 * and the database.
 */
require_once("database.class.php");

class User extends DB
{
    private static $instance = null;

    /** construct()
     * Creates a new database connection.
     */
    private function __construct()
    {
        parent::__construct("camagru");
    }

    /** start_connection($dbname)
     * Creates only a single user object.
     */
    public static function start_connection($dbname)
    {
        if (self::$instance == null) {
            #create the database.
            parent::create_database($dbname);
            # Create a new user connection.
            self::$instance = new User();
        }
        return (self::$instance);
    }

    /** check_usr($email, $name);
     * Checks if the username is already taken or not.
     */
    public function check_user($email, $name)
    {
        $errors = array();
        $sql = 'SELECT * FROM users WHERE username=? or email=?';
        $ret = $this->run_ret($sql, array($name, $email));

        if ($ret['count'] > 0) {
            foreach($ret['results'] as $result){
                if ($result['username'] === $name) {
                    array_push($errors, "Username already exists,");
                }
                if ($result['email'] == $email) {
                    array_push($errors, "The email already exists");
                }
            }
        }
        return $errors;
    }

    /** register_user(*)
     * Logs information about a new user.
     */
    public function register_user($username, $firstName, $lastName, $email, $password)
    {
        $password = md5($password);
        $sql = "INSERT INTO users (username, firstName, lastName, email, passwd)
            VALUES(?,?,?,?,?)";
        $this->run($sql, array($username, $firstName, $lastName, $email, $password));
    }

    /** login_user($user, $password)
     * Checks if the user information given at login is in the database.
     * 
     * !* Change !*
     * Change the user login process to tell if the user has logged in or not.
     */
    public function login_user($user, $pass)
    {
        $pass = md5($pass);
        $errors = array();
        $sql = "SELECT * FROM users WHERE username=? && passwd=?";
        $ret = $this->run_ret($sql, array($user, $pass));

        if ($ret['count'] != 1) {
            array_push($errors, "Wrong password/username combo");
        }
        return ($errors);
    }

    /** get_user_id($username)
     * Gets the user id.
     */
    public function get_user_id($usrname)
    {
        $sql = "SELECT id FROM users WHERE username=?";
        $ret = $this->run_ret($sql, array($usrname));

        foreach ($ret['results'] as $result){
            return $result['id'];
        }
    }

    /**add_image(*)
     * Add the image data to the database along with the user id.
     */
    public function add_image($image_name, $username)
    {
        $id = $this->get_user_id($username);
        $sql = 'INSERT INTO posts (user_id, image_name)
            VALUES(?,?)';
        $this->run($sql, array($id, $image_name));
    }

    /** get_posts($username)
     * This functions gets all the post in the post table.
     */
    public function get_posts($username)
    {
        $sql = "SELECT * FROM posts";
        $ret = $this->run_ret($sql, array($username));
        return ($ret['results']);
    }

    /** get_user_post($username)
     * Gets all the posts for a specific user.
     */
    public function get_user_posts($username)
    {
        $id = $this->get_user_id($username);
        $sql = 'SELECT image_name FROM posts WHERE user_id=?';
        $ret = $this->run_ret($sql, array($id));

        return ($ret['results']);
    }

    public function update($table, $field, $value, $username)
    {
        $id = $this->get_user_id($username);
        $sql = "UPDATE ".$table." SET ".$field."=".$value." WHERE id=".$id;
        $this->run($sql);
    }

    /** send_mail(*)
     * Is used to send the email to the specified reciever.
     */
    public function send_mail($to, $message, $subject)
    {
        $header = "From:abc@somedomain.com \r\n";
        $header .= "Cc:afgh@somedomain.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        
        $retval = mail ($to, $subject, $message, $header);
        return ($retval);
    }
}
