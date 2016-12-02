<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use \Application\Controller\SurveyController;
use \PHPUnit\Framework\TestCase;
include __DIR__ . '/../../../../vendor/autoload.php';

class SurveyControllerTest extends TestCase
{
    private $goodInput = [
        'survey_name' => 'survey name',
        'questions' => [
            0 => [
                'question_order' => 1,
                'question_text' => 'aaaaaaaaaaaaaaa',
                'question_type' => 'text',
                'required' => '1',
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

    public function testValidateDataNoSurveyName()
    {
        $modifiedInput = $this->goodInput;
        unset($modifiedInput['survey_name']);
        SurveyController::validateData($modifiedInput);
        $output = SurveyController::validateData($modifiedInput);
        $this->assertFalse($output);
    }

    public function testValidateDataNoQuestions()
    {
        $modifiedInput = $this->goodInput;
        unset($modifiedInput['questions']);
        SurveyController::validateData($modifiedInput);
        $output = SurveyController::validateData($modifiedInput);
        $this->assertFalse($output);
    }

    public function testValidateDataNoQuestionOrder()
    {
        $modifiedInput = $this->goodInput;
        unset($modifiedInput['questions'][0]['question_order']);
        SurveyController::validateData($modifiedInput);
        $output = SurveyController::validateData($modifiedInput);
        $this->assertFalse($output);
    }

    public function testValidateDataNoQuestionText()
    {
        $modifiedInput = $this->goodInput;
        unset($modifiedInput['questions'][0]['question_text']);
        SurveyController::validateData($modifiedInput);
        $output = SurveyController::validateData($modifiedInput);
        $this->assertFalse($output);
    }

    public function testValidateDataNoQuestionType()
    {
        $modifiedInput = $this->goodInput;
        unset($modifiedInput['questions'][0]['question_type']);
        SurveyController::validateData($modifiedInput);
        $output = SurveyController::validateData($modifiedInput);
        $this->assertFalse($output);
    }

    public function testValidateDataNoQuestionRequired()
    {
        $modifiedInput = $this->goodInput;
        unset($modifiedInput['questions'][0]['required']);
        SurveyController::validateData($modifiedInput);
        $output = SurveyController::validateData($modifiedInput);
        $this->assertFalse($output);
    }

    public function testValidateDataNoQuestionOptions()
    {
        $modifiedInput = $this->goodInput;
        unset($modifiedInput['questions'][0]['options']);
        SurveyController::validateData($modifiedInput);
        $output = SurveyController::validateData($modifiedInput);
        $this->assertFalse($output);
    }

}