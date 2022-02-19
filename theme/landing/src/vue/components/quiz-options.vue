<template>
    <div class="quiz-list">

        <div class="q-item"
             v-for="(i,index) in items"
             @click="select(i,index)"
             :class="{'selected': i.selected}"
        >
            <div class="text">{{i.value}}</div>
            <div class="icon">
                <i :class="[i.selected  ? 'fas fa-check-circle' : 'far fa-circle' ]"></i>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['items'],
        data() {
            return {}
        },
        methods: {
            select(item, index) {
                this.reset();
                this.$set(this.items[index], 'selected', true);
                this.$emit('onAnswer', this.items[index]);
            },
            reset() {
                const index = this.items.findIndex(i => i.selected == true);
                if (index > -1) {
                    this.$set(this.items[index], 'selected', false);
                }

            }
        }
    }
</script>