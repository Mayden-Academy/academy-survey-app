$(function(){
    var addQuestionButton = $('#add-question')

    addQuestionButton.prop("disabled",true)

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

            var options = $typeOptions.find('.input-group input')
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


//_________________________________FUNCTION DEFINITIONS__________________________________________


/**
 * Adds the facility to add and remove options for multiple choice questions. Initially this consists of a text
 * field and an add option (+) button.
 *
 * @param $container OBJECT the created DOM objects are appended to the contents of this html element
 */
function addOptionsCreator($container)
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


/**
 * Creates a handler for the click event on the add option button. The handler adds the option (providing it's
 * non-empty) to the list of options for that question.
 * Then validates the form.
 */
function createAddOptionHandler()
{
    $('#add-option').click(function()
    {
        if($('#option-text').val() !== '') // disables an empty string being added as an option
        {
            createOption($('#option-text'))
        }

        validateNewQuestion($('#question').val(), $('#add-question'), $('#input-selector').val())
    })
}


/**
 * Creates a disabled field containing the text passed in, with a remove (-) button .
 *
 * @param $optionText OBJECT the text input element containing the text for the option being created
 */
function  createOption($optionText)
{
    $('#option-text').before(
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


/**
 * Removes the selected option from the list and then validates the form.
 *
 * @param currentOption OBJECT the remove button for the option to be removed
 */
function removeOption(currentOption)
{
    $(currentOption).parent('div').remove()
    validateNewQuestion($('#question').val(), $('#add-question'), $('#input-selector').val())
}

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