$(function() {

    var questionCount = $('#question-container').children().length //TODO recalculate this when we have an add button
    var $saveBtn = $('#submit-btn')

    // $saveBtn.prop("disabled", true)

    // $('#survey-name').keyup(function() {
    //     validateSurvey($('#survey-name').val(), questionCount)
    // })

    $saveBtn.click(function() {
        var dog = getValues()
        console.log(dog)
        ajaxSurvey(dog)
    })

    function getValues() {
        // var $survey_name = $('#survey-name').val()
        // foreach $child_of #question-container
            // var question = [
        // {
        //     "question_order": 1,
        //     "question_text": $('label').val(),
        //     "question_type": 2,
        //     "required": "true",
        //     "options": [
        //     "male", "female"
        // ]
        var survey = {
            "survey_name": $('#survey-name').val(),
            "user_id": 1,
            "questions": [
                {
                    "question_order" : 1,
                    "question_text" : "what is your gender?",
                    "question_type" : 2,
                    "required" : "true",
                    "options" : [
                        "male", "female"
                    ]
                }
        ]}
        return survey;
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

    function ajaxSurvey(survey) {
        $.ajax({
            method: "POST",
            url: "/survey/create",
            data: survey
        })
            .done(function() {
                alert( "Data Saved");
            });
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

// for (i = 1; i < question_Count; i++) {
//     question_order = i
    //do stuff
    // question_text = $('#question-container div label').eq(i - 1).text()
    // question_type = $('.new-question')[i - 1].childNodes[4]
    // "required" = $('.new-question')[i - 1].childNodes[7],
        //     if $('.new-question')[0].childNodes[9] != options


