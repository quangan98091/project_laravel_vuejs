<template>
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <router-link to="/" class="no-theme-logo">
                    <img src="admin/images/icon/logo.png" alt="ShareCode" style="max-width:160px;">
                </router-link>
                <!-- <a href="{{ url('/dashboard' )}}">
                    <img src="{{ asset('admin/images/icon/logo.png') }}"/>
                </a> -->
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <router-link to="/">
                                <i class="fas fa-tachometer-alt"></i>Thống kê chung
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/user">
                                <i class="fas fa-user"></i>Quản lý user
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/post">
                                <i class="fas fa-table"></i>Quản lý bài đăng
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/category">
                                <i class="fas fa-calendar-alt"></i>Quản lý thể loại
                            </router-link>
                        </li>
                        
                        <li>
                            <router-link to="/developer">
                                <i class="fas fa-cogs"></i>Developer
                            </router-link>
                        </li>
      

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="form-header">
                                <input v-on:keyup="searchIt" v-model="search" type="search" class="au-input au-input--xl" name="search" placeholder="Tìm kiếm...." />
                                <button class="au-btn--submit" v-on:click="searchIt" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </div>
                       
                            <div class="header-button">
                                <div class="noti-wrap">
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-email"></i>
                                        <span class="quantity">1</span>
                                        <div class="email-dropdown js-dropdown">
                                            <div class="email__title">
                                                <p>You have 3 New Emails</p>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, 3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, April 12,,2018</span>
                                                </div>
                                            </div>
                                            <div class="email__footer">
                                                <a href="#">See all emails</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-notifications"></i>
                                        <span class="quantity">3</span>
                                        <div class="notifi-dropdown js-dropdown">
                                            <div class="notifi__title">
                                                <p>You have 3 Notifications</p>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a email notification</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c2 img-cir img-40">
                                                    <i class="zmdi zmdi-account-box"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your account has been blocked</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c3 img-cir img-40">
                                                    <i class="zmdi zmdi-file-text"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a new file</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__footer">
                                                <a href="#">All notifications</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img :src="getProfilePhoto()" alt="avatar">
                                        </div>
                                        
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">{{ user.name }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="admin/images/icon/profile.png" alt="avatar" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">{{ user.name }}</h5>
                                                    <span class="email">{{ user.email }}</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <router-link to="/profile">
                                                        <i class="zmdi zmdi-account"></i>Thông tin cá nhân
                                                    </router-link>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-settings"></i>Cấp quyền</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a class="dropdown-item" v-on:click="logout">
                                                    <i class="zmdi zmdi-power"></i>Đăng xuất
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                
                <router-view></router-view>

                <vue-progress-bar></vue-progress-bar>
            </div>
            <!-- END MAIN CONTENT-->    
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
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
            // searchIt: _.debounce(() => {
            //     Fire.$emit('searching');
            // },1000) // có độ trễ
            searchIt() { //không có độ trễ
                Fire.$emit('searching');
            },
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
            axios.get("api/profile")
            .then(
                ({ data }) => (this.user.fill(data))
            )
            .catch();

           
        }
    }
</script>

<style scoped>
    .no-theme-logo {
        color: white !important;
        border: 0 !important;
    }
</style>