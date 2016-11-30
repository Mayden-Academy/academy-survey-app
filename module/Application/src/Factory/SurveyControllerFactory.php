<?php

namespace Application\Factory;

use \Application\Controller\SurveyController;

class SurveyControllerFactory
{
    public function __invoke($sm) {
        $surveyModel = $sm->get(\Application\Model\SurveyModel::class);
        return new SurveyController($surveyModel);
    }
}