<template>
    <section class="page question-page">

        <div class="progressbar">
            <div class="fill" :style="{ width: percent + '%' }"></div>
        </div>

        <div class="container" v-if="!!quiz">
            <div class="question-header">
                <div class="counter"><b>سوال</b> <span>{{quiz.count}}/<b>{{params.index}}</b></span></div>
                <div class="title">{{quiz.item.question}}</div>
            </div>

            <div class="question-content">
                <quiz-descriptive @onReply="setAnswer" v-if="quiz.item.type == 'descriptive'"></quiz-descriptive>
                <quiz-options v-else @onAnswer="setAnswer" :items="quiz.item.options"></quiz-options>
            </div>

            <div class="question-nav">
                <div @click="prev()" v-if="params.index>1"
                     class="btn btn-primary btn-round animate__animated animate__slideInDown">قبلی
                </div>

                <div @click="next()" v-if="params.index !== this.quiz.count"
                     class="btn btn-primary btn-round  animate__animated animate__slideInDown">بعدی
                </div>

                <div @click="finish()" v-if="params.index === this.quiz.count"
                     class="btn btn-danger btn-round  animate__animated animate__slideInDown">پایان
                </div>
            </div>


        </div>


        <div class="arts animate__animated animate__fadeIn animate__delay-1s">
            <img class="circle circle1" src="@img/circle1.svg" alt="circle">
            <img class="circle circle2" src="@img/circle2.svg" alt="circle">
        </div>

    </section>
</template>

<script>
    import QuizOptions from '../components/quiz-options.vue';
    import QuizDescriptive from '../components/quiz-descriptive.vue';

    export default {
        components: {QuizOptions, QuizDescriptive},
        props: ['token'],
        data() {
            return {
                quiz: null,
                answer: null,
                params: {
                    token: this.token,
                    index: 1,
                }
            }
        },
        computed: {
            percent() {
                if (!!this.quiz) {
                    return Math.floor(this.params.index * 100 / this.quiz.count);
                }
                return 0;

            }
        },
        created() {
            this.getQuestions();
        },
        methods: {
            getQuestions() {
                this.$http.post(this.URL.API + 'quiz/getQuestion', this.params).then((json) => {
                    var result = json.data.result;
                    if (json.data.status) {
                        this.quiz = result;
                        this.answer = result.item.answer;
                    }
                });
            },
            saveAnswer() {
                let params = {
                    item: this.quiz.item,
                    token: this.token,
                    answer: this.answer
                }
                return this.$http.post(this.URL.API + 'quiz/answer', params).then((json) => {
                    return json.data.status;
                });
            },
            next() {
                if (this.params.index >= this.quiz.count) return;
                this.saveAnswer().then((isOk) => {
                    if (isOk) {
                        ++this.params.index;
                        this.getQuestions();
                    }
                });
            },
            prev() {
                if (this.params.index <= 1) return;
                --this.params.index;
                this.getQuestions();
            },
            finish() {
                this.saveAnswer().then((isOk) => {
                    if (isOk) {
                        this.$http.post(this.URL.API + 'quiz/finish', this.params).then((json) => {
                            if (json.data.status) {
                                this.$router.replace({name: 'quiz-result', params: {token: this.token}});
                            }
                        });
                    }
                });

            },
            setAnswer(e) {
                this.answer = e;
            }
        }
    }
</script>