$(function(){

    var button = $('#add-question')
    button.prop("disabled",true)

    $('.question-adder .input-selector').change(function() {
        if ($('.input-selector .radio-input').prop('selected'))
        {

        } elseif ($('.input-selector .checkbox-input').prop('selected'))
        {

        }
    })

    $('#question').keyup(function(e)
    {
        validateNewQuestion($('#question').val(), button)
    })

    button.click(function(e)
        {
            e.preventDefault()
            var question = $('#question').val()
            var type = $('#input-selector').val()

            var required = 'no'
            if($('#required').is(':checked')){
                required = 'yes'
            }

            var div =   '<div class="new-question">' +
                        'question: ' + question +
                        '<br>' +
                        'type: ' + type +
                        ' required: ' + required +
                    '</div>'

            $('#survey-section').append(div)

        }
    )

    /**
     * Validates input of new question form
     * Enables button if all inputs valid
     *
     * @param STRING question text in question's text box
     * @param JQUERYSELECTOR button to be enabled
     */
     function validateNewQuestion (question, button)
     {
        if(question.length >= 10 && question.length <= 255)
        {
            button.prop("disabled",false)
        }
        else
        {
            button.prop("disabled",true)
        }

        //TODO Add validation for radio options
        //TODO Add validation for checkbox options
    }
})

