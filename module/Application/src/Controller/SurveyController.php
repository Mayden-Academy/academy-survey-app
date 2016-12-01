<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\UserModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\SurveyModel;
use Zend\View\Model\JsonModel;

class SurveyController extends AbstractActionController
{
    /**
     * @var SurveyModel
     */
    private $surveyModel;
    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * SurveyController constructor.
     * @param SurveyModel $surveyModel
     */
    public function __construct(SurveyModel $surveyModel, UserModel $userModel)
    {
        $this->surveyModel = $surveyModel;
        $this->userModel = $userModel;
    }

    /**
     * checks to see if the survey has been created
     *
     * @return JsonModel Json saying whether the survey had been successfully created
     */
    public function createAction()
    {
        $data = $this->params()->fromPost();
        $response = ['success' => false];

        if(!empty($_SESSION['userAuth'])) {
            try {
                $this->userModel->validateToken($_SESSION['userAuth'], $_SESSION['id']);

                if (self::validateData($data)) {
                    $data['user_id'] = $_SESSION['id'];
                    $response = ['success' => $this->surveyModel->save($data)];

                    if($response['success']) {
                        $response['surveyId'] = $this->surveyModel->getSurveyId();
                    }

                } else {
                    $response['message'] = 'Missing required data';
                }
            } catch (\Exception $e) {
                session_destroy();
                $response['message'] = 'Invalid user token';
            }
        } else {
            $response['message'] = 'User not logged in';
        }

        return new JsonModel($response);
    }

    /**
     * Validates whether the correct data has been inputted
     *
     * @param $data data that is being inputted
     * @return bool if all data is present or not
     */
    static public function validateData($data) {
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
                    ($question['required'] != 1 || $question['required'] != 0) &&
                    !empty($question['options']) &&
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