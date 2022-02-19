<template>
    <div class="quiz-descriptive">

        <textarea v-model="message" @keyup="write(e)" rows="5" placeholder="پاسخ را اینجا بنویسید..."></textarea>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: null,
            }
        },
        methods: {
            write() {
                this.$emit('onReply', this.message);
            }
        }
    }
</script>