<template>
    <div class="container" style="min-height:500px;">
        <div v-if="chatRooms != ''">
            <!-- <chat-room-selection
                v-if="currentRoom.id"
                :rooms="chatRooms"
                :currentRoom="currentRoom"
                v-on:roomchanged="setRoom( $event )"
                style="display:none"
            ></chat-room-selection> -->


            <div class="messaging">
                <div class="message-title">
                    <p>Nhắn tin cho quản trị viên</p>  
                </div>
                <div class="inbox_msg" style="padding-top: 10px;padding-bottom: 46px;">
                    <div class="mesgs">

                        <message-container :messages="messages"></message-container>

                        <div class="type_msg">

                            <input-message :room="currentRoom" v-on:messagesent="getMessages()"></input-message>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    import MessageContainer from './MessageContainer';
    import InputMessage from './InputMessage';
    import ChatRoomSelection from './ChatRoomSelection';

    export default {
        components: {
            MessageContainer,
            InputMessage,
            ChatRoomSelection
        
        },
        data() {
            return {
                chatRooms: [],
                currentRoom: [],
                messages: [],
                user_id: ''
            }
        },
        watch: {
            currentRoom(oldVal) {
                if(oldVal.id) {
                    this.disconnect(oldVal);
                }
                this.connect();
            }
        },
        methods: {
            connect() {
                if(this.currentRoom.id) {
                    let vm = this;
                    this.getMessages();
                    window.Echo.private("chat."+this.currentRoom.id)
                    .listen('.message.new', (e) => {
                        vm.getMessages();
                    });
                }
            },
            disconnect(room) {
                window.Echo.leave("chat."+room.id);
            },
            getRoom() {
                axios.get('api/chat/room/'+this.user_id)
                .then(response => {
                    this.chatRooms = response.data;
                    this.setRoom( response.data );

                    if(this.chatRooms == "") {
                        swal.fire({
                            title: 'Bạn chưa có cuộc hội thạo nào?',
                            text: "Bạn có muốn tạo một cuộc hội thạo ngay bây giờ không!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Đồng ý'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                axios.post('api/chat/newRoom/'+this.user_id)
                                .then(() => {
                                    swal.fire(
                                        'Bạn đã tạo thành công!',   
                                        '',
                                        'success'
                                    )
                                    location.reload();
                                })
                                .catch(error => {
                                    console.log(error);
                                });
                                
                            }
                        })
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
            setRoom(room) {
                this.currentRoom = room;
            
            },
            getMessages() {
                axios.get('api/chat/room/'+this.currentRoom.id+'/messages')
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
            }
            
        },
        created() {
            
            if(window.user != undefined) {
                this.user_id = window.user.id
                this.getRoom();
            }
            
        }
    }
</script>

<style scoped>
.inbox_msg {
	border: 1px solid #ddd;
	clear: both;
	overflow: hidden;
    position: relative;
}

.message-title {
    border: 1px solid #757575cc;
    background: linear-gradient(90deg, rgba(7,148,118,1) 43%, rgba(0,212,255,1) 100%);
    border-top-right-radius: 12px;
    border-top-left-radius: 12px;
}

.message-title >p {
    text-align: center;
    font-size: 20px;
    color: white;
    margin-top: 15px;
}

.mesgs{
	float: left;
    overflow-y: auto;
    height: 500px;
    width: 100%;
}

.messaging {
	padding: 0 0 50px 0;
}

</style>