function popoverShow(idElement, content, position, type) {
    if (position === undefined) {
        position = "top";
    }
    if (type === undefined) {
        type = "danger";
    }
    if (jQuery.type(idElement) === "string") {
        $('#' + idElement).popover({
                placement: position,
                content: content,
                selector: 'false',
                template: '<div class="popover popover-' + type + '" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
            })
            .popover('show');

        var idPopover = $('#' + idElement).attr('aria-describedby');
        $('#' + idPopover).find('.popover-content').html(content);
    } else {
        idElement.popover({
                placement: position,
                content: content,
                selector: 'false',
                template: '<div class="popover popover-' + type + '" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
            })
            .popover('show');

        var idPopover = idElement.attr('aria-describedby');
        idElement.find('.popover-content').html(content);
    }

}