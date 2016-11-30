<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class LogoutController extends AbstractActionController
{
    const LOGIN_HEADER = 'Location: /login';

    public function logoutAction() {
        session_destroy();
        header(self::LOGIN_HEADER);
        exit;
    }
}