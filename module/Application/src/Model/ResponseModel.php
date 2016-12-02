<?php

namespace Application\Model;


class ResponseModel
{
    /**
     * SurveyModel constructor.
     * @param $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save() {
        return true;
    }
}