$(function() {
    var questionCount
    var surveyNameLength
    var $saveBtn = $('#submit-btn')
    var $surveyName = $('#survey-name')

    $saveBtn.prop("disabled", true)

    $surveyName.keyup(function()
    {
        surveyNameLength = $surveyName.val().length
        validateSurvey(surveyNameLength, questionCount)
    })

    $saveBtn.click(function()
    {
        var survey = getValues()
        ajaxSurvey(survey)
    })

    $('#add-question').click(function()
    {
        // updating question count for validation
        questionCount = $('#question-container .new-question').length
        validateSurvey(surveyNameLength, questionCount)
    })

    $(document).on('click', '.remove-question', function()
    {
        questionCount = $('#question-container .new-question').length
        validateSurvey(surveyNameLength, questionCount)
    })

    function validateSurvey(surveyNameValue, questionCount)
    {
        if(surveyNameValue > 0 && surveyNameValue <= 255 && questionCount > 0)
        {
            $saveBtn.prop("disabled", false)
        }
        else
        {
            $saveBtn.prop("disabled", true)
        }
    }
})

function getValues()
{
    var questions = []

    $('.new-question').each(function(key)
    {
        var questionOrder = key + 1
        var questionText = $('h5', this).text()
        var questionType = $('.options input', this).attr('type')
        var required = $(this).data('required')
        var options = []

        if (questionType != 'text') {
            $('.options input', this).each(function () {
                options.push($(this).val())
            })
        } else {
            options.push(questionText)
        }

        questionType = typeConverter(questionType)

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

function ajaxSurvey(survey, surveyId)
{
    $.ajax({
        method: "POST",
        url: "/survey/create",
        data: survey,
        success: function(response)
        {
            if (response['success']) {
                var surveyId = response['surveyId']
                alert("Data Saved")
            } else {
                alert(response['message'])
            }

        }
    })
}

function typeConverter(questionType) {
    var numberedType
    switch(questionType) {
        case 'text':
            numberedType = 1
            break
        case 'radio':
            numberedType = 2
            break
        case 'checkbox':
            numberedType = 3
            break
    }
    return numberedType
}





