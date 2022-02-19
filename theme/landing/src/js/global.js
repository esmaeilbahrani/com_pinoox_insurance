import Vue from "vue";

Vue.mixin({
    computed: {
        SETTING: {
            set(val) {
                this.$store.state.SETTING = val;
            },
            get() {
                return this.$store.state.SETTING;
            }
        },
        MENU: {
            set(val) {
                this.$store.state.MENU = val;
            },
            get() {
                return this.$store.state.MENU;
            }
        },
        GENERAL: {
            get() {
                return this.$store.state.GENERAL;
            },
            set(val) {
                this.$store.state.GENERAL = val;
            }
        },
        isLogin() {
            let user = this.USER;
            return !!user && !!user.isLogin;
        },
        USER: {
            get() {
                return this.$store.state.user;
            },
            set(val) {
                this.$store.state.user = val;
            }
        },
        countTranslate: {
            get() {
                return this.$store.state.countTranslate;
            },
            set(val) {
                this.$store.state.countTranslate = val;
            }
        },
        currentLang: {
            get() {
                let lang = !!document.documentElement.lang ? document.documentElement.lang : 'en';
                return !!this.$store.state.lang ? this.$store.state.lang : lang;
            },
            set(val) {
                this.$store.state.lang = val;
            }
        },
        LANG: {
            set(val) {
                this.$store.state.LANG = val;
            },
            get() {
                return this.$store.state.LANG;
            }
        },
        CONFIG: {
            get() {
                return this.$store.state.configs;
            },
            set(val) {
                this.$store.state.configs = val;
            }
        },
        URL: {
            get() {
                return PINOOX.URL;
            },
        },
        _dir() {
            return !!PINOOX.LANG.general.direction ? PINOOX.LANG.general.direction : 'ltr';
        },
        _isLoading: {
            set(val) {
                this.$store.state.isLoading = val;
            },
            get() {
                return this.$store.state.isLoading;
            }
        },
        offLoading() {
            return {
                params: {
                    isLoading: false,
                }
            }
        },
    },
    methods: {
        _title(title = null) {
            title = !!title ? this.GENERAL.site_title + ' - ' + title : this.GENERAL.site_title;
            document.title = title;
        },
        getInitUser() {
            return this.getUser();
        },
        getUser() {
            return this.$http.get(this.URL.API + 'user/get').then((json) => {
                let data = json.data;
                if (data.access) {
                    this.USER = data;
                    Vue.$cookies.set('user_id', data.user_id);
                } else {
                    this.USER = {access: false};
                    this._routerReplace({name: 'err403'});
                    Vue.$cookies.remove('user_id');
                }
                return this.USER;
            });
        },
        _removeFirstStr(string, search) {
            let length = string.length - search.length;
            return string.substr(search.length, length);
        },
        _delay: (function () {
            let timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })(),
        _notify(type, text, group = 'app') {
            this.$notify({
                group: group,
                type: type,
                text: text,
                duration: 5000,
            });
        },
        _messageResponse(json) {
            if (json.status) {
                this._notify('success', json.message, 'app');
                return true;
            } else {
                this._notify('error', json.message, 'app');
                return false;
            }
        },
        _statusResponse(json) {
            if (json.status) {
                this._notify('success', json.result, 'app');
                return true;
            } else {
                this._notify('error', json.result, 'app');
                return false;
            }
        },
        _isNull(value, replace = '-') {
            return !!value ? value : replace;
        },
        _replaceData() {
            let text = '';
            let args = [...arguments];
            let numargs = args.length;
            if (numargs < 1) return text;

            text = args[0];
            if (typeof (text) === "object" || typeof (text) === "array") return text;
            numargs--;
            if (numargs < 1) return text;

            args.shift();
            let replaces = args[0];
            if (typeof (replaces) === "object" || typeof (replaces) === "array") {
                let value = null;
                for (let key in replaces) {
                    value = replaces[key];
                    text = text.replace("{" + key + "}", value);
                }
                return text;
            }
            for (let i = 0; i < numargs; i++) {
                let replace = args[i];
                replace = (typeof (replace) === "object" || typeof (replace) === "array") ? JSON.parse(replace) : replace;
                text = text.replace("{" + i + "}", replace);
            }
            return text;
        },
        _confirm(message, func, isLoader = false) {
            this.$dialog.confirm({
                title: this.LANG.general.warning,
                body: message,
            }, {
                reverse: true,
                loader: isLoader,
                okText: this.LANG.general.yes,
                cancelText: this.LANG.general.no,
                customClass: 'dialog-custom',
            }).then(func);
        },
        _clone($obj) {
            return JSON.parse(JSON.stringify($obj));
        },
        _resetInitialData(key = null) {
            if (key !== null)
                this.$data[key] = this.$options.data()[key];
            else
                Object.assign(this.$data, this.$options.data());

        },
        _empty(data) {
            if (typeof data === 'object') {
                return this._emptyObj(data);
            } else {
                return !(data !== undefined && data !== null && data.length > 0);
            }
        },
        _emptyObj(obj) {
            return Object.keys(obj).length === 0;
        },
        _routerReplace(location) {
            this.$router.replace(location).catch(() => {
            });
        },
        _routerPush(location) {
            this.$router.push(location).catch(() => {
            });
        },
        _replaceAll(str, find, replace) {
            return str.replace(new RegExp(find.replace(/[.*+\-?^${}()|[\]\\]/g, '\\$&'), 'g'), replace);
        },
        _isNumber: function (evt) {
            evt = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        _timeNow() {
            let time = new Date().toLocaleTimeString();
            let parts = time.split(' ');
            return parts[0] + ' ' + this.LANG.panel[parts[1]];
        },
        _priceFormat: function (price) {
            return priceFormat(price);
        },
        _formError(el, msg = null) {
            if (!el) return;
            el = Array.isArray(el) ? el[0] : el;
            el = !!el.$el ? el.$el : el;

            let spn = el.querySelector('.error-text');
            if (!!spn) spn.remove();
            if (msg == null || msg.length === 0) {
                el.classList.remove('form-error');
            } else {
                el.classList.add('form-error');
                spn = document.createElement("span");
                spn.setAttribute("class", "error-text");
                spn.textContent = msg;
                el.appendChild(spn);
            }
        },
        _formErrors(refs, msg = null) {
            for (let e in msg)
                this._formError(refs[e], msg[e]);
        },
        _resetFormError(refs, name = null) {
            if (name != null) {
                let obj = refs[name];
                obj = Array.isArray(obj) ? obj[0] : obj;
                obj = !!obj.$el ? obj.$el : obj;

                refs = [];
                refs[name] = obj;
            }

            for (let key in refs) {
                if (!!key && refs[key] !== undefined) {
                    let frm = refs[key];
                    frm = Array.isArray(frm) ? frm[0] : frm;
                    frm = !!frm.$el ? frm.$el : frm;
                    if (!!frm.classList)
                        frm.classList.remove('form-error');

                    let spn = frm.querySelector('.error-text');
                    if (!!spn) spn.remove();
                }
            }
        },
    }
});
