<?php

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserAuthenticationController extends AbstractActionController
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function indexAction() {
        if(!empty($_SESSION['userAuth'])) {
            if($this->userModel->validateToken($_SESSION['userAuth'], $_SESSION['id']))
            {
                return $this->redirect()->toRoute('account/get',
                    ['controller'=>AccountController::class,
                        'action' => 'index',
                    ]);
            }  else {
                session_destroy();
                return new ViewModel();
            }
        } else {
            return new ViewModel();
        }
    }

    public function logoutAction() {
        session_destroy();
        return $this->redirect()->toRoute('login',
            ['controller'=>UserAuthenticationController::class,
                'action' => 'index',
                'params' =>'hello']);
    }
}