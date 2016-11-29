$(function()
{
    $('.question-adder .input-selector').change(function() {
        $('#question-options').remove()
        if (!$('.input-selector .text-input').prop('selected'))
        {
            $('.question-adder form').append(
            '<div class="bg-info" id="question-options">' +
            '<h4>Options:</h4>' +
            '<input type="text" id="option-text">' +
            '<button class="btn" id="add-option">+</button>' +
            '</div>'
            )
            $('#add-option').click(function() {
                $(this).after(
                    '<div>' +
                    '<div>' + $('#option-text').val() + '</div>' +
                    '<button class="btn remove-option">-</button>' +
                    '</div>'
                )
                $('#option-text').val('')
                $('.remove-option').click(function(){
                    $(this).parent('div').remove()
                })
            })
        } else
        {
        }
    })


})



//$('body').css('background', 'red')
//$('body').css('background', 'white')