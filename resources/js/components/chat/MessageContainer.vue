<template>
    <div class="msg_history" ref="msg_history">
        <div v-for="(message, index) in messages" :key="index">
            <message-item :message="message"></message-item>
        </div>
    </div>
    
</template>

<script>
    import MessageItem from './MessageItem'
    export default {
        components: { MessageItem },
        props: ['messages'],
        methods: {
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.msg_history.scrollTop = this.$refs.msg_history.scrollHeight - this.$refs.msg_history.clientHeight;
                }, 50);
            }
        },
        watch: {
            messages() {
                this.scrollToBottom();
            }
        }
    }
</script>

<style scoped>
.msg_history {
    overflow-y: auto;
    height: 500px;
}
</style>
