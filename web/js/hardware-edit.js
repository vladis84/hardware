function addParam()
{
    var $block = $('.hidden.param-block').clone(true);
    var blockId = $('.param-body .param-block').length + 1;

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

    $('.param-body').append($block).show();
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
    $('.js-remove-param').click(function () {removeParam($(this));});
});

