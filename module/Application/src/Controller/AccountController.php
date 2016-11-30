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

        $clean = [];
        if (!empty($_POST['email'])) {
            $clean['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        }
        if (!empty($_POST['password'])) {
            $clean['password']  = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        }

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

}