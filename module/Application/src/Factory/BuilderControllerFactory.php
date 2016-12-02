<?php

namespace Application\Factory;

class BuilderControllerFactory
{
    public function __invoke($sm) {
        $user = $sm->get(\Application\Model\UserModel::class);
        return new \Application\Controller\BuilderController($user);
    }
}