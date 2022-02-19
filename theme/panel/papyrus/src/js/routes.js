import Dashboard from '../vue/pages/dashboard.vue';
import Quiz from '../vue/pages/quiz/quiz-main.vue';
import QuizHome from '../vue/pages/quiz/quiz-home.vue';
import QuizForm from '../vue/pages/quiz/quiz-form.vue';
import Splash from '../vue/pages/splash.vue';
import Login from '../vue/pages/login.vue';
import Users from '../vue/pages/user/user-home.vue';
import Profile from '../vue/pages/profile.vue';
import Setting from '../vue/pages/setting/main.vue';
import SettingHome from '../vue/pages/setting/home.vue';
import SettingConfig from '../vue/pages/setting/config.vue';
import Template from '../vue/pages/template/main.vue';
import TemplateHome from '../vue/pages/template/home.vue';
import Category from '../vue/pages/category/category-main.vue';
import CategoryHome from '../vue/pages/category/category-home.vue';
import CategoryNode from '../vue/pages/category/category-node.vue';
import CategoryForm from '../vue/pages/category/category-form.vue';
import Group from '../vue/pages/group/group-home.vue';
import Permissions from '../vue/pages/permission/permission-home.vue';
import Error from '../vue/pages/error.vue';

export const routes = [
    {
        path: PINOOX.URL.BASE,
        name: 'splash',
        meta: {
            customView: true,
        },
        component: Splash
    },
    {
        path: PINOOX.URL.BASE + '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            showToolbar: true,
        }
    },
    {
        path: PINOOX.URL.BASE + '/login',
        name: 'login',
        meta: {
            customView: true,
        },
        component: Login,
    },
    {
        path: PINOOX.URL.BASE + '/users',
        name: 'users',
        component: Users,
    },
    {
        path: PINOOX.URL.BASE + '/groups',
        name: 'groups',
        component: Group,
    },
    {
        path: PINOOX.URL.BASE + '/permission/:group_key',
        name: 'permissions',
        component: Permissions,
        props: true,
    },
    {
        path: PINOOX.URL.BASE + '/profile',
        name: 'profile',
        component: Profile,
    },
    {
        path: PINOOX.URL.BASE + '/category',
        component: Category,
        children: [
            {
                path: 'node',
                name: 'category-node',
                component: CategoryNode,
            },
            {
                path: 'add',
                name: 'category-add',
                component: CategoryForm,
            },
            {
                path: 'edit/:cat_id',
                name: 'category-edit',
                component: CategoryForm,
                props: true,
            },
            {
                path: ':cat_id?',
                name: 'category',
                component: CategoryHome,
                props: true,
            },
        ],
    },
    {
        path: PINOOX.URL.BASE + '/quiz',
        component: Quiz,
        children: [
            {
                path: '',
                name: 'quiz-home',
                component: QuizHome,
            },
            {
                path: 'add',
                name: 'quiz-add',
                component: QuizForm,
            },
            {
                path: 'edit/:quiz_id',
                name: 'quiz-edit',
                component: QuizForm,
                props: true,
            },
        ],
    },
    {
        path: PINOOX.URL.BASE + '/theme/:theme_name/setting',
        component: Setting,
        props: true,
        children: [
            {
                path: '',
                name: 'theme-setting',
                component: SettingHome,
            },
            {
                path: ':setting_key',
                name: 'theme-setting-config',
                component: SettingConfig,
                props: true,
            },
        ],
    },
    {
        path: PINOOX.URL.BASE + '/setting',
        component: Setting,
        children: [
            {
                path: '',
                name: 'setting',
                component: SettingHome,
            },
            {
                path: ':setting_key',
                name: 'setting-config',
                component: SettingConfig,
                props: true,
            },
        ],
    },
    {
        path: PINOOX.URL.BASE + '/templates',
        component: Template,
        children: [
            {
                path: '',
                name: 'template',
                component: TemplateHome,
            },
        ],
    },
    {
        path: PINOOX.URL.BASE + '/error',
        name: 'error',
        component: Error,
    },
    {
        path: PINOOX.URL.BASE + "*",
        component: Error,
    },
];