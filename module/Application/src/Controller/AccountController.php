<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function postAction()
    {
        die('postAction');
        return new ViewModel();
    }
}