/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import * as PageUtil from './tccx/page-util';
import QuestSystem, {QuestLocationApp} from './tccx/app-quest-system';
import Vue from 'vue';
import * as Scoreboard from './tccx/score.js';

window.Vue = Vue;
window.PageUtil = PageUtil;

$(document).ready(function () {
    // mount quest location app
    PageUtil.mountVueApp('#quest-location-list', new QuestLocationApp());
    // initialize delete modal injection
    QuestSystem.initializeModalInjection('#quest-delete-modal', {
        'quest': 'input#input-delete-quest',
        'quest-code': '#input-quest-code'
    });
    QuestSystem.initializeModalInjection('#quest-location-delete-modal', {'quest_loc': 'input#input-delete-quest-location'});
    QuestSystem.initializeModalInjection('#quest-assign-modal', {
        'quest': 'input#input-assign-quest',
        'quest-code': '#input-quest-code'
    });
    QuestSystem.initializeModalInjection('#quest-finish-modal', {
        'quest': 'input#input-finish-quest',
        'quest-code': '#input-quest-code'
    });
    // GATE Land
    QuestSystem.initializeModalInjection('#set-score', {
        'team': 'input#input-team', 'team-name': '#team-name', 'score': 'input#input-score'
    });
    QuestSystem.initializeModalInjection('#set-money', {
        'team': 'input#input-team-money',
        'team-name': '#team-name-money',
        'money': 'input#input-money',
        'subtract': 'input#input-subtract',
        'text-money': '#text-money',
    });

    QuestSystem.onAssignButtonClick();
    // scoreboard
    Scoreboard.disableSelectWhenChecked('#input-team', '#input-team-checkbox');
});