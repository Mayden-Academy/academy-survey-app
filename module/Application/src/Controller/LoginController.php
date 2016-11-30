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

class LoginController extends AbstractActionController
{
    public function loginAction() {
        return new ViewModel();
    }
}