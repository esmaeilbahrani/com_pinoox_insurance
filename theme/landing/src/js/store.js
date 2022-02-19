import Vue from 'vue';
import Vuex from 'vuex';
import $http from 'axios';


Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        LANG: PINOOX.LANG,
        MENU: PINOOX.MENU,
        GENERAL: PINOOX.GENERAL,
        SETTING: PINOOX.SETTING,
        user: {},
        isLoading: false,
        countTranslate: 0,
    },
    mutations: {
    },
    actions: {
    }
});