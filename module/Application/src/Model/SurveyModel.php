<?php
/**
 * Created by PhpStorm.
 * User: academy
 * Date: 30/11/2016
 * Time: 10:19
 */

namespace Application\Model;


class SurveyModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function save($survey) {
       $surveyId = $this->saveSurveyDetails($survey['survey_name'], $survey['user_id']);

         if (is_int($surveyId) && $surveyId > 0){
             foreach($survey['questions'] as $question) {
                 $questionId =  $this->saveQuestionDetails($question, $surveyId);
                 if (is_int($questionId) && $questionId > 0){
                     foreach($question['options'] as $option) {
                         if(!$this->saveOptionDetails($option, $questionId)) {
                             throw new \Exception('Option save failed');
                         }
                     }
                 } else {
                     throw new \Exception('Question save failed');
                 }
             }
         } else {
             throw new \Exception('Survey save failed');
         }

        return true;
    }

    public function saveSurveyDetails($surveyName, $userId) {
        $sql = "INSERT INTO `survey` (`name`, `creator`) VALUES (?, ?);";
        $query = $this->pdo->prepare($sql);
        if ($query->execute([$surveyName, $userId])) {
            return PDO::lastInsertId();
        }
        return false;
    }

    public function saveQuestionDetails($questionDetails, $surveyId) {
        $sql = "INSERT INTO `question` (`text`, `type`, `survey_id`, `required`, `order`) VALUES (:question_text, :question_type, :survey_id, :required, :question_order);";
        $query = $this->pdo->prepare($sql);
        $questionDetails['survey_id'] = $surveyId;
        if ($query->execute($questionDetails)) {
            return PDO::lastInsertId();
        }
        return false;
    }

    public function saveOptionDetails($displayValue, $questionId ) {
        $sql = "INSERT INTO `option` (question_id`, `display_value`) VALUES (?, ?);";
        $query = $this->pdo->prepare($sql);
        $optionDetails['question_id'] = $questionId;
        return $query->execute([$questionId, $displayValue]);
    }
}