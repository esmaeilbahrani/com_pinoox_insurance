<template>
    <div class="app">
        <div class="blur-loading animate__animated animate__fadeIn animate__faster"
             v-show="_isLoading && _isPrimaryLoading">
            <div class="spinner"></div>
        </div>
        <notifications group="app" classes="notification">
            <template slot="body" slot-scope="props">
                <div class="notification" :class="props.item.type" @click="props.close">
                    <a class="title">
                        {{ props.item.title }}
                    </a>
                    <div class="text" v-html="props.item.text"></div>
                </div>
            </template>
        </notifications>
        <section class="app-container">
            <div v-if="!hasCustomView">
                <sidebar></sidebar>
                <div class="main">
                    <div v-if="showToolbar" class="toolbar">
                        <router-link tag="div" :to="{name:'profile'}" class="account">
                            <img :src="USER.avatar_thumb" alt="profile">
                            <span class="text">{{ USER.full_name }}</span>
                        </router-link>
                        <div class="quick-actions">
                            <div class="item" @click="showFront()">
                                <simple-svg :src="_icons.eye"
                                            width="25px"
                                            customClassName="icon"/>
                            </div>
                        </div>
                    </div>
                    <div class="toolbar-drawer">
                        <div class="items">
                            <router-link v-if="_module('panel/dashboard')" :to="{name:'dashboard'}" class="item"
                                         exact-active-class="active">
                                <simple-svg :src="_icons.dashboard"
                                            customClassName="icon"
                                            fill="#A5B8CE"/>
                                <span class="text">{{ LANG.panel.dashboard }}</span>
                            </router-link>
                            <router-link class="item" v-if="_module('panel/quiz/add')" :to="{name:'quiz-add'}"
                                         exact-active-class="active">
                                <b class="far fa-clipboard-list"></b>
                                <span class="text">{{LANG.quiz.add_quiz}}</span>
                            </router-link>
                            <router-link class="item" v-if="_module('panel/quiz')" :to="{name:'quiz-home'}"
                                         exact-active-class="active">
                                <b class="fas fa-list-ol"></b>
                                <span class="text">{{LANG.quiz.exams}}</span>
                            </router-link>
                            <div class="item" @click="openMenu=true">
                                <simple-svg :src="_icons.more"
                                            customClassName="icon"
                                            fill="#A5B8CE"/>
                                <span class="text">{{ LANG.panel.more }}</span>
                            </div>
                        </div>
                    </div>
                    <transition name="fade" mode="out-in"
                                :enter-active-class="isTransition?'animate__animated animate__fadeInUp animate__faster':''"
                                :leave-active-class="isTransition?'animate__animated animate__fadeOutDown animate__faster':''">
                        <router-view :key="$route.fullPath"></router-view>
                    </transition>
                </div>

                <div class="toolbar-drawer">
                    <div class="items">
                        <router-link v-if="_module('panel/dashboard')" :to="{name:'dashboard'}" class="item"
                                     exact-active-class="active">
                            <simple-svg :src="_icons.dashboard"
                                        customClassName="icon"
                                        fill="#A5B8CE"/>
                            <span class="text">{{ LANG.panel.dashboard }}</span>
                        </router-link>
                        <router-link v-if="_module('panel/quiz/add')" class="item" :to="{name:'quiz-add'}"
                                     exact-active-class="active">
                            <b class="far fa-clipboard-list"></b>
                            <span class="text">{{LANG.quiz.add_quiz}}</span>
                        </router-link>
                        <router-link v-if="_module('panel/quiz')" class="item" :to="{name:'quiz-home'}"
                                     exact-active-class="active">
                            <b class="fas fa-list-ol"></b>
                            <span class="text">{{LANG.quiz.exams}}</span>
                        </router-link>
                        <div class="item" @click="openMenu=true">
                            <simple-svg :src="_icons.more"
                                        customClassName="icon"
                                        fill="#A5B8CE"/>
                            <span class="text">{{ LANG.panel.more }}</span>
                        </div>
                    </div>
                </div>
                <Menu :open="openMenu" @onClose="openMenu=false"></Menu>
            </div>
            <div v-else>
                <router-view></router-view>
            </div>
        </section>
    </div>
