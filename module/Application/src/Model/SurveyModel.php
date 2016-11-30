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
        $this->saveSurveyDetails($survey['survey_name'], $survey['user_id']);
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

    public function saveQuestionDetails() {

    }

    public function saveOptionDetails() {

    }
}