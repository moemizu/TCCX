export function disableSelectWhenChecked(selectElement, checkboxElement) {
    let select = $(selectElement), checkbox = $(checkboxElement);
    if (!(select.length && checkbox.length)) return;
    checkbox.change(function () {
        let checked = $(this).is(':checked');
        if (checked) select.prop('disabled', true);
        else select.prop('disabled', false);
    });
}