$(function(){

    $('.question-adder #input-selector').change(function()
    {
        $('#question-options').remove()
        if ($('#input-selector').val() !== 'text-input')
        {
            $('.question-adder form').append(
                '<div id="question-options" class="input-group">' +
                '<h4>Options:</h4>' +
                '<input type="text" id="option-text">' +
                '<button class="btn input-group-addon" id="add-option">+</button>' +
                '</div>'
            )

            var $optionInput = $('#option-text')

            $('#add-option').click(function() {
                if($optionInput.val() !== '') {
                    $(this).after(
                        '<div class="input-group">' +
                        '<input class="bg-success" value="' + $optionInput.val() + '" disabled>' +
                        '<button class="btn remove-option input-group-addon">-</button>' +
                        '</div>'
                    )
                    $optionInput.val('')
                    $('.remove-option').click(function(){
                        $(this).parent('div').remove()
                    })
                }
            })
        }
    })

    $('#add-question').click(function(e)
        {
            e.preventDefault()

            question = $('#question').val()
            type = $('#input-selector').val()

            required = 'no'
            if($('#required').is(':checked')){
                required = 'yes'
            }

            console.log(question)
            console.log(type)
            console.log(required)


            div =   '<div class="new-question">' +
                        'question: ' + question +
                        '<br>' +
                        'type: ' + type +
                        ' required: ' + required +
                    '</div>'

            $('#survey-section').append(div)

        }
    )
})


//$('body').css('background', 'red')
//$('body').css('background', 'white')