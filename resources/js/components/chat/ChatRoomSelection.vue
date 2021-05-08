<template>
  <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
    <div class="au-card-title">
      <div class="bg-overlay bg-overlay--blue"></div>
      <h3><i class="zmdi zmdi-comment-text"></i>Danh sách tin nhắn</h3>
    </div>
    <div class="au-inbox-wrap">
      <div class="au-message js-list-load">
        <div class="au-message__noti">
          <!-- <p>You Have <span>2</span> new messages</p> -->
        </div>
        <div class="au-message-list">
          <ul style="list-style: none;">
            <li v-for="(room, index) in chatRooms" :key="index"  @click="selectRoom(room)" :class="{ 'selected': room == selected }"> 
              <div class="au-message__item">
                <div class="au-message__item-inner">
                  <div class="au-message__item-text">
                    <div class="avatar-wrap">
                      <div class="avatar">
                        <img :src="getProfilePhoto(room.user.photo)" alt="avatar" style="border-radius: 50%;overflow: hidden;max-width: 45px;max-height: 45px;"> 
                      </div>
                    </div>
                    <div class="text">
                      <div class="row">
                        <div class="col-md-6">
                          <h5 class="name">{{room.user.name}}</h5>
                        </div>
                        <div class="col-md-6 float-right">
                          <div v-for="(message, stt) in room.messages" :key="stt">
                            <span v-if="room.messages.length-1 == stt">{{ message.created_at | historyDay}}</span>
                          </div>
                        </div>
                      </div>
                      
                      <div v-for="(message, stt) in room.messages" :key="stt">
                        <div v-if="room.messages.length-1 == stt">
                          <p v-if="message.user_id == user.id">Bạn: {{ message.message }}</p>
                          <p v-else class="read"> {{ message.message }}</p>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
      props: ['chatRooms', 'currentRoom'],
      data() {
          return {
              selected: '',
              user: new Form({
                id:'',  name : '',  email: '',  type: '', photo: ''
              })
          }
      },
      created() {
        this.selected = this.currentRoom;

        if(window.user != undefined) {
          this.user = window.user
        }
    
      },
      methods: {
        getProfilePhoto(photo) {
          return (photo == null) ? "admin/images/icon/profile.png" 
                            : "img/profile/"+ photo ;
  
        },
        selectRoom(room) {
          this.selected = room;
          this.$emit('roomchanged', this.selected);
        }
      },
  }
</script>

<style scoped>
.au-card {
  border-top-right-radius: 0px;
  border-bottom-right-radius: 0px;
}
.bg-overlay {
  border-radius: 0px;
}
.au-message-list {
  height: 567px !important;
  overflow-x: hidden;
}
.au-message__item-text {
  width: 100% !important;
}
.au-message__item-inner {
  padding: 25px 10px !important;
}
.au-card-title {
  padding-top: 20px !important;
  padding-bottom: 20px !important;
}

.selected{ 
  background:#b3e4e6a1;
  border-left: 3px solid #999;
}
.read {
  color: #0087fb !important;
}
</style>