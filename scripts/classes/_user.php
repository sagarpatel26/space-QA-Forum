<?php
/**
 * sagarpatel
 * Date: 3/7/2015
 * Time: 8:51 PM
 */

include_once('_database.php');

class _user
{
    private $_uid;
    private $_username;
    private $_firstname;
    private $_lastname;
    private $_password;
    private $_confirmpassword;
    private $_email;

    /**
     * @return null
     */
    public function getConfirmpassword()
    {
        return $this->_confirmpassword;
    }

    /**
     * @param null $confirmpassword
     */
    public function setConfirmpassword($confirmpassword)
    {
        $this->_confirmpassword = $confirmpassword;
    }

    /**
     * @return null
     */
    public function getFirstname()
    {
        return $this->_firstname;
    }

    /**
     * @param null $firstname
     */
    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param null $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return null
     */
    public function getLastname()
    {
        return $this->_lastname;
    }

    /**
     * @param null $lastname
     */
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
    }

    /**
     * @return null
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param null $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return null
     */
    public function getUid()
    {
        return $this->_uid;
    }

    /**
     * @param null $uid
     */
    public function setUid($uid)
    {
        $this->_uid = $uid;
    }

    /**
     * @return null
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param null $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }





    function __construct()
    {
        $this->_uid = null;
        $this->_username = null;
        $this->_firstname = null;
        $this->_lastname = null;
        $this->_password = null;
        $this->_confirmpassword = null;
        $this->_email = null;
    }

    /**
     * for mapping POST array values to object
     */
    function _map_POST()
    {
        if (isset($_POST['username'])) {
            $this->_username = filter_input(INPUT_POST, 'username');
        }
        if (isset($_POST['firstname'])) {
            $this->_firstname = filter_input(INPUT_POST, 'firstname');
        }
        if (isset($_POST['lastname'])) {
            $this->_lastname = filter_input(INPUT_POST, 'lastname');
        }
        if (isset($_POST['password'])) {
            $this->_password = filter_input(INPUT_POST, 'password');
        }
        if (isset($_POST['confirmpassword'])) {
            $this->_confirmpassword = filter_input(INPUT_POST, 'confirmpassword');
        }
        if (isset($_POST['email'])) {
            $this->_email = filter_input(INPUT_POST, 'email');
        }
    }

    /**
     *  _check_form_data()
     *
     *  for checking the duplicates of object values into database
     *  & checks the password matching
     *
     *  returns:
     *  0 -> all correct
     *  1 -> username exist already
     *  2 -> email already exists
     *  3 -> password miss match
     *  4 -> username + email
     *  5 -> request all again
     */
    function _check_form_data()
    {
        $_check_email = _user::_check_existing_email($this->_email);
        $_check_username = _user::_check_existing_username($this->_username);
        $_check_password = ($this->_password == $this->_confirmpassword);

        $c =_database::get_connection();

        echo $this->_username . ' ' . $this->_firstname . ' ' . $c->client_info .' <br /> ';

        if ( !($_check_email) && !($_check_username) && $_check_password)
            return 0;

        if ($_check_email && $_check_username) {
            return 4;
        }

        if ($_check_username) {
            return 1;
        }

        if ($_check_email) {
            return 2;
        }

        if (!$_check_password) {
            return 3;
        }
        return 5;
    }

    /**
     * to check whether the $_ref_username already exists or not ?
     */
    static function _check_existing_username($_ref_username)
    {
        $connection = _database::get_connection();

        $query = "SELECT * FROM `_users` WHERE _username='$_ref_username'";

        $result = $connection->query($query);

        if ($result->num_rows>0) {
            unset($connection);
            return true;
        }
        else {
            unset($connection);
            return false;
        }
    }

    /**
     * to check whether the $_ref_email already exists or not ?
     */
    static function _check_existing_email($_ref_email)
    {
        $connection = _database::get_connection();

        $query = "SELECT * FROM `_users` WHERE _email='$_ref_email'";

        $result = $connection->query($query);

        if ($result->num_rows>0) {
            unset($connection);
            return true;
        }
        else {
            unset($connection);
            return false;
        }
    }

    /**
     * @param $_ref_username
     * return true for success
     * or false
     */
    function _get_fdb_ref_uid($_ref_uid)
    {
        $connection = _database::get_connection();

        $query = "SELECT * FROM `_users` WHERE `_uid`='$_ref_uid'";

        $result = $connection->query($query);

        if ($result->num_rows>0)
        {
            $result_array = $result->fetch_assoc();
            $this->_uid = $result_array['_uid'];
            $this->_firstname = $result_array['_firstname'];
            $this->_lastname = $result_array['_lastname'];
            $this->_email = $result_array['_email'];
            $this->_password = $result_array['_password'];
            $this->_username = $result_array['_username'];
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * @param $_ref_username
     * return true for success
     * or false
     */
    function _get_fdb_ref_username($_ref_username)
    {
        $connection = _database::get_connection();

        $query = "SELECT _uid,_firstname,_lastname,_email,_username,_password FROM `_users` WHERE _username='$_ref_username'";

        $result = $connection->query($query);

        if ($result->num_rows>0)
        {
            $result_array = $result->fetch_assoc();
            $this->_uid = $result_array['_uid'];
            $this->_firstname = $result_array['_firstname'];
            $this->_lastname = $result_array['_lastname'];
            $this->_email = $result_array['_email'];
            $this->_password = $result_array['_password'];
            $this->_username = $result_array['_username'];
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @see used to insert current object into database table _users
     */
    function _insert_db()
    {
        $flag = false;
        if (isset($this->_username) && isset($this->_firstname) && isset($this->_lastname) && isset($this->_email) && isset($this->_password))
        {
            $connection = _database::get_connection();
            $this->_password=_user::cipher($this->_password);
            $insert_users = "INSERT INTO `_users`(`_username`, `_firstname`, `_lastname`, `_email`,`_password`) VALUES ('$this->_username','$this->_firstname','$this->_lastname','$this->_email','$this->_password')";

            if ($connection->query($insert_users) === true) {
                $flag = true;
            }
        }
        return $flag;
    }

    static function _verify_password($_username,$_check_password)
    {
        $connection = _database::get_connection();

        $query = "SELECT `_password` FROM `_users` WHERE _username='$_username'";

        $result = $connection->query($query);

        if($result->num_rows>0)
        {
            $result_array = $result->fetch_assoc();
            $_temp_password = $result_array['_password'];

            if ($_temp_password == _user::cipher($_check_password))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        return false;
    }

    static function cipher($string)
    {
        return md5($string);
    }
}
