export const QuestSystem = {
    initializeDeleteModal: function (modalSelector, dataKey = 'quest') {
        $(modalSelector).on('show.bs.modal', function (event) {
            // get data from button
            let button = $(event.relatedTarget);
            let data = button.data(dataKey);
            let modal = $(this);
            modal.find('input#input-delete-quest').val(data);
        })
    },
};

export default QuestSystem;