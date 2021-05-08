<template>
    <div>
        <div class="incoming_msg" v-if="user.id != message.user_id">
            <div class="incoming_msg_img"> 
                <img :src="getProfilePhoto(message.user.photo)" alt="avatar"> 
            </div>
            <div class="received_msg" >
                <div class="received_withd_msg">
                    <p>{{message.message}}</p>
                    <span class="time_date"> {{message.created_at | historyDate}}</span>
                </div>
            </div>
        </div>
        <div class="outgoing_msg" v-else>
            <div class="float-right"> 
                <img :src="getProfilePhoto(message.user.photo)" alt="avatar" style="border-radius: 50%;overflow: hidden;max-width: 45px;max-height: 45px;margin-left: 10px;"> 
            </div>
            <div class="sent_msg">
                <p>{{message.message}}</p>
                <span class="time_date"> {{message.created_at | historyDate}}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                user: new Form({
                    id:'',
                    name : '',
                    email: '',
                    password: '',
                    type: '',
                    photo: ''
                })
            }
        },
        methods: {
            getProfilePhoto(photo) {
                return (photo == null) ? "admin/images/icon/profile.png" 
                            : "img/profile/"+ photo ;
  
            },
        },
        created() {
            if(window.user != undefined) {
                this.user = window.user
            }
        },
    }
</script>

<style scoped>
.incoming_msg {
    margin-left: 18px;
}
.incoming_msg_img {
	display: inline-block;
	width: 6%;
}

.incoming_msg_img > img {
    max-width: 45px;
    max-height: 45px;
    border-radius: 50%;
    overflow: hidden;
    margin-right:10px;
}
.received_msg {
	display: inline-block;
	padding: 0 0 0 10px;
	vertical-align: top;
	width: 92%;
}
.received_withd_msg p {
	background: #ebebeb none repeat scroll 0 0;
	border-radius: 0 15px 15px 15px;
	color: #646464;
	font-size: 14px;
	margin: 0;
	padding: 5px 10px 5px 12px;
	width: 100%;
}
.time_date {
	color: #747474;
	display: block;
	font-size: 12px;
	margin: 8px 0 0;
}

.received_withd_msg {
	width: 57%;
}
.sent_msg p {
	background:#0465ac;
	border-radius: 12px 15px 15px 0;
	font-size: 14px;
	margin: 0;
	color: #fff;
	padding: 5px 10px 5px 12px;
	width: 100%;
}

.outgoing_msg {
	overflow: hidden;
	margin: 26px 0 26px;
}

.sent_msg {
	float: right;
	width: 46%;
}
</style>