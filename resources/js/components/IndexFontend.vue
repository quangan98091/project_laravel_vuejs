<template>
    <div>
        <header class="navigation" style="padding-top: 0px;">
            <nav class="navbar navbar-expand-lg navbar-light">
                <router-link to="/" class="navbar-brand"  style="font-size: 33px;">
                    <strong>Share</strong><strong style="color: rgb(140 140 140);">Code</strong><em style="color: #ff6a00;">.</em>
                </router-link>
                <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navogation"
                aria-controls="navogation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-center" id="navogation">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <router-link to="/category" class="nav-link text-uppercase text-dark">Thể loại</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/discuss" class="nav-link text-uppercase text-dark">Thảo luận</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/recommend" class="nav-link text-uppercase text-dark">Giới thiệu</router-link>
                        </li>
                    </ul>
                    <div class="nav-item dropdown" v-if="user.id != ''">
                        <a href="#" class="nav-link text-uppercase text-dark dropdown-toggle" id="navUser"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img :src="getProfilePhoto()" alt="avatar" 
                                style="    max-width: 45px;border-radius: 50%;max-height: 45px;overflow: hidden;"> {{ user.name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navUser">
                            <router-link to="/user" class="dropdown-item">
                                <i class="fas fa-id-card" style="margin-right:10px;"></i>Thông tin cá nhân
                            </router-link>
                            <a class="dropdown-item" v-on:click="logout">
                                <i class="fas fa-sign-out-alt" style="margin-right:10px;"></i>Đăng xuất
                            </a>
                        </div>
                    </div>
                        <form class="form-inline position-relative ml-lg-4" style="margin-left: 3px !important;">
                        <input class="form-control search-home" type="text" placeholder="Tìm kiếm">
                            
                        <a href="search.html" class="search-icon"><i class="ti-search text-dark"></i></a>
                    </form>
                   
                </div>
            </nav>
        </header>


        <div class="main-contents">
            <router-view></router-view>

 





            <button class="btn-message" :class="{messageActive: !messageActive}" @click="messageActive = ! messageActive" v-show="messageActive">
               <i class="fab fa-facebook-messenger"></i>
            </button>
            <div class="card card-bordered" :class="{messageActive: messageActive}">
                <div class="card-header">
                    <h4 class="card-title"><strong>Chat</strong></h4> 
                    <button class="btn btn-secondary"  @click="messageActive = ! messageActive">
                        <i class="fas fa-times" style="font-size: 18px;color: black;"></i>
                    </button>
                </div>
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important;">
                        <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                            <div class="media-body">
                                <p>Hi</p>
                                <p>How are you ...???</p>
                                <p>What are you doing tomorrow?<br> Can we come up a bar?</p>
                                <p class="meta"><time datetime="2018">23:58</time></p>
                            </div>
                        </div>
                        <div class="media media-meta-day">Today</div>
                        <div class="media media-chat media-chat-reverse">
                            <div class="media-body">
                                <p>Hiii, I'm good.</p>
                                <p>How are you doing?</p>
                                <p>Long time no see! Tomorrow office. will be free on sunday.</p>
                                <p class="meta"><time datetime="2018">00:06</time></p>
                            </div>
                        </div>
                        <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                            <div class="media-body">
                                <p>Okay</p>
                                <p>We will go on sunday? </p>
                                <p class="meta"><time datetime="2018">00:07</time></p>
                            </div>
                        </div>
                        <div class="media media-chat media-chat-reverse">
                            <div class="media-body">
                                <p>That's awesome!</p>
                                <p>I will meet you Sandon Square sharp at 10 AM</p>
                                <p>Is that okay?</p>
                                <p class="meta"><time datetime="2018">00:09</time></p>
                            </div>
                        </div>
                        <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                            <div class="media-body">
                                <p>Okay i will meet you on Sandon Square </p>
                                <p class="meta"><time datetime="2018">00:10</time></p>
                            </div>
                        </div>
                        <div class="media media-chat media-chat-reverse">
                            <div class="media-body">
                                <p>Do you have pictures of Matley Marriage?</p>
                                <p class="meta"><time datetime="2018">00:10</time></p>
                            </div>
                        </div>
                        <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                            <div class="media-body">
                                <p>Sorry I don't have. i changed my phone.</p>
                                <p class="meta"><time datetime="2018">00:12</time></p>
                            </div>
                        </div>
                        <div class="media media-chat media-chat-reverse">
                            <div class="media-body">
                                <p>Okay then see you on sunday!!</p>
                                <p class="meta"><time datetime="2018">00:12</time></p>
                            </div>
                        </div>
                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                        </div>
                    </div>
                    <div class="publisher bt-1 border-light"> <img class="avatar avatar-xs" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="..."> <input class="publisher-input" type="text" placeholder="Write something"> <span class="publisher-btn file-group"> <i class="fa fa-paperclip file-browser"></i> <input type="file"> </span> <a class="publisher-btn" href="#" data-abc="true"><i class="fa fa-smile"></i></a> <a class="publisher-btn text-info" href="#" data-abc="true"><i class="fa fa-paper-plane"></i></a> </div>
                </div>








            
        </div>





        <footer class="bg-secondary">
            <div class="text-center pb-3" style="padding-top: 1rem!important;">
                <p class="mb-0">Copyright ©2021. <strong>Quang An</strong></p>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messageActive: true,
                search: '',
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
            getProfilePhoto() {
                let photo = (this.user.photo == null) ? "admin/images/icon/profile.png" : "img/profile/"+ this.user.photo ;
                return  photo;
            },
            logout(){
				axios.post('/logout').then(response => {
					location.reload();
				}).catch(error => {
					location.reload();
				});
			}
        },
        created() {
            if(window.user != undefined) {
               axios.get("api/profile")
                .then(
                    ({ data }) => (this.user.fill(data))
                )
                .catch(); 
            }
            

           
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>
.search-home {
    width: 100px !important;
    transition: width 0.4s ease-in-out;
}

.search-home:focus {
    width: 300px !important;
}
.btn-message {
    right: 0;
    position: fixed;
    bottom: 0px;
    border: 1px solid;
    background: #003de8;
    border-radius: 50%;
    width: 55px;
    height: 55px;
    line-height: 50px;
    color: white;
    font-size: 40px;
    margin-right: 18px;
    margin-bottom: 50px;
}
.btn-message:hover {
    color: #f8f9fa;
    background: black;
    transform: scale(1.1);
    transition: 0.3s;
}
.messageActive {
    display:none;
}

.card-bordered {
    border: 1px solid #ebebeb
}

.card {
    border: 0;
    bottom: 0;
    position: fixed;
    right: 0;
    width: 400px;
    margin: 0;
    padding: 0;
    height: 460px;
    border-radius: 10px;
    overflow: hidden;
    -webkit-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.03);
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.03);
    -webkit-transition: .5s;
    transition: .5s
}

