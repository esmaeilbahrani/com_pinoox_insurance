import Vue from "vue";
import VueRouter from "vue-router";
import {routes} from "./routes";
import Store from './store';

Vue.use(VueRouter);

// router
const router = new VueRouter({
    mode: 'history',
    routes: routes,
    scrollBehavior(to, from, savedPosition) {
        return {x: 0, y: 0}
    },
});

router.beforeEach((to, from, next) => {
    next()
});

export default router;