<?php
/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 29/11/2016
 * Time: 12:32
 */

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserAuthenticationController extends AbstractActionController
{
    private $user;
    const ACCOUNT_HEADER = 'Location: /account';
    const LOGIN_HEADER = 'Location: /login';

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function indexAction() {
        if(!empty($_SESSION['userAuth'])) {
            if($this->user->validateToken($_SESSION['userAuth'], $_SESSION['id']))
            {
                header(self::ACCOUNT_HEADER);
                exit;
            }  else {
                session_destroy();
                header(self::LOGIN_HEADER);
                exit;
            }
        } else {
            return new ViewModel();
        }
    }

    public function logoutAction() {
        session_destroy();
        header(self::LOGIN_HEADER);
        exit;
    }
}