</template>

<script>
    import Menu from "./drawers/menu.vue";
    import Sidebar from "./components/sidebar.vue";

    export default {
        components: {Menu, Sidebar},
        data() {
            return {
                timestamp: null,
                route: {},
                numProcessing: 0,
                openMenu: false,
                isInitCheck: false,
            }
        },
        computed: {
            hasCustomView() {
                return !!this.$route.meta.customView;
            },
            showToolbar() {
                return !!this.$route.meta.showToolbar;
            }
        },
        methods: {
            customInterceptors() {
                this.numProcessing = 0;
                this.$http.interceptors.request.use((request) => {

                    let isLoading = true;
                    let isPrimaryLoading = true;
                    if (request.params !== undefined && request.params.isLoading !== undefined) {
                        isLoading = request.params.isLoading;
                    }

                    if (request.params !== undefined && request.params.isPrimaryLoading !== undefined) {
                        isPrimaryLoading = request.params.isPrimaryLoading;
                    }


                    if (isLoading || isPrimaryLoading) {
                        this.numProcessing++;
                    }

                    if (isLoading) {
                        this._isLoading = true;
                    }

                    if (isPrimaryLoading) {
                        this._isPrimaryLoading = true;
                    }

                    request.headers.Authorization = this.tokenAuth();
                    request.isLoading = isLoading;
                    request.isPrimaryLoading = isPrimaryLoading;

                    return request;
                });

                this.$http.interceptors.response.use((response) => {

                    if (response.config.isLoading || response.config.isPrimaryLoading)
                        this.numProcessing--;

                    if (response.config.isLoading) {
                        let isStop = (this.numProcessing === 0);
                        if (isStop) {
                            this._isLoading = false;
                        }
                    }

                    if (response.config.isPrimaryLoading) {
                        let isStop = (this.numProcessing === 0);
                        if (isStop) {
                            this._isPrimaryLoading = false;
                        }
                    }
                    return response;
                });
            },
            checkUser() {
                let token = this.tokenAuth();
                if ((!token || !this.isLogin()) && (!this.$route.name || this.$route.name !== 'login')) {
                    this._routerReplace({name: 'login'});
                } else if (!!this.route.name && (this.route.name === 'login' || this.route.name === 'splash')) {
                    this._routerReplace({name: 'dashboard'});
                } else {
                    this._routerReplace(this.route);
                }
            },
            getTimeStamp(date = null) {
                return new Date(date).getTime();
            },
            showFront() {
                window.open(PINOOX.URL.FRONT, '_blank');
            },
            checkRouter() {
                if (!this.isLogin)
                    return;

                this.isInitCheck = true;
                let name = !!this.route.name ? this.route.name : '';
                let route_path = !!this.route.path ? this.route.path : '';
                let path = this._removeFirstStr(this.route.path, PINOOX.URL.FRONT_BASE);

                let token = this.tokenAuth();
                if ((!token || !this.isLogin() || !this._module('panel')) && (!this.$route.name || this.$route.name !== 'login')) {
                    this._routerReplace({name: 'login'});
                } else if (this._module(path)) {
                    if (name === 'login' || path === 'panel/account' || name === 'splash') {
                        this._routerReplace({name: 'dashboard'});
                    } else {
                        this._routerReplace(route_path);
                    }
                } else {
                    this._routerReplace({name: 'error'});
                }
            },
        },
        created() {
            this.timestamp = this.getTimeStamp();
            this.customInterceptors();
            this.getInitUser(() => {
                this.checkRouter();
            });
            this.route = this._clone({
                ...this.$route,
            });
            this._routerReplace({name: 'splash'});
        },
        watch: {
            '$route': {
                handler() {

                    if (!this.isInitCheck)
                        return;

                    let path = this._removeFirstStr(this.$route.path, PINOOX.URL.FRONT_BASE);
                    if (!this._module(path))
                        this._routerReplace({name: 'error'});
                },
                deep: true,
            },
        }
    }
</script>