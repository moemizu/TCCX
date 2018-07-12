import Vue from "vue";

export const QuestSystem = {
    initializeDeleteModal: function (modalSelector, dataKey, inputFieldSelector) {
        this.onModalClick(modalSelector, function (button, modal) {
            let data = button.data(dataKey);
            modal.find(inputFieldSelector).val(data);
        });
    },
    onModalClick: function (modalSelector, action) {
        $(modalSelector).on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let modal = $(this);
            if (action instanceof Function) {
                action(button, modal);
            }
        })
    }
};

export const QuestLocationRow = {
    data() {
        return {}
    },
    props: ['id', 'name', 'type', 'lat', 'lng'],
    template: '<tr><td>{{id}}</td>' +
    '<td contenteditable="true">{{name}}</td>' +
    '<td contenteditable="true">{{type}}</td>' +
    '<td contenteditable="true">{{lat}},{{lng}}</td>' +
    '<td>' +
    '<button @click="saveItem" class="btn btn-sm btn-primary" role="button" aria-disabled="true"><i class="fas fa-edit"></i> Save</button> ' +
    '<button @click="deleteItem" data-toggle="modal" data-target="#quest-location-delete-modal"' +
    ' :data-quest_loc="id" class="btn btn-sm btn-danger" role="button"' +
    ' aria-disabled="true"><i class="fas fa-trash"></i> Delete</button>' +
    '</td></tr>',
    methods: {
        saveItem() {
            console.log('TODO: Save');
        },
        deleteItem() {
            console.log('TODO: Delete');
        }
    }
};

export const QuestLocationApp = Vue.extend({
    data() {
        return {
            questLocations: []
        }
    },
    components: {
        'quest-location': QuestLocationRow
    },
    created() {
        this.questLocations = window.AppData.questLocations;
    },
    methods: {
        create() {
            this.questLocations.push({
                id: '',
                name: '',
                type: 'default',
                lat: '0.000000',
                lng: '0.000000'
            });
        }
    }
});

export default QuestSystem;