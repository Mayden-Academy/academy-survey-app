<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\View;

class AccountController extends AbstractActionController
{
    private $user;
    const LOGIN_HEADER = 'Location: /login';
    const ACCOUNT_HEADER = 'Location: /account';

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function indexAction()
    {
        if(!empty($_SESSION['userAuth'])) {
            try {
                $this->user->validateToken($_SESSION['userAuth'], $_SESSION['id']);
                return new ViewModel();
            } catch (Exception $e) {
                session_destroy();
                header(self::LOGIN_HEADER);
                exit;
            }
        } else {
            $header_str = 'Location: /login';
            header(self::LOGIN_HEADER);
            exit;
        }
    }

    public function postAction() {

        $clean = self::cleanData($this->params()->fromPost());

        try {
            if ($this->user->login($clean['email'], $clean['password'])) {
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