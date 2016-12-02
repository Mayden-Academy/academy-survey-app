<?php

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\UserModel;

class UserAuthenticationController extends AbstractActionController
{
    private $userModel;

    /**
     * UserAuthenticationController constructor.
     *
     * @param UserModel $userModel An instance of UserModel
     */
    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Controller action for routes:
     * '/'
     * '/login'
     *
     * Checks current user in session against the database
     * Redirects to '/account/get' on success
     * Redirects to '/login' on failure
     *
     * @return \Zend\Http\Response\ViewModel
     */
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

    /**
     * Controller action for routes:
     * '/logout'
     *
     * Destroys the session
     * Redirects to '/login'
     *
     * @return \Zend\Http\Response\ViewModel
     */
    public function logoutAction() {
        session_destroy();
        return $this->redirect()->toRoute('login');
    }
}