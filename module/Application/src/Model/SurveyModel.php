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

    /**
     * SurveyModel constructor.
     * @param $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     *  Save all survey information
     *
     * @param $survey ARRAY all survey data
     * @return bool did the save work
     * @throws \Exception
     */
    public function save($survey) {
       $surveyId = $this->saveSurveyDetails($survey['survey_name'], $survey['user_id']);
         if (is_int($surveyId) && $surveyId > 0){
             foreach($survey['questions'] as $question) {
                 $options = $question['options'];
                 unset($question['options']);

                 $questionId =  $this->saveQuestionDetails($question, $surveyId);
                 if (is_int($questionId) && $questionId > 0){
                     foreach($options as $option) {
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

    /**
     * Saves the survey details
     *
     * @param $surveyName name of survey
     * @param $userId id of the user that created the survey
     * @return bool/int id of the saved survey or false if the save failed
     */
    public function saveSurveyDetails($surveyName, $userId) {
        $sql = "INSERT INTO `survey` (`name`, `creator`) VALUES (?, ?);";
        $query = $this->pdo->prepare($sql);
        if ($query->execute([$surveyName, $userId])) {
            return (INT)$this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Saves the survey question details
     *
     * @param $questionDetails details of the questions
     * @param $surveyId id of the survey that has been created
     * @return bool/int id of saved question or false if the save failed
     */
    public function saveQuestionDetails($questionDetails, $surveyId) {
        $sql = "INSERT INTO `question` (`text`, `type`, `survey_id`, `required`, `order`) VALUES (:question_text, :question_type, :survey_id, :required, :question_order);";
        $query = $this->pdo->prepare($sql);
        $questionDetails['survey_id'] = $surveyId;

        if ($query->execute($questionDetails)) {
            return (INT)$this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Saves the survey option details
     *
     * @param $displayValue text of the option entered
     * @param $questionId id of the question that the options relates too
     * @return bool if save option worked
     */
    public function saveOptionDetails($displayValue, $questionId ) {
        $sql = "INSERT INTO `option` (`question_id`, `display_value`) VALUES (?, ?);";
        $query = $this->pdo->prepare($sql);
        $optionDetails['question_id'] = $questionId;
        return $query->execute([$questionId, $displayValue]);
    }

    public function getSurvey($surveyId)
    {
        $sql = "SELECT `id`, `name` FROM `survey` WHERE `id` = ?;";
        $query = $this->pdo->prepare($sql);

        if($query->execute([$surveyId]))
        {
            $query->setFetchMode(\PDO::FETCH_ASSOC);
            $survey = $query->fetch();
            $survey['questions'] = $this->getQuestions($surveyId);
            return $survey; //probably
        }
        return false;
    }

    public function getQuestions($surveyId)
    {
        $sql = "SELECT `question`.`id`, `question`.`text`, `question_type`.`type`, `question`.`required`
                FROM `question`
                INNER JOIN `question_type` ON `question`.`type` = `question_type`.`id` 
                WHERE `survey_id` = ?;";
        $query = $this->pdo->prepare($sql);

        if($query->execute([$surveyId]))
        {
            $query->setFetchMode(\PDO::FETCH_ASSOC);
            $questions = $query->fetchAll();

            foreach ($questions as $key => $value)
            {
                if($questions[$key]['type'] != 'text')
                {
                    $questions[$key]['options'] = $this->getOptions($questions[$key]['id']);
                }
            }

            return $questions;
        }
        return false;
    }

    public function getOptions($questionId)
    {
        $sql = "SELECT `id`, `display_value` 
                FROM `option` 
                WHERE `question_id` = ?;";
        $query = $this->pdo->prepare($sql);

        if($query->execute([$questionId]))
        {
            $query->setFetchMode(\PDO::FETCH_ASSOC);
            $options = $query->fetchAll();
            return $options;
        }
        return false;
    }

}

//TODO docblock get functions