<?php
namespace Application\Model;

class UserModel {

    private $id;
    private $email;
    private $pdo;

    /**
     * sets class variables
     *
     * @param PDO $pdo database connection
     */
    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    private function validateEmail($email) {

        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate e-mail
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception('not a valid email address');
        }

        return true;
    }

    /**
     * sets the session data and adds random validation string to database
     *
     * @param STRING $email email to check against database
     * @param STRING $password password to check against database
     */
    function login($email, $password) {

        if($this->validateEmail($email) && $this->validateDetails($email, $password)) {
            $token = sha1(time());

            //set all data used to validate / display
            $_SESSION['userAuth'] = $token;
            $_SESSION['id'] = $this->id;
            $_SESSION['email'] = $email;

            $sql = "UPDATE `user` SET `validation_string` = :token WHERE `id` = " . $this->id . ";";
            $query = $this->pdo->prepare($sql);
            return $query->execute([':token'=>$token]);
        } else {
            throw new \Exception('Invalid Login');
        }
    }

    /**
     * validates user login details:
     * if email and password match database then sets $loggedIn to TRUE
     *
     * @param STRING $email user email
     * @param STRING $password user password
     *
     * @return BOOLEAN returns if login is successful
     *
     * @throws Exception
     */
    public function validateDetails($email, $password){

        if(!$this->validateEmail($email)) {
            throw new \Exception("not valid email");
        }

        $sql = "SELECT * FROM `user` WHERE `email` = :email;";
        $query = $this->pdo->prepare($sql);
        $query->execute([':email'=>$email]);
        $user = $query->fetch(\PDO::FETCH_ASSOC);

        if(empty($user)) {
            throw new \Exception("user does not exist");
        }

        $encryptPass = $user['salt'] . $password;
        $encryptPass = sha1($encryptPass);

        if($user['password'] != $encryptPass) {
            throw new \Exception("incorrect email and password combination");
        } else {
            $this->setUserDetails($user);
            return true;
        }
    }

    /**
     * validates that the session data matches up with the data in the database
     *
     * @param STRING $token validation string to check against database
     * @param STRING $id id of user to check validation string against
     *
     * @throws \Exception
     */
    public function validateToken($token, $id) {
//        $sql = "SELECT `user`.*, `permissions`.`canCreateUser` FROM `user` LEFT JOIN  `permissions` ON `user`.`id`=`permissions`.`userId` WHERE `id` = :id;";
        $sql = "SELECT * FROM `user` WHERE `id` = :id;";
        $query = $this->pdo->prepare($sql);
        $query->execute([':id' => $id]);
        $user = $query->fetch(\PDO::FETCH_ASSOC);

        if ($token != $user['validation_string']) {
            throw new \Exception('error validating user');
        }

        $this->id = $id;
        return $this->setUserDetails($user);
    }

    public function setUserDetails($user){
        //set details
        if(is_array($user)) {
            if (!empty($user['id']) && !empty($user['email'])) {
                return ($this->id = $user['id'] && $this->email = $user['email']);
            }
            return false;
        }
        throw new \Exception('incorrect data type passed, array is required');
    }
}