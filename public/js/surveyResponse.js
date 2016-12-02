$(function() {
    var $requiredQuestions = $('.question.required')
    $('#userResponseSubmit').click(function(e)
    {
        e.preventDefault()
        if (!$requiredQuestions.length) {
            submitForm()
        } else {
        }
    })










})

function submitForm() {
    ajaxUserSurvey('trees')
}

/**
 * Performs ajax request to send data to controller, displays modal if successful and redirects to account page, or alert
 * if unsuccessful
 * @param survey ARRAY all survey data
 */
function ajaxUserSurvey(survey)
{
    $.ajax({
        method: 'POST',
        url: '/survey/submit',
        data: survey,
        success: function(response)
        {
            if (response['success']) {
                $('#successModal').modal()
            } else {

                alert(response['message'])
            }
        }
    })
}