import Vue from 'vue';
import './global';
import axios from 'axios';
import axiosMethodOverride from 'axios-method-override';
import VueAxios from 'vue-axios';
import store from './store';
import Main from '../vue/main.vue';
import router from './router';
import Notifications from 'vue-notification';
import 'bootstrap';
import VuePageTransition from 'vue-page-transition';
import PrettyCheckbox from 'pretty-checkbox-vue';
import VueCookies from 'vue-cookies';

axios.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded';

axiosMethodOverride(axios);
const instance = axios.create();
axiosMethodOverride(instance);

Vue.use(VueCookies);
Vue.use(VuePageTransition);
Vue.use(Notifications);
Vue.use(VueAxios, axios);
Vue.use(PrettyCheckbox);

__webpack_public_path__ = PINOOX.URL.THEME + 'dist/';

new Vue({
    el: '#app',
    render: h => h(Main),
    router: router,
    store: store,
});
