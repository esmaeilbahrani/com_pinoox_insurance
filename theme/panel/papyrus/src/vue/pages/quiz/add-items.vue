<template>
  <section>
    <ch-drawer custom-class="drawer-wrapper"
               location="bottom"
               :visible="open"
               :destroy-on-close="true"
               :blur="false"
               area="90%"
               @open="openDrawer"
               @close="closeDrawer">
      <div slot='header' class="drawer-header">
        <div class="title">
          <div class="text">{{ LANG.panel.add }}</div>
          <div class="subtext">{{ LANG.quiz.add_question }}</div>
        </div>
      </div>
      <div class="drawer-content">
        <div class="menus setting">
          <div v-for="m in filterMenu" @click="addItem(m)" class="item" :to="m.url">
            <b :class="m.icon" v-if="!!m.icon"></b>
            <simple-svg :src="m.image" v-else
                        :customClassName="m.customClass"
                        fill="#A5B8CE"/>
            <span class="text">{{ m.label }}</span>
          </div>
        </div>
      </div>
      <div slot='footer' class="drawer-footer">
        <div>
          <div @click="closeDrawer()" class="btn btn-simple">{{ LANG.panel.close }}</div>
        </div>
      </div>

    </ch-drawer>

  </section>
</template>

<script>

export default {
  props: ['open'],
  data() {
    return {
      drawerPosition: 'bottom',
      drawerArea: '90%',
      keyword: '',
    }
  },
  computed: {
    filterMenu() {
      return this.menu.filter((item) => {
        if (!!item.link && !this._module(item.link))
          return false;

        return this.keyword.toLowerCase().split(' ').every(v => item.label.toLowerCase().includes(v))
      })
    },
    menu() {
      return [
        {
          label: this.LANG.quiz.multiple_choice,
          icon: 'fa fa-ballot-check',
          type: 'multiple',
        },
        {
          label: this.LANG.quiz.verification_choice,
          icon: 'fa fa-toggle-on',
          type: 'verification',
        },
        {
          label: this.LANG.quiz.descriptive,
          icon: 'fa fa-file-alt',
          type: 'descriptive',
        },
      ];
    },
    questionDefault() {
      return {
        question: '',
        answer: null,
        type: 'multiple',
        isBody: false,
        body: null,
      }
    },
    typesDefault() {
      return {
        multiple: {
          options: [
            {
              value: '',
              delete: false,
              active: true,
            },
            {
              value: '',
              delete: false,
              active: false,
            }
          ],
        },
        verification: {
          options: [
            {
              value: '',
              delete: false,
              active: true,
            },
            {
              value: '',
              delete: false,
              active: false,
            }
          ],
        },
      }
    },
  },
  methods: {
    closeDrawer() {
      this.$emit('close', false);
    },
    openDrawer() {
    },
    addItem(item) {
      let type = item.type;
      let question = this._clone(this.questionDefault);
      question.type = type;
      if (!!this.typesDefault[type])
        question.body = this.typesDefault[type];

      console.log(type);
      if (type === 'multiple' || type === 'verification')
        question.answer = 1;

      this.$emit('add', question);
      this.closeDrawer();
    }
  },
}
</script>
