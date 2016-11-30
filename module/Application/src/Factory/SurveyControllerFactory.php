<?php
/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 29/11/2016
 * Time: 14:02
 */

namespace Application\Factory;

class SurveyControllerFactory
{
    public function __invoke($sm) {
        $model = $sm->get(\Application\Model\SurveyModel::class);
        return new \Application\Controller\SurveyController($model);
    }
}