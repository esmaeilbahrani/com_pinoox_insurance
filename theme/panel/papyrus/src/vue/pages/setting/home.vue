<template>
    <div class="page p-0">
        <header>
            <div class="form-header">
                <div class="title">
                    <div class="text" v-if="!$parent.isTheme">
                        {{LANG.panel.settings}}
                    </div>
                    <div class="text" v-else>
                        {{LANG.panel.theme_settings}} {{$parent.theme_name}}
                    </div>
                    <div class="subtext">
                        {{LANG.panel.subtitle_settings}}
                    </div>
                </div>
            </div>
        </header>
        <simplebar class="simplebar" v-if="!!menus && menus.length > 0">
            <div class="form-content">
                <div class="menus setting">
                    <router-link tag="div" class="item"
                                 :to="{name:!$parent.isTheme? 'setting-config' : 'theme-setting-config',params:{setting_key:view.key}}"
                                 v-for="view in menus" v-bind:key="view.key">
                        <i :class="view.icon"></i>
                        <span class="text">{{view.label}}</span>
                    </router-link>
                    <router-link v-if="!$parent.isTheme" tag="div" class="item"
                                 :to="{name: 'theme-setting',params:{theme_name:theme}}">
                        <i class="fa fa-paint-brush"></i>
                        <span class="text">{{LANG.panel.theme_settings}}</span>
                    </router-link>
                </div>
            </div>
        </simplebar>
        <div class="container" v-else>
                    <div class="section-content">
                        <h3 class="subtitle">{{LANG.panel.no_settings_template}}</h3>
                        <span @click="$router.go(-1)" class="btn btn-sm btn-simple">{{LANG.panel.back}}</span>
                    </div>
            </div>

        </div>
</template>

<script>
    export default {
        data() {
            return {
                params: {},
                theme:null,
            }
        },
        created()
        {
            this.getActiveTheme();
        },
        computed: {
            menus() {
                return this.$parent.views.sort(function (a, b) {
                    let sortA = !!a.sort ? a.sort : 0;
                    let sortB = !!b.sort ? b.sort : 0;
                    return sortA - sortB;
                });
            }
        },
        methods: {
            getActiveTheme()
            {
                if (this.$parent.isTheme)
                    return;
                this.$http.get(this.URL.API+'setting/getActiveTheme/').then((json) => {
                    this.theme = json.data;
                });
            },
            goTo(name) {
                this._routerReplace({name: 'setting-' + name});
            }
        }
    }
</script>