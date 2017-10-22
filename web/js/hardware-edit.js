function addParam()
{
    var $block = $($('.param-template').html());
    var $paramBody = $('.param-body');

    var blockId = parseInt($paramBody.data('params-number')) + 1;

    console.log(blockId);
    $paramBody.data('params-number', blockId);

    $block.find('textarea,select').each(function () {
        var $element = $(this);
        var id = $element.attr('id').replace('id', blockId);
        var name = $element.attr('name').replace('id', blockId);

        $element.attr('id', id).attr('name', name);
    });

    $block.find('label').each(function () {
        var $element = $(this);
        var attr = $element.prop('for').replace('id', blockId);

        $element.prop('for', attr);
    });

    $block.removeClass('hidden');

    $paramBody.append($block).show();
}

/**
 *
 * @param {jQuery} $button
 * @returns {undefined}
 */
function removeParam($button)
{
    $button.closest('.row').remove();
}

$(document).ready(function () {
    $('.js-add-param').click(function () {addParam();});
    $('.param-body').on('click', '.js-remove-param', function () {removeParam($(this));});
});

