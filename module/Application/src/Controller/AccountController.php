<?php
namespace Application\Controller;

use Application\Model\UserModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    private $userModel;

    /** 
     * AccountController constructor. 
     * 
     * @param UserModel $userModel  An instane of UserModel
     */
    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /** 
     * Controller action for routes: 
     * '/account' (GET only) 
     * 
     * Checks the $_SESSION against the database before loading account/index.phtml 
     * Redirects to '/login' on failure 
     * 
     * @return \Zend\Http\Response\ViewModel 
     */
    public function indexAction()
    {
        if(!empty($_SESSION['userAuth'])) {
            try {
                $this->userModel->validateToken($_SESSION['userAuth'], $_SESSION['id']);
                return new ViewModel();
            } catch (\Exception $e) {
                session_destroy();
                return $this->redirect()->toRoute('login');
            }
        } else {
            return $this->redirect()->toRoute('login');
        }
    }

    /** 
     * Controller action for routes: 
     * '/account' (POST only) 
     * 
     * Tries to login base on data in $_POST['email'] and $_POST['password'] 
     * Redirects to '/account' (GET) on success 
     * Redirects to '/login' on failure 
     * 
     * @return \Zend\Http\Response\ViewModel 
     */
    public function loginAction() {

        try {
            $clean = self::cleanData($this->params()->fromPost());
        } catch (\Exception $e) {
            // TODO Post errrrrrror message to login page and display.
            return $this->redirect()->toRoute('login');
        }

        try {
            if ($this->userModel->login($clean['email'], $clean['password'])) {
                return $this->redirect()->toRoute('account/get');
            } else {
                return $this->redirect()->toRoute('login');
            }
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('login');
        }

    }

    /** 
     * Helper function for $this->loginAction() 
     * Cleans $_POST data from the 'login/index.phtml' form for use in login 
     * 
     * @param $data The $_POST array 
     * 
     * @return array A clean $_POST array 
     * 
     * @throws \Exception 'Missing emxail and password' 
     * @throws \Exception 'Missing email' 
     * @throws \Exception 'Missing password' 
     */
    static public function cleanData($data) {

        $clean = [];

        if(!is_array($data)) {
            throw new \Exception('Incorrect data type, expecting array');
        }

        if(empty($data)) {
            throw new \Exception('$_POST is empty');
        } elseif (empty($data['email']) && empty($data['password'])) {
            throw new \Exception('$_POST is missing email and password');
        }

        if (!empty($data['email'])) {
            $clean['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        } else {
            throw new \Exception('Missing email');
        }

        if (!empty($data['password'])) {
            $clean['password']  = filter_var($data['password'], FILTER_SANITIZE_STRING);
        } else {
            throw new \Exception('Missing password');
        }
        return $clean;
    }
}