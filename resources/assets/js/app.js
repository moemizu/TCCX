/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import {scrollToElement, mountVueApp} from './tccx/page-util';
import QuestSystem, {QuestLocationApp} from './tccx/app-quest-system';
import Vue from 'vue';

window.Vue = Vue;
window.scrollToElement = scrollToElement;

$(document).ready(function () {
    // mount quest location app
    mountVueApp('#quest-location-list', new QuestLocationApp());
    // initialize delete modal injection
    QuestSystem.initializeModalInjection('#quest-delete-modal', {'quest': 'input#input-delete-quest'});
    QuestSystem.initializeModalInjection('#quest-location-delete-modal', {'quest_loc': 'input#input-delete-quest-location'});
    QuestSystem.initializeModalInjection('#quest-assign-modal', {'quest': 'input#input-assign-quest'});
    QuestSystem.initializeModalInjection('#quest-finish-modal', {'quest': 'input#input-finish-quest'});
});