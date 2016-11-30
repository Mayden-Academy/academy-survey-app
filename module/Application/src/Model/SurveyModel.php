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

        foreach($survey['questions'] as $question) {
            $this->saveQuestionDetails($question, $surveyId);
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

    public function saveOptionDetails() {

    }
}