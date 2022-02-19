import home from '../vue/layouts/home.vue';
import start from '../vue/layouts/start.vue';
import question from '../vue/layouts/question.vue';
import result from '../vue/layouts/result.vue';

export const routes = [
    {
        path: PINOOX.URL.BASE,
        name: 'quiz-home',
        component: home,
    },
    {
        path: PINOOX.URL.BASE + 'quiz/start/:quiz_id',
        name: 'quiz-start',
        component: start,
        props:true
    },
    {
        path: PINOOX.URL.BASE + 'quiz/question/:token',
        name: 'quiz-question',
        component: question,
        props:true
    },
    {
        path: PINOOX.URL.BASE + 'quiz/result/:token',
        name: 'quiz-result',
        component: result,
        props:true
    },

];