<?php
/** User
 * Is a class that acts as an intermidiary between the user
 * and the database.
 */
require_once("database.php");

class User extends DB
{
    private static $instance;

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
        $this->store_user_info($username, $firtName, $lastName, $email);
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

    /** update(*)
     * Updates all the information for the given table,
     * it works on updating based on the id of a single user.
     */
    public function update($table, $field, $value, $username)
    {
        $id = $this->get_user_id($username);
        $sql = 'UPDATE '. $table.' SET '.$field.'=? WHERE id='.$id;
        // echo "<br>".$sql."<br>";
        $this->run($sql, array($value));
    }

    /** get_info($table, $username)
     * 
     * This function ,for now, is used to get the information of a
     * specific user from the database.
     * 
     * !• Thought •!
     *  Try to change the way this function works.
     *  Instead of the function getting infomation from the a single table,
     *  make be able to get any amount of data from any table specified.
     */
    public function get_info($table, $username){
        # Get the data id.
        $id = $this->get_user_id($username);
        $sql = "SELECT * FROM ".$table." WHERE id=".$id;
        
        $ret = $this->run_ret($sql);
        return ($ret['results']);
    }

    public function is_image_liked($image_id, $user_id)
    {
        $sql = "SELECT * FROM likes WHERE image_id=? && user_id=?";
        $ret = $this->run_ret($sql, array($image_id, $user_id));

        if ($ret['count'] == 0){
            return FALSE;
        }
        return TRUE;
    }

    public function get_image_id($image_name)
    {
        $sql = "SELECT id FROM posts WHERE image_name=?";
        $ret = $this->run_ret($sql, array($image_name));

        foreach($ret['results'] as $result){
            return $result['id'];
        }
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

    /**like(*)
     * Posts a like to the database.
     */
    public function like($username, $image_name)
    {
        $user_id = $this->get_user_id($username);
        $image_id = $this->get_image_id($image_name);

        if ($this->is_image_liked($image_id, $user_id) === FALSE){
            $sql = 'INSERT INTO likes (image_id, user_id)
            VALUES(?, ?)';
            $this->run($sql, array($image_id, $user_id));
        }
        else{
            $sql = "DELETE FROM likes WHERE user_id=? && image_id=?";
            $this->run($sql, array($user_id, $image_id));
        }
    }

    /** Comment(*)
     * Posts a comment to the database.
     */
    public function comment($username, $image_name, $comment)
    {
        $user_id = $this->get_user_id($username);
        $image_id = $this->get_image_id($image_name);

        $sql = "INSERT INTO comments (user_id, image_id, comment)
        VALUE(?, ?, ?)";
        $this->run($sql, array($user_id, $image_id, $comment));
    }

    /** get_image_user(*)
     * Gets the owner of the image given.
     * 
     * @return: the user_name
     */
    public function get_image_user($image_name)
    {
        $image_id = $this->get_image_id($image_name);
        $sql = "SELECT * FROM posts WHERE id=? limit 1";
        $ret = $this->run_ret($sql, array($image_id));
        $user_id = 1;
        foreach($ret['results'] as $result){
            $user_id = $result['user_id'];
            break;
        }
        $sql = "SELECT username FROM users WHERE id=?";
        $ret = $this->run_ret($sql, array($user_id));

        foreach ($ret['results'] as $result){
            return $result['username'];
        }
    }

    public function get_email_user($user_email)
    {
        $sql = 'SELECT username FROM users where email=?';
        $ret  = $this->run_ret($sql, array($user_email));

        if ($ret['count'] == 0){
            return (NULL);
        }
        
        foreach($ret['results'] as $result){
            return $result['username'];
        }
    }
}
