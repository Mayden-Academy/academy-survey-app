<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\SurveyModel;

class SurveyController extends AbstractActionController
{
    private $model;

    public function __construct(SurveyModel $model)
    {
        $this->model = $model;
    }

    public function createAction()
    {
        //var_dump($this->params()->fromPost('survey_name')); exit;
        //decode JSON($data) and manipulate to fit the PDO insert
        //validation and return for model
    }
}