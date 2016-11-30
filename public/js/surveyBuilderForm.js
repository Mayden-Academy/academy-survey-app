$(function(){
    var addQuestionButton = $('#add-question')

    addQuestionButton.prop("disabled",true)

    /**
     *
     *
     * @param $container
     */
    function addOptionsCreator($container) // pass $('#input-container')
    {
        $container.append(
            '<div id="question-options" class="input-group">' +
            '<label for="option-text">Options:</label>' +
            '<br>' +
            '<input type="text" id="option-text">' +
            '<button class="btn input-group-addon" id="add-option">+</button>' +
            '</div>'
        )

        createAddOptionHandler()
    }

    function createAddOptionHandler()
    {
        $('#add-option').click(function()
        {
            if($('#option-text').val() !== '')
            {
                createOption($('#option-text'))
            }

            validateNewQuestion($('#question').val(), addQuestionButton, $('#input-selector').val())
        })
    }

    function  createOption($optionText) // pass $('#option-text')
    {
        $('#add-option').after( //TODO make the questions output in order, either above or below #add-option
            '<div class="input-group">' +
            '<input class="bg-success" value="' + $optionText.val() + '" disabled>' +
            '<button class="btn remove-option input-group-addon">-</button>' +
            '</div>'
        )
        $optionText.val('')

        $('.remove-option').click(function()
        {
            removeOption(this)
        })

    }

    function removeOption(currentOption)
    {
        $(currentOption).parent('div').remove()
        validateNewQuestion($('#question').val(), addQuestionButton, $('#input-selector').val())
    }



    $('#input-selector').change(function()
    {
        if ($('#input-selector').val() !== 'text-input' && $('#question-options').length < 1)
        {
            addOptionsCreator($('#input-container'))

        } else if($('#input-selector').val() == 'text-input')
        {
            $('#question-options').remove()
        }
        validateNewQuestion($('#question').val(), addQuestionButton, $('#input-selector').val())
    })

    $('#question').keyup(function(e)
    {
        validateNewQuestion($('#question').val(), addQuestionButton, $('#input-selector').val())
    })

    addQuestionButton.click(function(e)
        {
            var $questionContainer = $('#question-container')
            var $typeOptions = $('#question-options')

            var $question = $('#question')
            var $type = $('#input-selector')
            var $required = $('#required');

            var required = 'no'
            if($required.is(':checked'))
            {
                required = 'yes'
            }

            var options = $typeOptions.children('.input-group').children('input') //TODO change first children to .find(.imputgp input)
            var optionsString = ''

            if(options.length)
            {
                optionsString = '<br><b>Options:</b> '
                options.each(function(key,option)
                {
                    optionsString += option.value + ', '
                })
                optionsString = optionsString.substr(0,optionsString.length - 2)
            }

            //ui-state-default makes sortable
            var div =   '<div class="new-question ui-state-default">' +
                            '<b>Question:</b> ' + $question.val() +
                            '<br>' +
                            '<b>Type:</b> ' + $type.val() +
                            '<br>' +
                            '<b>Required:</b> ' + required +
                            optionsString +
                            '<br>' +
                            '<input type="submit" class="remove-question btn btn-sm" value="Remove">' +
                        '</div>'

            $questionContainer.append(div)

            $questionContainer.sortable(
                {
                    placeholder: "ui-state-highlight"
                }
            )

            $('.remove-question').click(function()
            {
                $(this).parent('.new-question').remove()
            })

            //resetting form
            $question.val('')
            $type.val('text-input')
            $required.prop('checked', false)
            $typeOptions.remove()
            addQuestionButton.prop("disabled",true)
        }
    )
})

/**
 * Validates input of new question form
 * Enables button if all inputs valid
 *
 * @param STRING question text in question's text box
 * @param JQUERYSELECTOR button to be enabled
 */
 function validateNewQuestion (questionText, $button, questionType)
{
    if (
        (
            ((questionType == 'radio-input') && ($('.remove-option').length >= 2)) ||
            ((questionType == 'checkbox-input') && ($('.remove-option').length >= 1)) ||
            (questionType == 'text-input')
        ) &&
        questionText.length >= 10 &&
        questionText.length <= 255
    ) {
        $button.prop("disabled",false)
    }
    else
    {
        $button.prop("disabled",true)
    }
}