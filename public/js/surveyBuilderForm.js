$(function()
{
    $('.question-adder .input-selector').change(function() {
        $('#question-options').remove()
        if (!$('.input-selector .text-input').prop('selected'))
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
        } else
        {
        }
    })


})



//$('body').css('background', 'red')
//$('body').css('background', 'white')