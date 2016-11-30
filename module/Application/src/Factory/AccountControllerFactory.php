<?php

namespace Application\Factory;

use Application\Model\UserModel;
use Application\Controller\AccountController;

class AccountControllerFactory
{
    public function __invoke($sm) {
        $userModel = $sm->get(UserModel::class);
        return new AccountController($userModel);
    }
}