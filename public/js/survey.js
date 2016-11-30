$(function() {

    var questionCount = $('#question-list').children().length //TODO recalculate this when we have an add button
    var $saveBtn = $('#submit-btn')

    $saveBtn.prop("disabled", true)

    $('#survey-name').keyup(function() {
        validateSurvey($('#survey-name').val(), questionCount)
    })

    $saveBtn.click(function() {
        //will call getValues
    })

    function getValues() {
        var survey = {
            "survey_name": $('#survey-name').val(),
            "user_id": 1,
            "questions": [
                {
                "question_text": $('label').val(),
                "question_type": 2,
                "required": "true",
                "options": [
                    "male", "female"
                    ]
                }
        ]}
    }

    function validateSurvey(surveyNameValue, questionCount)
    {
        if(surveyNameValue.length >0 && surveyNameValue.length <= 255 && questionCount > 0)
        {
            $saveBtn.prop("disabled", false)
        }
        else
        {
            $saveBtn.prop("disabled", true)
        }
    }
})


//
// "survey_name" : "Name",
//     "user_id" : 1,
//     "questions" : [
//     {
//         "question_text" : "what is your gender?",
//         "question_type" : 2,
//         "required" : "true",
//         "options" : [
//             "male", "female"
//         ]
//     }...
// ]