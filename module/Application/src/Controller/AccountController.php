<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    private $user;

    public function indexAction()
    {
        die(var_dump($this->user));
        return new ViewModel();
    }
}