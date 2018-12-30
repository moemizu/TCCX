import Vue from "vue";
import axios from "axios";

export const QuestSystem = {
    initializeModalInjection: function (modalSelector, dataMap) {
        this.onModalClick(modalSelector, function (button, modal) {
            if (dataMap != null && (typeof dataMap === 'object'))
                for (let key in dataMap) {
                    let data = button.data(key);
                    let element = modal.find(dataMap[key]);
                    if (element.prop('tagName') === 'INPUT') {
                        element.val(data);
                    } else {
                        element.text(data);
                    }
                }
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
    },
    onAssignButtonClick: function () {
        let button = $('.quest-assign');
        button.click(function (e) {
            let groupNo = e.currentTarget.dataset.questGroup;
            let assisted = false;
            $("#select-team > option").each(function () {
                if (this.dataset.group === groupNo) {
                    $(this).attr('selected', 'selected');
                    assisted = true;
                }
            });
            let info = $("#quest-assign-info");
            if (assisted) {
                info.text('Automatically selecting a team based on the quest group no.');
                info.removeClass('text-info');
                info.addClass('text-success');
            } else {
                info.text('Please select a team');
                info.removeClass('text-success');
                info.addClass('text-info');
            }
        })
    }
};

export const QuestLocationRow = {
    data() {
        return {
            location: {
                id: 0,
                name: '',
                type: '',
                lat: 0.0,
                lng: 0.0
            },
        }
    },
    props: ['id', 'name', 'type', 'lat', 'lng'],
    template: '<tr><td>{{id}}</td>' +
    '<td @input="updateData(\'name\',$event)" contenteditable="true">{{name}}</td>' +
    '<td @input="updateData(\'type\',$event)" contenteditable="true">{{type}}</td>' +
    '<td contenteditable="true">{{lat}},{{lng}}</td>' +
    '<td>' +
    '<button @click="triggerSaveItem" class="btn btn-sm btn-primary" :class="buttonStyle" role="button" aria-disabled="true"><i class="fas fa-edit"></i> Save</button> ' +
    '<button @click="triggerDeleteItem" data-toggle="modal" data-target="#quest-location-delete-modal"' +
    ' :data-quest_loc="id" class="btn btn-sm btn-danger" role="button"' +
    ' aria-disabled="true"><i class="fas fa-trash"></i> Delete</button>' +
    '</td></tr>',
    created() {
        Object.keys(this.$props).forEach((key) => {
            this.location[key] = this[key]
        });
    },
    methods: {
        updateData(key, event) {
            this.location[key] = event.target.innerText;
        },
        triggerSaveItem() {
            this.$emit('save-item', this.location);
        },
        triggerDeleteItem() {
            this.$emit('delete-item', this.location);
        }
    },
    computed: {
        buttonStyle() {
            return {
                'btn-secondary': this.location.id == 0
            };
        }
    }
};

// TODO: Rework state management
export const QuestLocationApp = Vue.extend({
    data() {
        return {
            questLocations: [],
            selectedLocation: null
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
            this.questLocations.unshift({
                id: '',
                name: '',
                type: 'default',
                lat: '0.000000',
                lng: '0.000000'
            });
        },
        initDeleteItem(loc) {
            console.log("Location selected");
            this.selectedLocation = loc;
        },
        deleteItem() {
            console.log(this.selectedLocation);
            axios.post('/quest/location/delete', this.selectedLocation).then((response) => {
                console.log(response.data.message);
                // HACK: linear search
                this.questLocations = this.questLocations.filter(ql => ql.id !== this.selectedLocation.id);
            }).catch(reason => {
                console.log("Error");
                console.error(reason);
            });
        },
        saveItem(loc) {
            this.selectedLocation = loc;
            console.log(this.selectedLocation);
            axios.post('/quest/location/edit', this.selectedLocation).then((response) => {
                console.log(response.data.message);
            }).catch(reason => {
                console.log("Error");
                console.error(reason);
            });
        }
    }
});

export default QuestSystem;