<template>

    <div class="container" style="min-height:500px;">
        <div style="float: left; width: 40%;" >
            <chat-room-selection
                v-if="currentRoom.id"
                :chatRooms="chatRooms"
                :currentRoom="currentRoom"
                v-on:roomchanged="setRoom( $event )"
            ></chat-room-selection>
        </div>
        <div style="float: left; width: 60%;" >
            <div class="messaging">
                <div class="inbox_msg" style="padding-bottom: 46px;">
                    <div class="header-message">
                        <img :src="getImgUser(chatUser.photo)" alt="avartar"> {{chatUser.name}}
                    </div><br>
                    <div class="mesgs">

                        <message-container :messages="messages"></message-container>

                        <div class="type_msg" style="margin-bottom: 9px;">

                            <input-message :room="currentRoom" v-on:messagesent="getMessages()"></input-message>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    import MessageContainer from '../chat/MessageContainer';
    import InputMessage from '../chat/InputMessage';
    import ChatRoomSelection from '../chat/ChatRoomSelection';

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
                chatUser: {}
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
                axios.get('api/chat/roomAll')
                .then(response => {
                    this.chatRooms = response.data;
                    this.setRoom( response.data[0] );
                })
                .catch(error => {
                    console.log(error);
                });
            },
            setRoom(room) {
                this.currentRoom = room;
                this.chatUser = this.currentRoom.user;
            },
            getMessages() {
                axios.get('api/chat/room/'+this.currentRoom.id+'/messages')
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
            },
            getImgUser(photo) {
                if(photo != null) 
                    return 'img/profile/'+ photo;
                else
                    return 'admin/images/icon/profile.png';
            },
        },
        created() {
            this.getRoom();
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
    width: 100%;
}

.messaging {
	border: 1px solid #352e2e;
    border-top-right-radius: 10px;
    overflow: hidden;
    border-bottom-right-radius: 10px;
}
.header-message {
    padding-bottom: 11px;
    padding-left: 22px;
    font-size: 23px;
    color: black;
    font-family: cursive;
    padding-top: 10px;
    background: linear-gradient(90deg, rgba(106,203,91,0.8799894957983193) 43%, rgba(0,212,255,1) 100%);
    border-bottom: 1px solid #00b316;
}
.header-message img {
    max-width: 50px;
    border-radius: 50%;
    max-height: 50px;
    overflow: hidden;
}
</style>