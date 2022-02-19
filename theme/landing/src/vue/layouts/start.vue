<template>
    <section class="page start-page">


        <div class="container" v-if="!!quiz">

            <div v-if="false" class="fullname animate__animated animate__slideInDown">
                <span>نام و نام خانوادگی</span>
                <b>علیرضا محمدی</b>
            </div>
            <div class="quiz-card animate__animated animate__slideInDown">
                <img src="@img/sample.svg" alt="sample">
                <div class="title">{{quiz.quiz_name}}</div>
                <div class="summary">{{quiz.quiz_description}}</div>
            </div>

            <div @click="checkQuiz()" class="btn btn-primary btn-round animate__animated animate__slideInDown">شروع
                کن
            </div>

        </div>

        <div class="arts animate__animated animate__fadeIn animate__delay-1s">
            <img class="circle circle1" src="@img/circle1.svg" alt="circle">
            <img class="circle circle2" src="@img/circle2.svg" alt="circle">
        </div>

    </section>
</template>

<script>
    export default {
        props: ['quiz_id'],
        data() {
            return {
                quiz: null
            }
        },
        created() {
            this.getQuiz();
        },
        methods: {
            getQuiz() {
                let params = {
                    quiz_id: this.quiz_id
                };
                this.$http.post(this.URL.API + 'quiz/getById', params).then((json) => {
                    this.quiz = json.data;
                });
            },
            checkQuiz() {
                let params = {
                    quiz_id: this.quiz_id,
                };
                this.$http.post(this.URL.API + 'quiz/start', params).then((json) => {
                    var result = json.data.result;
                    if (json.data.status) {
                        this.quiz = result;
                        this.$router.push({
                            name: 'quiz-question',
                            params: {
                                token: result.token,
                            }
                        });
                    }
                });
            },
        }
    }
</script>