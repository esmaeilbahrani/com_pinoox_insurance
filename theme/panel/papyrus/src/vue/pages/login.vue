<template>
    <section class="login-page">

        <div class="page-content">
            <div class="toolbar">
                <a :href="URL.SITE" class="brand">
                    <img :src="URL.APP_PATH + SETTING.GENERAL.site_logo" :alt="SETTING.GENERAL.site_title">
                    <span>{{ SETTING.GENERAL.site_title }}</span>
                </a>
            </div>

            <div class="content">

                <div class="brand-intro">
                    <div class="icon"><i class="fad fa-user-lock"></i></div>
                    <span class="intro-title">{{ LANG.panel.login_to_account }}</span>
                    <span class="intro-subtitle">جهت ورود به حساب کاربری نام کاربری و رمز عبور را وارد کنید</span>
                </div>

                <div class="form" @keypress.enter="login()">
                    <div class="input-form">
                        <input v-model="params.user_key" type="text" :placeholder="LANG.panel.user_key" name="username">
                    </div>
                    <div class="input-form">
                        <input v-model="params.password" type="password" :placeholder="LANG.panel.password"
                               name="password">
                    </div>

                    <button @click="login()" type="submit" class="btn">{{ LANG.panel.login }}</button>

                </div>

            </div>
        </div>

        <Particles id="particle" :options="{

                    fpsLimit: 60,
                    interactivity: {
                        events: {
                            onClick: {
                                enable: true,
                                mode: 'push'
                            },
                            onHover: {
                                enable: true,
                                mode: 'repulse'
                            },
                            resize: true
                        },
                        modes: {
                            bubble: {
                                distance: 100,
                                duration: 30,
                                opacity: 0.8,
                                size: 20
                            },
                            push: {
                                quantity: 4
                            },
                            repulse: {
                                distance: 200,
                                duration: 0.4
                            }
                        }
                    },
                    particles: {
                        color: {
                            value: '#ffffff'
                        },
                        links: {
                            color: '#ffffff',
                            distance: 150,
                            enable: true,
                            opacity: 0.3,
                            width: 1
                        },
                        collisions: {
                            enable: true
                        },
                        move: {
                            direction: 'none',
                            enable: true,
                            outMode: 'bounce',
                            random: false,
                            speed: 3,
                            straight: false
                        },
                        number: {
                            density: {
                                enable: true,
                                area: 800
                            },
                            value: 30
                        },
                        opacity: {
                            value: 0.3
                        },
                        shape: {
                            type: 'circle'
                        },
                        size: {
                            random: true,
                            value: 3
                        }
                    },
                    detectRetina: true
                }"/>

    </section>


</template>

<script>


    export default {
        data() {
            return {
                params: {
                    user_key: null,
                    password: null,
                }
            }
        },
        methods:
            {
                login() {
                    this.$http.post(this.URL.API + 'account/login', this.params).then((json) => {
                        if (this._messageResponse(json.data)) {
                            let result = json.data.result;
                            localStorage.paper_user = result.token;
                            this.getInitUser().then(() => {
                                console.log(this.$parent.route.name);
                                this.$parent.checkRouter();
                            });
                        }
                    });
                }
            },
    }
</script>
