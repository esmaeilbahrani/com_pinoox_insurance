import {getField, updateField} from 'vuex-map-fields';

export default {
    namespaced: true,
    state: {
        params: {},
        initParams: {
            quiz_name: {
                type: String,
                default: null,
            },
            quiz_description: {
                type: String,
                default: null,
            },
            questions: {
                type: Array,
                default: [],
                getValue(data) {
                    return data.questions.map((item) => {
                        item.isBody = false;
                        item.body = !!item.body? JSON.parse(item.body) : {};
                        return item;
                    });
                }
            },
            category: {
                type: Object,
                default: null,
            },
            status: {
                type: String,
                default: 'draft',
            }
        }
    },
    mutations: {
        updateField,
        updateParams(state, params) {
            state.params = params;
        }
    },
    actions: {
        resetQuizParams({commit, getters}) {
            commit('updateParams', getters.getBuildParams());
        },
        updateQuizParams({commit, getters}, data) {
            data = getters.getBuildParams(data);
            commit('updateParams', data);
        },
    },
    getters: {
        getField,
        getBuildParams: (state) => ($data = null) => {
            let params = state.initParams;
            let data = !!$data && typeof $data === 'object' ? $data : {};
            let result = {};

            for (let key in params) {
                let param = params[key];
                let field = !!param.field ? param.field : key;
                let type = !!param.type ? param.type : 'custom';
                let value = !!$data && !!param.getValue ? param.getValue(data) : param.default;

                if (type === Array) {
                    result[key] = !param.getValue && !!data[field] && Array.isArray(data[field]) ? data[field] : value;
                } else if (type === Object) {
                    result[key] = !param.getValue && !!data[field] && typeof data[field] === 'object' ? data[field] : value;

                } else {
                    result[key] = !param.getValue && !!data[field] ? data[field] : value;
                }
            }

            return result;
        },
    },
};