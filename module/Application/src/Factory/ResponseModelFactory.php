<?php
/**
 * Created by PhpStorm.
 * User: academy
 * Date: 02/12/2016
 * Time: 10:03
 */

namespace Application\Factory;

use \Application\Model\ResponseModel;

class SurveyResponseFactory
{
    public function __invoke($sm)
    {
        $pdo = $sm->get('pdo');
        return new ResponseModel($pdo);
    }
}