<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use Application\Controller\SurveyController;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;


class SurveyControllerTest extends AbstractHttpControllerTestCase
{
    private $goodInput = [
        'survey_name' => 'survey name',
        'questions' => [
            1 => [
                'question_order' => 1,
                'question_text' => 'aaaaaaaaaaaaaaa',
                'question_type' => 'text',
                'required' => '0',
                'options' => [
                    'dummy'
                ]
            ]
        ]
    ];

    public function testValidateDataGood() {

        SurveyController::validateData($this->goodInput);
        $output = SurveyController::validateData($this->goodInput);
        $this->assertTrue($output);
    }

    public function testValidateDataNoSurveyName() {

        $noNameInput = $this->goodInput;
        unset($noNameInput['survey_name']);
        SurveyController::validateData($this->goodInput);
        $output = SurveyController::validateData($this->goodInput);
        $this->assertTrue($output);

    }

    public function testValidateDataNoQuestions() {

        $noNameInput = $this->goodInput;
        unset($noNameInput['questions']);
        SurveyController::validateData($this->goodInput);
        $output = SurveyController::validateData($this->goodInput);
        $this->assertTrue($output);
    }

}





//if (
//    !empty($data['survey_name']) &&
//    !empty($data['questions']) &&
//    is_array($data['questions'])
//) {
//    foreach ($data['questions'] as $question) {
//        if(
//            !empty($question['question_order']) &&
//            !empty($question['question_text']) &&
//            !empty($question['question_type']) &&
//            !empty($question['required']) &&
//            !empty($question['options']) &&
//            is_array($question['options']) &&
//            count($question['options']) > 0