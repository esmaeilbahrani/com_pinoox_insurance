<template>
  <section class="page" id="quiz-form">
    <div class="menubar">
      <div class="items">
        <div v-if="isEdit && !isPublish" class="item publish-item" @click="publish()">
          {{ LANG.quiz.publish }}
        </div>
        <div v-if="isEdit && isPublish" class="item publish-item cancel" @click="cancelPublish()">
          {{ LANG.quiz.cancel_publish }}
        </div>
        <div class="item" @click="save(null,true)">
          {{ LANG.post.save }}
        </div>
        <div class="item" @click="openDrawer('category')">
          {{ LANG.post.category }}
          {{ !!params.category && !!params.category.cat_name ? '(' + params.category.cat_name + ')' : '' }}
        </div>
      </div>
    </div>
    <div class="toolbar-tabs">
      <div class="item status">
        {{ LANG.quiz.quiz_status }} :
        <span class="badge-status" :class="status">{{ LANG.quiz.status[status] }}</span>
      </div>
      <div class="item"
           :class="{ 'active': tabActive === 'info' }"
           @click="setActiveTab('info')">
        <i class="fas fa-info-circle"></i> <span>{{ LANG.quiz.info_quiz }}</span>
      </div>
      <div class="item"
           :class="{ 'active': tabActive === 'questions' }"
           @click="setActiveTab('questions')">
        <i class="fas fa-clipboard-list"></i> <span>{{ LANG.quiz.questions }}</span>
      </div>
    </div>

    <simplebar class="simplebar">
      <div class="container animate__animated animate__slideInDown">

        <section-info @drawer="openDrawer" v-if="tabActive === 'info'"></section-info>
        <section-questions v-if="tabActive === 'questions'"></section-questions>

      </div>
    </simplebar>
    <category-select :open="drawerName === 'category'"
                     v-model="params.category"
                     type="off"
                     @onClose="openDrawer(null)"></category-select>
  </section>
</template>

<script>


import CategorySelect from "../../drawers/category-select.vue";
import SectionQuestions from "./section-questions.vue";
import SectionInfo from "./section-info.vue";
import {mapActions} from 'vuex';
import {mapFields} from 'vuex-map-fields';

export default {
  components: {SectionInfo, SectionQuestions, CategorySelect},
  props: ['quiz_id'],
  created() {
    this.resetQuizParams();
    if (this.isEdit) {
      this.getQuizById();
    }
  },
  data() {
    return {
      drawerName: null,
      tabActive: 'info',
      status: 'draft',
    }
  },
  computed: {
    ...mapFields('quiz', ['params']),
    isEdit() {
      return !!this.quiz_id;
    },
    isPublish() {
      return this.status === 'publish' || this.status === 'pending';
    },
  },
  methods: {
    ...mapActions('quiz', ['resetQuizParams', 'updateQuizParams']),
    openDrawer(drawerName) {
      this.drawerName = drawerName;
    },
    setActiveTab(tabName) {
      this.tabActive = tabName;
    },
    save() {
      this.params['quiz_id'] = this.quiz_id;
      return this.$http.post(this.URL.API + 'quiz/save/', this.params).then((json) => {
        if (this._messageResponse(json.data)) {
          this.status = this.params.status;
          let quiz_id = json.data.result;
          if (!this.isEdit && !!quiz_id)
            this.$router.replace({name: 'quiz-edit', params: {quiz_id: quiz_id}});
        }
      });
    },
    getQuizById() {
      return this.$http.get(this.URL.API + 'quiz/getById/' + this.quiz_id).then((json) => {
        if (json.data != null) {
          this.updateQuizParams(json.data);
          this.status = json.data.status;
        } else {
          this.$router.replace({name: 'err404'});
        }
      });
    },
    publish() {
      if (this._option('manage_quiz')) {
        this.params.status = 'publish';
      } else {
        this.params.status = 'pending';
      }
      this.save();
    },
    cancelPublish() {
      this.params.status = 'draft';
      this.save();
    },
  }
}
</script>