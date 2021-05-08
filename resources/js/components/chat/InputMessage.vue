<template>
    <div class="input_msg_write">

        <input type="text" class="write_msg" placeholder="Aa" 
                v-model="message" @keyup.enter="sendMessage()"
        />
        <button class="msg_send_btn" @click="sendMessage()">
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
        </button>
        
    </div>
</template>

<script>
    export default {
        props: ['room'],
        data() {
            return {
                message: ''
            }
        },
        methods: {
            sendMessage() {
                if(this.message == '') {
                    return ; 
                }

                axios.post('api/chat/room/'+this.room.id+'/message', {
                    message: this.message
                })
                .then(response => {
                    if(response.status == 201) {
                        this.message = '';
                        this.$emit('messagesent');
                    }
                    
                })
                .catch(error => {
                    console.log(error);
                })
            }
        },
    }
</script>

<style scoped>
.input_msg_write {
    position: absolute;
    bottom: 0;
    width: 100%;
    overflow: hidden;
    border-top: 1px solid black;
}

.input_msg_write input {
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    color: #000000;
    font-size: 15px;
    min-height: 48px;
    outline: none;
    width: 90%;
    padding-left: 17px;
}
.msg_send_btn {
	background: #05728f none repeat scroll 0 0;
    border: none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 17px;
    height: 37px;
    position: absolute;
    right: 0;
    top: 3px;
    width: 37px;
    margin-right: 27px;
    line-height: 37px;
}
</style>