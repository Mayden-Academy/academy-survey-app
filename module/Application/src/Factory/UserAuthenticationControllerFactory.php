<?php
/**
 * Created by PhpStorm.
 * User: academy
 * Date: 30/11/2016
 * Time: 11:00
 */

namespace Application\Factory;
use Application\Model\UserModel;
use Application\Controller\UserAuthenticationController;

class UserAuthenticationControllerFactory
{
    public function __invoke($sm) {
        $userModel = $sm->get(UserModel::class);
        return new UserAuthenticationController($userModel);
    }
}