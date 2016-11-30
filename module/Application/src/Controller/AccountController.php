<?php
namespace Application\Controller;

use Application\Model\UserModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\View;

class AccountController extends AbstractActionController
{
    private $userModel;
    const LOGIN_HEADER = 'Location: /login';
    const ACCOUNT_HEADER = 'Location: /account';

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function indexAction()
    {
        if(!empty($_SESSION['userAuth'])) {
            try {
                $this->userModel->validateToken($_SESSION['userAuth'], $_SESSION['id']);
                return new ViewModel();
            } catch (Exception $e) {
                session_destroy();
                header(self::LOGIN_HEADER);
                exit;
            }
        } else {
            header(self::LOGIN_HEADER);
            exit;
        }
    }

    public function loginAction() {

        try {
            $clean = self::cleanData($this->params()->fromPost());
        } catch (\Exception $e) {
            // TODO Post errrrrrror message to login page and display.
            header(self::LOGIN_HEADER);
            exit;
        }

        try {
            if ($this->userModel->login($clean['email'], $clean['password'])) {
                header(self::ACCOUNT_HEADER);
                exit;
            } else {
                header(self::LOGIN_HEADER);
                exit;
            }
        } catch (\Exception $e) {
            header(self::LOGIN_HEADER);
            exit;
        }

    }

    static public function cleanData($data) {

        $clean = [];

        if(empty($data['email']) && empty($data['password'])) {
            if (empty($data)) {
                throw new \Exception('$_POST is empty');
            } else {
                throw new \Exception('$_POST is missing email and password');
            }
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