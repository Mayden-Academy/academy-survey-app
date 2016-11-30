<?php

namespace Application\Factory;

use \Application\Controller\BuilderController;

class BuilderControllerFactory
{
    public function __invoke($sm) {
        $userModel = $sm->get(\Application\Model\UserModel::class);
        return new BuilderController($userModel);
    }
}