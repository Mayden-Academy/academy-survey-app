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

class SurveyController extends AbstractActionController
{
    /**
     * @var SurveyModel
     */
    private $model;

    /**
     * SurveyController constructor.
     * @param SurveyModel $model
     */
    public function __construct(SurveyModel $model)
    {
        $this->model = $model;
    }

    /**
     * checks to see if the survey has been created
     *
     * @return JsonModel Json saying whether the survey had been successfully created
     */
    public function createAction()
    {
        $data = $this->params()->fromPost();
        if ($this->validateData($data)) {
            // set user_id
            $response = ['success' => $this->model->save($data)];
        } else {
            $response = ['success' => false, 'message' => 'Missing required data'];
        }

        return new JsonModel($response);
    }

    /**
     * Validates whether the correct data hasd been inputted
     *
     * @param $data data that is being inputted
     * @return bool if all data is present or not
     */
    private function validateData($data) {
        if (
            !empty($data['survey_name']) &&
            !empty($data['questions']) &&
            is_array($data['questions'])
        ) {
            foreach ($data['questions'] as $question) {
                if(
                    !empty($question['question_order']) &&
                    !empty($question['question_text']) &&
                    !empty($question['question_type']) &&
                    !empty($question['required']) &&
                    is_array($question['options']) &&
                    count($question['options']) > 0
                ) {
                    continue;
                } else {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

}