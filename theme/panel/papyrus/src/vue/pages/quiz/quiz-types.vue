<template>
  <div class="section">
    <div class="section-content">
      <row :gutter="12" :columns="1">
        <column :sm="1" :md="1">
          <div class="input-wrapper">
            <label class="input-label">{{ LANG.quiz.question_or_description }}</label>
            <div class="input-group">
                  <textarea class="input"
                            v-model="value.question" :placeholder="LANG.quiz.enter_question"></textarea>
            </div>
          </div>
        </column>
      </row>
      <multiple v-if="value.type === 'multiple'" v-model="value"></multiple>
      <descriptive v-if="value.type === 'descriptive'" v-model="value"></descriptive>
      <verification v-if="value.type === 'verification'" v-model="value"></verification>
    </div>
    <div class="section-footer">
      <span class="btn btn-simple" @click="close()">
                {{ LANG.panel.close }}
              </span>
    </div>
  </div>
</template>

<script>
import Multiple from "./types/multiple.vue";
import Descriptive from "./types/descriptive.vue";
import Verification from "./types/verification.vue";

export default {
  components: {Verification, Descriptive, Multiple},
  props:{
    value:{
      default:null,
    },
  },
  data(){
    return{
    }
  },
  methods: {
    close() {
      this.$emit('close');
    }
  }
}
</script>