.card-header:first-child {
    border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
    background: linear-gradient(90deg, rgba(7,148,118,1) 43%, rgba(0,212,255,1) 100%);
}

.card-header {
    display: -webkit-box;
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
    padding: 15px 20px;
    background-color: transparent;
    border-bottom: 1px solid rgba(77, 82, 89, 0.07)
}

.card-header .card-title {
    padding: 0;
    border: none
}

h4.card-title {
    font-size: 17px
}

.card-header>*:last-child {
    margin-right: 0;
    background: #00d4ff00;
    border: 0;
}

.card-header>* {
    margin-left: 8px;
    margin-right: 8px
}

.btn-secondary {
    color: #4d5259 !important;
    background-color: #e4e7ea;
    border-color: #e4e7ea;
    color: #fff
}

.btn-xs {
    font-size: 11px;
    padding: 2px 8px;
    line-height: 18px
}

.btn-xs:hover {
    color: #fff !important
}

.card-title {
    font-family: Roboto, sans-serif;
    font-weight: 300;
    line-height: 1.5;
    margin-bottom: 0;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(77, 82, 89, 0.07)
}

.ps-container {
    position: relative
}

.ps-container {
    -ms-touch-action: auto;
    touch-action: auto;
    overflow: hidden !important;
    -ms-overflow-style: none
}

