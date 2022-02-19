<template>
    <div class="page result-page">
        <celebration></celebration>

        <div class="container">
            <div class="message">
                <div class="icon">
                    <i class="fas fa-handshake-alt"></i>
                </div>
                <div class="title">پایان آزمون</div>
                <div class="subtitle">
                    از اینکه در این پرسش و پاسخ شرکت کردید متشکریم
                </div>
            </div>

            <div class="stats">
                <div class="item style-secondary">
                    <div class="icon"><i class="fas fa-list-ol"></i></div>
                    <div class="text">
                        <div class="caption">کل سوالات</div>
                        <div class="value">{{result.total}}</div>
                    </div>
                </div>

                <div class="item style-green">
                    <div class="icon"><i class="far fa-check"></i></div>
                    <div class="text">
                        <div class="caption">پاسخ های درست</div>
                        <div class="value">{{result.correct}}</div>
                    </div>
                </div>

                <div class="item style-red">
                    <div class="icon"><i class="far fa-times"></i></div>
                    <div class="text">
                        <div class="caption">پاسخ های غلط</div>
                        <div class="value">{{result.wrong}}</div>
                    </div>
                </div>

                <div class="item style-grey">
                    <div class="icon"><i class="far fa-sticky-note"></i></div>
                    <div class="text">
                        <div class="caption">بی پاسخ</div>
                        <div class="value">{{result.no_answer}}</div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
    import celebration from '../components/celebration.vue';

    export default {
        components: {celebration},
        props: ['token'],
        data() {
            return {
                result: {},
                params: {
                    token: this.token
                }
            }
        },
        created() {
            this.getResult();
        },
        methods: {
            getResult() {
                this.$http.post(this.URL.API + 'quiz/getResult', this.params).then((json) => {
                    if (json.data.status) {
                        this.result = json.data.result;
                    }
                });
            }
        }

    }
</script>