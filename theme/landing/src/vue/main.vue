<template>
    <div class="app">
        <section class="app-container">
            <Loading v-if="_isLoading"></Loading>
            <vue-page-transition name="fade-in-up">
                <router-view></router-view>
            </vue-page-transition>
        </section>
    </div>
</template>

<script>

    import Loading from './components/loading.vue';

    export default {
        components: {Loading},
        data() {
            return {
                numProcessing: 0,
            }
        },
        computed: {
            isCustom: {
                get() {
                    return !!this.$route.meta.custom && !!this.$route.meta.custom;
                }
            }
        },
        methods: {
            customInterceptors() {
                this.numProcessing = 0;
                this.$http.interceptors.request.use((request) => {

                    let isLoading = true;
                    if (request.params !== undefined && request.params.isLoading !== undefined) {
                        isLoading = request.params.isLoading;
                    }
                    if (isLoading) {
                        this.numProcessing++;
                        this._isLoading = true;
                    }
                    request.isLoading = isLoading;

                    return request;
                });

                this.$http.interceptors.response.use((response) => {
                    if (response.config.isLoading) {
                        this.numProcessing--;
                        let isStop = (this.numProcessing === 0);
                        if (isStop) {
                            this._isLoading = false;
                        }

                    }
                    return response;
                });
            },
        },
        created() {
            this.customInterceptors();
            this.getInitUser();
            this.route = this._clone({
                ...this.$route,
            });

            this._routerReplace(this.route);
        },


    }
</script>