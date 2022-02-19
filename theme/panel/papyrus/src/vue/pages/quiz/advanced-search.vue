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
          <div class="text">
            {{ LANG.panel.advanced_search }}
          </div>
        </div>
      </div>
      <div class="drawer-content" @keyup.enter="search()">
        <row :gutter="12" :columns="2" class="col-sm-order">

          <column :sm="2" :md="1" class="order-1">
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
                       @focus="drawerName = 'category'"
                       :placeholder="LANG.panel.category" class="input drawer-toggler">
              </div>
            </div>
            <div class="input-wrapper">
              <label class="input-label">{{ LANG.panel.status }}</label>
              <div class="input-group">
                <v-select
                    multiple=""
                    class="v-select-custom"
                    :placeholder="LANG.quiz.quiz_status"
                    dir="rtl"
                    v-model="params.status"
                    label="label"
                    :options="statusList">
                  <template v-slot:option="option">
                    <span>{{ option.label }}</span>
                  </template>
                  <div slot="no-options"><span class="no-options">{{ LANG.panel.no_options }}</span></div>
                </v-select>
              </div>
            </div>
          </column>
        </row>
      </div>
      <div slot='footer' class="drawer-footer">
        <div @click="closeDrawer()" class="btn btn-simple">{{ LANG.panel.close }}</div>
        <div class="btn btn-primary" @click="search()">{{ LANG.panel.search }}</div>
      </div>
    </ch-drawer>

    <category-select :open="drawerName==='category'"
                     v-model="params.category"
                     @onClose="drawerName=null"></category-select>
  </section>
</template>

<script>
import CategorySelect from "../../drawers/category-select.vue";

export default {
  components: {CategorySelect},
  props: ['open', 'option'],
  data() {
    return {
      drawerName: null,
      params: {
        isSearch: true,
        quiz_name: null,
        category: null,
        status: null,
      },
    }
  },
  computed: {
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
  },
  methods: {
    closeDrawer() {
      this.$emit('close', false);
    },
    search() {
      this.$emit('search', this.params);
      this.closeDrawer();
    },
    openDrawer() {
      this._resetInitialData();
      if (!!this.option) {
        this.params = {...this.option};
      }
    },
  },
}
</script>