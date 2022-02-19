<template>
    <div class="page">
        <div class="menubar">
            <div class="items">
                <div class="text">
                    <span class="title">{{ LANG.quiz.exams }}</span>
                </div>
                <router-link v-if="_module('panel/quiz/add')" :to="{name:'quiz-add'}" class="item">
                    {{ LANG.quiz.add_quiz }}
                </router-link>
                <div v-if="_module('panel/quiz/search')" class="item" @click="drawerName='search'">
                    {{ LANG.panel.advanced_search }}
                </div>
            </div>
        </div>

        <div class="search-bar">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input v-model="params.keyword" class="search-input" type="text" :placeholder="LANG.panel.search + '...'">
        </div>
        <simplebar class="simplebar">
            <div class="container">

                <ul v-if="params.isSearch" class="section-tab">
                    <li class="active" @click="drawerName='search'">
                        {{ LANG.panel.advanced_search }}
                    </li>
                    <li @click="cancelAdvancedSearch()">
                        <i class="fa fa-times"></i>
                    </li>
                </ul>

                <ul v-else class="section-tab">
                    <li @click="filter('all')"
                        :class="[params.status==='all' ? 'active' :'' ]">{{ LANG.panel.all }}
                    </li>
                    <li v-for="(label,status) in LANG.quiz.status" @click="filter(status)"
                        :class="[params.status===status? 'active' :'']">
                        {{ label }}
                    </li>
                </ul>

                <div class="section compact-mode">
                    <div class="section-content">
                        <vue-good-table
                                styleClass="vgt-table table"
                                :rtl="_dir==='rtl'"
                                compactMode
                                :columns="columns"
                                :rows="items"
                                mode="remote"
                                :search-options="{
                                 externalQuery: params.keyword,
                            }"
                                @on-search="onSearch"
                                @on-page-change="onPageChange"
                                @on-sort-change="onSortChange"
                                @on-per-page-change="onPerPageChange"
                                :totalRows="pages.count"
                                :pagination-options="{
                  ...this.defaultTableOpts,
                  perPage:this.params.perPage,
                }">
                            <template slot="table-row" slot-scope="props">
                                <div v-if="props.column.field === 'preview'">
                                    <img class="thumb thumb-round" :src="props.row.thumb_128"
                                         :alt="props.row.quiz_name">
                                </div>
                                <div v-else-if="props.column.field === 'operation'">
                                    <a target="_blank" :href="URL.SITE + 'quiz/start/'+ props.row.quiz_id"
                                       class="btn-action"><i class="fa fa-link"></i></a>
                                    <span v-if="_module('panel/quiz/edit')"
                                          @click="edit(props.row)"
                                          class="btn-action"><i class="fa fa-edit"></i></span>
                                    <span v-if="_module('panel/quiz/delete')"
                                          @click="remove(props.row,props.index)"
                                          class="btn-action"><i
                                            class="fa fa-trash"></i></span>
                                </div>
                                <div v-else-if="props.column.field === 'status'">
                  <span class="badge-status"
                        :class="props.row.status">{{ LANG.quiz.status[props.row.status] }}</span>
                                </div>
                                <div v-else>
                                <span :class="props.column.style">
                                    {{ props.formattedRow[props.column.field] }}
                                </span>
                                </div>
                            </template>
                            <div slot="emptystate">
                                <div class="empty-data">
                                    {{ LANG.panel.empty_table }}
                                </div>
                            </div>
                            <template slot="loadingContent">
                                <div class="loading-message spinner"></div>
                            </template>

                        </vue-good-table>
                    </div>
                </div>
            </div>
        </simplebar>

        <advanced-search v-if="_module('panel/quiz/search')" @close="drawerName=null" :option="advancedSearchParams"
                         @search="advancedSearch"
                         :open="drawerName==='search'"></advanced-search>
    </div>
</template>

<script>

    import AdvancedSearch from "./advanced-search.vue";

    export default {
        components: {AdvancedSearch},
        data() {
            return {
                isLoading: false,
                drawerName: null,
                items: [],
                pages: [],
                params: {
                    keyword: null,
                    page: 1,
                    status: 'all',
                    isSearch: false,
                    perPage: 10,
                    sort: {
                        field: '',
                        type: '',
                    },
                },
                advancedSearchParams: null,
            }
        },
        computed: {
            columns() {
                return [
                    {
                        label: this.LANG.panel.id,
                        field: 'quiz_id',
                    },
                    {
                        label: this.LANG.quiz.quiz_name,
                        field: 'quiz_name',
                    },
                    {
                        label: this.LANG.quiz.author,
                        field: 'full_name',
                    },
                    {
                        label: this.LANG.panel.status,
                        field: 'status',
                        style: 'light',
                    },
                    {
                        label: this.LANG.panel.operation,
                        field: 'operation',
                        style: 'operation',
                        sortable: false,
                    },
                ];
            }
        },
        methods: {
            getItems() {
                this.$http.post(this.URL.API + 'quiz/getItems/', this.params).then((json) => {
                    this.items = json.data.items;
                    this.pages = json.data.pages;
                });
            },
            updateParams(newProps) {
                this.params = Object.assign({}, this.params, newProps);
            },
            onPageChange(params) {
                this.updateParams({page: params.currentPage});
                this.getItems();
            },
            onPerPageChange(params) {
                this.updateParams({perPage: params.currentPerPage});
                this.getItems();
            },
            onSearch(params) {
                this._delay(() => {
                    this.updateParams({keyword: params.searchTerm});
                    this.getItems();
                }, 500);
            },
            edit(row) {
                this.$router.replace({name: 'quiz-edit', params: {quiz_id: row.quiz_id}});
            },
            remove(row, index) {
                let params = {quiz_id: row.quiz_id};
                this._confirm(this.LANG.panel.are_you_sure_to_delete, () => {
                    this.$http.post(this.URL.API + 'quiz/delete/', params).then((json) => {
                        if (this._messageResponse(json.data)) {
                            this.$delete(this.items, index)
                        }
                    });
                });
            },
            onSortChange(params) {
                let first = params.slice(0, 1).shift();
                this.updateParams({
                    sort: {
                        type: first.type,
                        field: first.field,
                    },
                });
                this.getItems();
            },
            filter(param) {
                this.updateParams({status: param});
                this.getItems();
            },
            cancelAdvancedSearch() {
                this.advancedSearchParams = null;
                this._resetInitialData('params');
                this.getItems();
            },
            advancedSearch(params) {
                this.advancedSearchParams = params;
                this.params = {
                    ...this.params,
                    ...params,
                };
                this.getItems();
            },
        },
    }
</script>