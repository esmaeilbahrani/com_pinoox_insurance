<template>
    <div>
        <div class="questions-section" v-if="this.params.questions.length > 0">
            <div class="question-tabs">
                <ul class="section-tab">
                    <li @click="isSortable = false"
                        :class="[!isSortable ? 'active' :'' ]"> {{ LANG.quiz.manage_questions }}
                    </li>
                    <li @click="isSortable = true"
                        :class="[isSortable ? 'active' :'' ]"> {{ LANG.quiz.sort_questions }}
                    </li>
                </ul>
            </div>
            <row :gutter="12" :columns="1">
                <column :sm="1" :md="1">

                    <draggable
                            :scroll-sensitivity="200"
                            :force-fallback="true"
                            :list="items"
                            :animation="10"
                            handle=".handle"
                            class="quiz-items"
                            ghost-class="ghost">
                        <div v-for="(item,index) in items" class="item">
                            <header>
                                <div class="item-head" :class="classItemHead(item)" @click="toggleBody(item,index)">
                                    <span v-if="isSortable"><i class="fa fa-arrows-alt"></i></span>
                                    <span class="number">{{ index + 1 }}</span>
                                    <span v-if="!!item.question"> {{ item.question }}</span>
                                    <span v-else class="placeholder"> {{ LANG.quiz.no_question_here }}</span>
                                    <div class="options" v-if="!isSortable">
                                        <span class="type">{{ LANG.quiz.types[item.type] }}</span>
                                    </div>
                                </div>
                                <span class="delete" @click.prevent="deleteItem(index,item)"><i class="fa fa-trash"></i></span>
                            </header>
                            <quiz-types v-model="items[index]" @close="item.isBody = false"
                                        v-if="!isSortable && !!item.isBody"
                                        class="item-body"></quiz-types>
                        </div>
                    </draggable>

                    <div class="add-items">
              <span class="btn btn-primary" @click="openDrawer('add-item')"><i
                      class="fa fa-plus"></i> {{ LANG.panel.add }}</span>
                    </div>
                </column>
            </row>
        </div>
        <div class="empty-questions" v-else>
            <span class="text">{{ LANG.quiz.message_empty_questions }}</span>
            <span class="link" @click="openDrawer('add-item')">{{ LANG.quiz.add_question }}</span>
        </div>

        <add-items @add="addItem" @close="openDrawer(null)"
                   :open="drawerName === 'add-item'"></add-items>
    </div>
</template>

<script>

    import AddItems from "./add-items.vue";
    import QuizTypes from "./quiz-types.vue";
    import {mapFields} from "vuex-map-fields";

    export default {
        components: {QuizTypes, AddItems},
        computed: {
            ...mapFields('quiz', ['params']),
            items: {
                get() {
                    return this.params.questions;
                },
                set(val) {
                    this.params.questions = val;
                },
            },
        },
        data() {
            return {
                drawerName: null,
                isSortable: false,
            }
        },
        methods: {
            openDrawer(drawerName) {
                this.drawerName = drawerName;
            },
            toggleBody(item, index) {
                if (this.isSortable)
                    return;

                item.isBody = !item.isBody;
            },
            classItemHead(item) {
                if (this.isSortable)
                    return 'handle';

                return !!item.isBody ? 'active' : '';
            },
            addItem(question) {
                this.items.push(this._clone(question));
            },
            deleteItem(index, item) {
                this._confirm(this.LANG.panel.are_you_sure_to_delete, () => {
                    this.$delete(this.items, index);
                });
            },
        }
    }
</script>