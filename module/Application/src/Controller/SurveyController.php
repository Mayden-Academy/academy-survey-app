<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\SurveyModel;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class SurveyController extends AbstractActionController
{
    private $model;

    public function __construct(SurveyModel $model)
    {
        $this->model = $model;
    }

    public function indexAction()
    {
        $view = new viewModel();

        //TODO get survey info from db in try catch
        //TODO place in variables to use in view

        return $view;
    }

    public function createAction()
    {
        $response = ['success' => $this->model->save($this->params()->fromPost())];
        return new JsonModel($response);
    }
}