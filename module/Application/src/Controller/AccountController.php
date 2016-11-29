<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    private $user;

    public function indexAction()
    {
        if(!empty($_SESSION['userAuth'])) {
            try {
                $this->user->validateToken($_SESSION['userAuth'], $_SESSION['id']);
            } catch (Exception $e) {
                session_destroy();
                $header_str = 'Location: /login';
                header($header_str);
                die();
            }
        } else {
            $header_str = 'Location: /login';
            header($header_str);
            die();
        }
        return new ViewModel();
    }
}