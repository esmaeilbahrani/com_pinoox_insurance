<template>
  <div>
    <div class="input-wrapper" v-for="setting in settings" v-show="hidden(setting)">
      <label class="input-label">{{ setting.label }}</label>

      <!-- textarea view -->
      <div class="input-group" v-if="!!setting.type && setting.type === 'textarea'">
                                <textarea v-bind="getAttrs(setting)" class="input"
                                          v-model="value[setting.key]"></textarea>
      </div>

      <!-- toggle view -->
      <div class="input-group" v-else-if="!!setting.type && setting.type === 'toggle'">
        <toggle-button v-bind="getAttrs(setting)"
                       v-model="value[setting.key]"
                       :sync="true"
                       :width="70"
                       :labels="{checked: LANG.post.active, unchecked: LANG.post.inactive}"/>
      </div>

      <!-- select group view -->
      <div v-else-if="!!setting.type && setting.type === 'group'">
        <select-group :value="value[setting.key]" v-model="value[setting.key]"
                      v-bind="getAttrs(setting)"></select-group>
      </div>

      <!-- select view -->
      <div v-else-if="!!setting.type && setting.type === 'select'">
        <v-select
            class="input"
            dir="rtl"
            index="label"
            label="label"
            :options="options(setting)"
            :value="option(setting)"
            @input="select"
            v-bind="getAttrs(setting)">
          <template slot="no-options">
            {{ LANG.panel.nothing_found }}
          </template>
        </v-select>
      </div>
      <!-- list view -->
      <div v-else-if="!listDisable && !!setting.type && setting.type === 'list'">
        <span @click="_parent.openListDrawer(setting)" class="btn btn-list"><i
            class="fa fa-cog"></i> {{ LANG.panel.manage }} {{ setting.label }}</span>
      </div>

      <!-- form view -->
      <div v-else-if="!listDisable && !!setting.type && setting.type === 'form'">
        <span @click="_parent.openFormDrawer(setting)" class="btn btn-list"><i
            class="fa fa-cog"></i> {{ LANG.panel.manage }} {{ setting.label }}</span>
      </div>

      <!-- select post view -->
      <div v-else-if="!!setting.type && setting.type === 'select:post'">
        <select-post v-model="value[setting.key]" v-bind="getAttrs(setting)"></select-post>
      </div>

      <!-- image view -->
      <div v-else-if="!!setting.type && setting.type === 'image'" class="setting-image-view">
        <div class="select-image-setting" v-if="!value[setting.key]">
                    <span @click="openImageDrawer(setting)"
                          class="btn btn-sm btn-primary">{{ LANG.panel.select_image }}</span>
        </div>
        <div v-else>
          <img @click="openImageDrawer(setting)" class="thumb thumb-round" :src="imagePreview(setting)">
          <div>
                        <span class="btn btn-sm btn-primary"
                              @click="openImageDrawer(setting)">{{ LANG.panel.edit }}</span>
            <span @click="imageDelete(setting)" class="btn btn-sm btn-danger">{{ LANG.panel.delete }}</span>
          </div>
        </div>
      </div>

      <!-- category view -->
      <div v-else-if="!!setting.type && setting.type === 'category'">
        <span @click="openCategoryDrawer(setting)" class="btn btn-list"
              v-if="!!value[setting.key] && !!value[setting.key]['cat_name']"> {{ LANG.post.category }} ({{
            value[setting.key]['cat_name']
          }})</span>
        <span @click="openCategoryDrawer(setting)" class="btn btn-list" v-else>  {{ LANG.post.category }}</span>
      </div>

      <!-- color picker view -->
      <div v-else-if="!!setting.type && setting.type === 'color-picker'">
        <color-picker class="input" v-model="value[setting.key]" :color="value[setting.key]"
                      v-bind="getAttrs(setting)"></color-picker>
      </div>

      <!-- input view -->
      <div class="input-group" v-else>
        <input v-bind="getAttrs(setting)" v-model="value[setting.key]"
               :type="!!setting.type?setting.type : 'text'" class="input">
      </div>

      <span v-if="!!setting.help" class="sub-label">{{ setting.help }}</span>
    </div>

    <image-setting @close="imageDrawer = false" :open="imageDrawer"></image-setting>
    <category-select @onClose="categoryDrawer = false" :open="categoryDrawer"
                     :value="getCategory()"
                     @input="setCategory"
                     type="off"
    ></category-select>
  </div>
</template>

<script>
import SelectPost from "../../components/select-post.vue";
import ColorPicker from "../../components/color-picker.vue";
import ImageSetting from "./image-setting.vue";
import SelectGroup from "../../components/select-group.vue";
import CategorySelect from "../../drawers/category-select.vue";

export default {
  name: "form-builder",
  components: {CategorySelect, ImageSetting, SelectPost, ColorPicker, SelectGroup},
  props: {
    settings: {
      default: [],
    },
    value: {
      default: {},
    },
    parent: {
      default: null,
    },
    listDisable: {
      default: false,
    },

  },
  created() {
    this._parent = !!this.parent ? this.parent : this.$parent;
  },
  data() {
    return {
      imageDrawer: false,
      categoryDrawer: false,
      _parent: null,
      setting: null,
    }
  },
  computed: {
    params: {
      get() {
        return this.value;
      },
      set(val) {
        this.value = val;
      }
    }
  },
  methods: {
    openImageDrawer(setting) {
      this.setting = setting;
      this.imageDrawer = true;
    },
    openCategoryDrawer(setting) {
      this.setting = setting;
      this.categoryDrawer = true;
    },
    select(option) {
      this.value[option.setting_key] = option.key;
    },
    getCategory() {
      if (!!this.setting)
        return this.value[this.setting.key];
      else
        return null;
    },
    setCategory(category) {
      this.value[this.setting.key] = category;
    },
    option(setting) {
      let value = this.value[setting.key];
      let options = this.options(setting);
      return options.find(option => option.key === value);
    },
    options(setting) {
      return $.map(setting.options, function (value, index) {
        return {
          key: index,
          label: value,
          setting_key: setting.key,
        };
      });
    },
    hidden(setting) {
      if (!!setting.hiddenBy) {
        let key = setting.hiddenBy;
        return this.value[key];
      }

      return true;
    },
    getAttrs(setting) {
      let attrs = !!setting.attrs ? setting.attrs : {};
      if (!attrs.placeholder)
        attrs.placeholder = setting.label;
      return attrs;
    },
    imagePreview(setting) {
      let img = !!this.value[setting.key] ? this.value[setting.key] : 'resources/image-placeholder.jpg';
      return this.URL.APP_PATH + img;
    },
    imageDelete(setting) {
      this.value[setting.key] = null;
    }
  },
}
</script>