<?php
namespace Application\Controller;

use Application\Model\UserModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    private $userModel;

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
                return $this->redirect()->toRoute('login',
                    ['controller'=>UserAuthenticationController::class,
                        'action' => 'index',
                        'params' =>'hello']);
            }
        } else {
            return $this->redirect()->toRoute('login',
                ['controller'=>UserAuthenticationController::class,
                    'action' => 'index',
                    'params' =>'hello']);
        }
    }

    public function loginAction() {

        try {
            $clean = self::cleanData($this->params()->fromPost());
        } catch (\Exception $e) {
            // TODO Post errrrrrror message to login page and display.
            return $this->redirect()->toRoute('login',
                ['controller'=>UserAuthenticationController::class,
                    'action' => 'index',
                    'params' =>'hello']);
        }

        try {
            if ($this->userModel->login($clean['email'], $clean['password'])) {
                return $this->redirect()->toRoute('account',
                    ['controller'=>AccountController::class,
                        'action' => 'index',
                        'params' =>'hello']);
            } else {
                return $this->redirect()->toRoute('login',
                    ['controller'=>UserAuthenticationController::class,
                        'action' => 'index',
                        'params' =>'hello']);
            }
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('login',
                ['controller'=>UserAuthenticationController::class,
                    'action' => 'index',
                    'params' =>'hello']);
        }

    }

    static public function cleanData($data) {

        $clean = [];

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