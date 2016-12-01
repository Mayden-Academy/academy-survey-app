$(function() {
    var $saveBtn = $('#submit-btn')

    // Disable save survey button on load
    $saveBtn.prop('disabled', true)

    // Checking if validation conditions are met on each key entry in survey name box to enable save survey button
    $('#survey-name').keyup(function()
    {
        validateSurvey($saveBtn)
    })

    // Extract questions to the JSON schema
    // Pass to the ajax post
    $saveBtn.click(function()
    {
        var survey = getValues($('#survey-name'))
        ajaxSurvey(survey)
    })

    // Checking if validation conditions are met on each new question addition
    $('#add-question').click(function()
    {
        validateSurvey($saveBtn)
    })

    // Validation on question removal to disable save survey button in case removal leaves no questions
    $(document).on('click', '.remove-question', function()
    {
        validateSurvey($saveBtn)
    })

    // Redirects to account page on closing the survey saved modal
    $('#modalClose').click(function()
    {
        window.location.replace('/account')
    })
})

/**
 * Validates the survey by ensuring it has a name and more than one question, disables or enables save button as appropriate
 * @param $saveBtn STRING jQuery selector of the save button
 */
function validateSurvey($saveBtn)
{
    var questionCount = $('#question-container .new-question').length
    var surveyNameLength = $('#survey-name').val().length

    if(surveyNameLength > 0 && surveyNameLength <= 255 && questionCount > 0)
    {
        $saveBtn.prop('disabled', false)
    }
    else
    {
        $saveBtn.prop('disabled', true)
    }
}

/**
 * Extracts data from user submitted survey and inserts into JSON object
 * @param $surveyName STRING jQuery selector containing survey name
 * @return OBJECT object ready for ajax request
 */
function getValues($surveyName)
{
    var questions = []

    // Iterates over each question and extracts data into variables
    $('.new-question').each(function(key)
    {
        var questionOrder = key + 1
        var questionText = $('h5', this).text()
        var questionType = $('.options input', this).attr('type')
        var required = $(this).data('required')
        var options = []

        // Extracts either each option or the question name for a text input
        if (questionType != 'text') {
            $('.options input', this).each(function () {
                options.push($(this).val())
            })
        } else {
            options.push(questionText)
        }

        // Calls typeConverter to convert questionType into correct number for DB
        questionType = typeConverter(questionType)

        // Inserts above variables into JSON object and into question array
        questions.push({
            "question_order" : questionOrder,
            "question_text" : questionText,
            "question_type" : questionType,
            "required" : required,
            "options" : options
        })
    })

    // Returns object containing survey name and array of questions
    return {
        "survey_name": $surveyName.val(),
        "questions": questions
    }
}

/**
 * Performs ajax request to send data to controller, displays modal if successful and redirects to account page, or alert
 * if unsuccessful
 * @param survey ARRAY all survey data
 */
function ajaxSurvey(survey)
{
    $.ajax({
        method: 'POST',
        url: '/survey/create',
        data: survey,
        success: function(response)
        {
            if (response['success']) {
                var surveyId = response['surveyId']
                $('#successModal').modal()
            } else {
                alert(response['message'])
            }
        }
    })
}

/**
 * Converts questionType into the appropriate number for DB insertion
 * @param questionType STRING question type
 * @return INT equivalent question type number
 */
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





