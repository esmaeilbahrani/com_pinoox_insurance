<template>
  <row :gutter="12" :columns="2">
    <column :sm="2" :md="2">
      <div class="input-wrapper">
        <label class="input-label">{{ LANG.quiz.options }}</label>
        <input-multiple v-model="value.body.options" @answer="setAnswer"></input-multiple>
      </div>
    </column>
  </row>
</template>

<script>
import InputMultiple from "../../../components/input-multiple.vue";

export default {
  components: {InputMultiple},
  props: {
    value: {
      default: {},
    },
  },
  data() {
    return {}
  },
  methods: {
    setAnswer(answer) {
      this.value.answer = answer;
    }
  }
}
</script>
