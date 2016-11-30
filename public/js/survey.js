$(function() {

    var questionCount = $('#question-container').children().length
    var $saveBtn = $('#submit-btn')

    $saveBtn.prop("disabled", true)

    $('#survey-name').keyup(function() {
        validateSurvey($('#survey-name').val(), questionCount)
    })

    $saveBtn.click(function() {
        var surveyObject = getValues()
        ajaxSurvey(surveyObject)
    })

    function getValues() {
        var questions = []
        $('.new-question').each(function(key, value) {
            var questionOrder = key + 1
            var questionText = $('h5', this).text()
            var questionType = $('.options input', this).attr('type')
            var required = $(this).data('required')
            var options = []
            if (questionType != 'text') {
                $('.options input', this).each(function() {
                    options.push($(this).val())
                })
            }
            questions.push({
                "question_order" : questionOrder,
                    "question_text" : questionText,
                    "question_type" : questionType,
                    "required" : required,
                    "options" : options
            })
        })
        var survey = {
            "survey_name": $('#survey-name').val(),
            "questions": questions}
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
            })
    }
})