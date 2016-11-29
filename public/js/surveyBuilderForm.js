$(function(){

    $('.question-adder .input-selector').change(function() {
        if ($('.input-selector .radio-input').prop('selected'))
        {

        } elseif ($('.input-selector .checkbox-input').prop('selected'))
        {

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