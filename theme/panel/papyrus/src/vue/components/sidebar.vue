<template>
    <div>
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="brand">
                    <div class="title">{{SETTING.GENERAL.site_title}}</div>
                    <div class="subtitle"></div>
                </div>
                <div class="nav">

                    <router-link v-if="_module('panel/dashboard')" :to="{name:'dashboard'}" class="item" exact-active-class="active">
                        <simple-svg :src="_icons.dashboard"
                                    customClassName="icon"
                                    fill="#A5B8CE"/>
                        <span class="text">{{LANG.panel.dashboard}}</span>
                    </router-link>
                    <router-link v-if="_module('panel/quiz/add')" class="item" :to="{name:'quiz-add'}" exact-active-class="active">
                      <b class="far fa-clipboard-list"></b>
                        <span class="text">{{LANG.quiz.add_quiz}}</span>
                    </router-link>
                    <router-link v-if="_module('panel/quiz')" class="item" :to="{name:'quiz-home'}" exact-active-class="active">
                      <b class="fas fa-list-ol"></b>
                      <span class="text">{{LANG.quiz.exams}}</span>
                    </router-link>
                    <div class="item" @click="openMenu()">
                        <simple-svg :src="_icons.more_square"
                                    customClassName="icon stroke"/>
                        <span class="text">{{LANG.panel.menus}}</span>
                    </div>
                </div>
                <div class="menu">
                    <router-link v-if="_module('panel/profile')" :to="{name:'profile'}" class="item">
                        <span class="text">{{LANG.panel.profile}}</span>
                    </router-link>
                    <router-link v-if="_module('panel/setting')" :to="{name:'setting'}" class="item">
                        <span class="text">{{LANG.panel.settings}}</span>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            openMenu() {
                this.$parent.openMenu = true;
            }
        }
    }
</script>