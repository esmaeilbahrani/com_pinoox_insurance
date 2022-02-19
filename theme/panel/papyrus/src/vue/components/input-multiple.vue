<template>
  <div class="input-multiple">
    <div class="input-group" v-for="(item,index) in value">
      <div class="multiple-item" :class="offMultiple? 'off' : ''">
        <span class="number">{{ index + 1 }}</span>
        <input type="text" class="input" v-model="item.value" :placeholder="LANG.quiz.enter_option">
        <span @click="activeItem(index, item)" class="check" :class="!!item.active? 'active' : ''"><i
            class="fa fa-check"></i></span>
      </div>
      <span v-if="!!item.delete && !offMultiple" @click="removeItem(index, item)" class="delete"><i class="fa fa-trash"></i></span>
    </div>
    <div class="add" v-if="!offMultiple">
      <span class="btn btn-outline-primary" @click="addItem()"><i class="fa fa-plus"></i> {{ LANG.panel.add }} </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      default: [],
    },
    offMultiple: {
      type: Boolean,
      default: false,
    }
  },
  created() {
  },
  data() {
    return {}
  },
  methods: {
    addItem() {
      this.value.push({
        value: '',
        delete: true,
        active: false,
      });
    },
    removeItem(index, item) {
      let isActive = !!item.active;

      this.$delete(this.value, index);
      if (isActive) {
        this.value[0].active = true;
      }
    },
    activeItem(index, item) {
      let isActive = !!item.active;
      if (isActive)
        return;

      this.value.map(item => item.active = false);
      this.value[index].active = true;
      this.$emit('answer', index + 1);
    }
  }
}
</script>