.media-chat {
    padding-right: 64px;
    margin-bottom: 0
}

.media {
    padding: 16px 12px;
    -webkit-transition: background-color .2s linear;
    transition: background-color .2s linear
}

.media .avatar {
    flex-shrink: 0
}

.avatar {
    position: relative;
    display: inline-block;
    width: 36px;
    height: 36px;
    line-height: 36px;
    text-align: center;
    border-radius: 100%;
    background-color: #f5f6f7;
    color: #8b95a5;
    text-transform: uppercase
}

.media-chat .media-body {
    -webkit-box-flex: initial;
    flex: initial;
    display: table
}

.media-body {
    min-width: 0
}

.media-chat .media-body p {
    position: relative;
    padding: 6px 8px;
    margin: 4px 0;
    background-color: #f5f6f7;
    border-radius: 3px;
    font-weight: 100;
    color: #9b9b9b
}

.media>* {
    margin: 0 8px
}

.media-chat .media-body p.meta {
    background-color: transparent !important;
    padding: 0;
    opacity: .8
}

.media-meta-day {
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
    margin-bottom: 0;
    color: #8b95a5;
    opacity: .8;
    font-weight: 400
}

.media {
    padding: 16px 12px;
    -webkit-transition: background-color .2s linear;
    transition: background-color .2s linear
}

.media-meta-day::before {
    margin-right: 16px
}

.media-meta-day::before,
.media-meta-day::after {
    content: '';
    -webkit-box-flex: 1;
    flex: 1 1;
    border-top: 1px solid #ebebeb
}

.media-meta-day::after {
    content: '';
    -webkit-box-flex: 1;
    flex: 1 1;
    border-top: 1px solid #ebebeb
}

.media-meta-day::after {
    margin-left: 16px
}

.media-chat.media-chat-reverse {
    padding-right: 12px;
    padding-left: 64px;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: reverse;
    flex-direction: row-reverse
}

.media-chat {
    padding-right: 64px;
    margin-bottom: 0
}

.media {
    padding: 16px 12px;
    -webkit-transition: background-color .2s linear;
    transition: background-color .2s linear
}

.media-chat.media-chat-reverse .media-body p {
    float: right;
    clear: right;
    background-color: #48b0f7;
    color: #fff
}

.media-chat .media-body p {
    position: relative;
    padding: 6px 8px;
    margin: 4px 0;
    background-color: #f5f6f7;
    border-radius: 3px
}

.border-light {
    border-color: #f1f2f3 !important
}

.bt-1 {
    border-top: 1px solid #ebebeb !important
}

.publisher {
    position: relative;
    display: -webkit-box;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    padding: 12px 20px;
    background-color: #f9fafb
}

.publisher>*:first-child {
    margin-left: 0
}

.publisher>* {
    margin: 0 8px
}

.publisher-input {
    -webkit-box-flex: 1;
    flex-grow: 1;
    border: none;
    outline: none !important;
    background-color: transparent
}

.publisher-btn {
    background-color: transparent;
    border: none;
    color: #8b95a5;
    font-size: 16px;
    cursor: pointer;
    overflow: -moz-hidden-unscrollable;
    -webkit-transition: .2s linear;
    transition: .2s linear
}

.file-group {
    position: relative;
    overflow: hidden
}

.publisher-btn {
    background-color: transparent;
    border: none;
    color: #cac7c7;
    font-size: 16px;
    cursor: pointer;
    overflow: -moz-hidden-unscrollable;
    -webkit-transition: .2s linear;
    transition: .2s linear
}

.file-group input[type="file"] {
    position: absolute;
    opacity: 0;
    z-index: -1;
    width: 20px
}

.text-info {
    color: #48b0f7 !important
}
</style>