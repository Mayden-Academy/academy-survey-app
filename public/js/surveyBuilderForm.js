$(function() {
    var addQuestionButton = $('#add-question')

    addQuestionButton.prop("disabled", true)

    var $type = $('#input-selector')

    $type.change(function () {
        if ($type.val() !== 'text-input' && $('#question-options').length < 1) {
            addOptionsCreator($('#input-container'))

        } else if ($type.val() == 'text-input') {
            $('#question-options').remove()
        }
        validateNewQuestion($('#question').val(), addQuestionButton, $type.val())
    })

    $('#question').keyup(function(e) {
        validateNewQuestion($('#question').val(), addQuestionButton, $type.val())
    })

    addQuestionButton.click(function(e) {
        addQuestion($type)
    })




//_________________________________FUNCTION DEFINITIONS__________________________________________
    //TODO: DocBlock me please :)
    /**
     *
     * @param $type
     */
    function addQuestion($type) {
        var $questionContainer = $('#question-container')
        var $typeOptions = $('#question-options')
        var $question = $('#question')
        var $required = $('#required')

        var question = $question.val()
        var type = $type.val().slice(0, $type.val().length - 6)
        var options = $typeOptions.find('.input-group input')
        var response = '<div class="options">'

        if ($required.is(':checked')) {
            question += ' *'
        }

        if (type == 'text') {
            response += '<input type="text" disabled >'
        } else {
            if (options.length) {
                options.each(function (key, option) {
                    response += '<div><input type="' + type + '" disabled value="' + option.value + '"> ' + option.value + '</div>'
                })
            }
        }

        response += '</div>'

        var newQuestion = '<div class="new-question ui-state-default">' +
            '<h5>' + question + '</h5>' +
            response +
            '<input type="submit" class="remove-question btn btn-sm" value="Remove">' +
            '</div>'

        var $newQuestion = $(newQuestion).data('required', $required.is(':checked'))

        $questionContainer.append($newQuestion)

        $questionContainer.sortable(
            {
                placeholder: "ui-state-highlight"
            }
        )

        $('.remove-question').click(function () {
            $(this).parent('.new-question').remove()
        })

        //resetting form
        $question.val('')
        $type.val('text-input')
        $required.prop('checked', false)
        $typeOptions.remove()
        addQuestionButton.prop("disabled", true)
    }


    /**
     * Adds the facility to add and remove options for multiple choice questions. Initially this consists of a text
     * field and an add option (+) button.
     *
     * @param $container OBJECT the created DOM objects are appended to the contents of this html element
     */
    function addOptionsCreator($container) {
        $container.append(
            '<div id="question-options">' +
            '<label for="option-text">Options:</label>' +
            '<div id="new-option-container" class="input-group col-xs-2">' +
            '<input type="text" id="option-text">' +
            '<button class="btn input-group-addon" id="add-option">+</button>' +
            '</div>' +
            '</div>'
        )

        createAddOptionHandler()
    }


    /**
     * Creates a handler for the click event on the add option button. The handler adds the option (providing it's
     * non-empty) to the list of options for that question.
     * Then validates the form.
     */
    function createAddOptionHandler() {
        $('#add-option').click(function () {
            if ($('#option-text').val() !== '') // disables an empty string being added as an option
            {
                createOption($('#new-option-container'))
            }

            validateNewQuestion($('#question').val(), $('#add-question'), $type.val())
        })
    }


    /**
     * Creates a disabled field containing the text passed in, with a remove (-) button .
     *
     * @param $optionContainer OBJECT the div containing the text input and add button for creating new options
     */
    function createOption($optionContainer) {
        var $optionText = $optionContainer.find('input')
        $optionContainer.before(
            '<div class="input-group col-xs-2">' +
            '<input class="bg-success" value="' + $optionText.val() + '" disabled>' +
            '<button class="btn remove-option input-group-addon">-</button>' +
            '</div>'
        )
        $optionText.val('')

        $('.remove-option').click(function () {
            removeOption(this)
        })
    }


    /**
     * Removes the selected option from the list and then validates the form.
     *
     * @param currentOption OBJECT the remove button for the option to be removed
     */
    function removeOption(currentOption) {
        $(currentOption).parent('div').remove()
        validateNewQuestion($('#question').val(), $('#add-question'), $type.val())
    }

    /**
     * Validates input of new question form
     * Enables button if all inputs valid
     *
     * @param STRING question text in question's text box
     * @param JQUERYSELECTOR button to be enabled
     */
    function validateNewQuestion(questionText, $button, questionType) {
        if (
            (
                ((questionType == 'radio-input') && ($('.remove-option').length >= 2)) ||
                ((questionType == 'checkbox-input') && ($('.remove-option').length >= 1)) ||
                (questionType == 'text-input')
            ) &&
            questionText.length >= 10 &&
            questionText.length <= 255
        ) {
            $button.prop("disabled", false)
        }
        else {
            $button.prop("disabled", true)
        }
    }

})