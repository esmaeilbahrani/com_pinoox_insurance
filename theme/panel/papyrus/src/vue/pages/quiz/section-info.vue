<template>
  <div class="section">
    <div class="section-header">
      <h2 class="title">{{ LANG.quiz.info_quiz }}</h2>
    </div>
    <div class="section-content">
      <row :gutter="12" :columns="2">
        <column :sm="2" :md="1">
          <div class="input-wrapper">
            <label class="input-label">{{ LANG.quiz.quiz_name }}</label>
            <div class="input-group">
              <input v-model="params.quiz_name" type="text"
                     :placeholder="LANG.quiz.quiz_name" class="input">
            </div>
          </div>
          <div class="input-wrapper">
            <label class="input-label">{{ LANG.panel.category }}</label>
            <div class="input-group">
              <input :value="!!params.category? params.category.cat_name : ''" type="text"
                     @focus="openDrawer('category')"
                     :placeholder="LANG.panel.category" class="input drawer-toggler">
            </div>
          </div>
          <div class="input-wrapper" v-if="_option('manage_quiz')">
            <label class="input-label">{{ LANG.panel.status }}</label>
            <div class="input-group">
              <v-select
                  class="v-select-custom"
                  :placeholder="LANG.quiz.select_status"
                  dir="rtl"
                  :clearable="false"
                  v-model="status"
                  label="label"
                  :options="statusList">
                <template v-slot:option="option">
                  <span>{{ option.label }}</span>
                </template>
                <div slot="no-options"><span class="no-options">{{ LANG.quiz.no_options }}</span>
                </div>
              </v-select>
            </div>
          </div>
        </column>
        <column :sm="2" :md="2">
          <div class="input-wrapper">
            <label class="input-label">{{ LANG.quiz.quiz_description }}</label>
            <div class="input-group">
              <textarea class="input"
                        v-model="params.quiz_description" :placeholder="LANG.quiz.quiz_description" rows="4"></textarea>
            </div>
          </div>
        </column>
      </row>
    </div>
  </div>
</template>

<script>

import {mapFields} from "vuex-map-fields";

export default {
  computed: {
    ...mapFields('quiz', ['params']),
    statusList() {
      let items = [];
      let status = this.LANG.quiz.status;
      for (let key in status) {
        let label = status[key];
        items.push({
          key: key,
          label: label
        });
      }
      return items;
    },
    status: {
      get() {
        let status = this.params.status;
        if (typeof status === 'object') {
          return status;
        } else {
          return {
            key: status,
            label: this.LANG.quiz.status[status],
          }
        }
      },
      set(val) {
        this.params.status = (typeof val === 'object') ? val.key : val;
      },
    },
  },
  data() {
    return {}
  },
  methods: {
    openDrawer(name) {
      this.$emit('drawer', name);
    }
  }
}
</script>