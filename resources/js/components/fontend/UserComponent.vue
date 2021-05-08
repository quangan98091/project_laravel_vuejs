<template>
    <div>
        <div class="container" v-if="user.id != ''">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="user-image">
                                    <img :src="getProfilePhoto()" alt="avatar" class="rounded-circle" width="250">
                                    <div class="btn btn-secondary" >
                                        Thay đổi ảnh
                                       <input type="file" @change="updateProfile"/>
                                    </div>
                                </div> 
                                <div class="mt-3">
                                    <h4>{{user.name}}</h4>
                                    <p class="text-secondary mb-1">{{user.email}}</p>
                                    <button class="btn btn-outline-primary btn-edit-user " @click="editUser()">
                                        Sửa thông tin
                                    </button>
                                    <button class="btn btn-outline-success btn-edit-user " @click="addPost(post)">
                                        Đăng bài
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
                                <span class="text-secondary">https://bootdey.com</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
                                <span class="text-secondary">@bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="header-status">Dòng thời gian</div>                   

                    <ul class="timeline">
                        <li v-for="value in posts" :key="value.id">
                            <div class="timeline-time">
                                <span class="date">{{ value.created_at | historyDay}}</span>
                                <span class="time">{{ value.created_at | myDate}}</span>
                            </div>
                         
                            <div class="timeline-icon">
                                <a href="javascript:;">&nbsp;</a>
                            </div>
                          
                            <div class="timeline-body">
                                <div class="timeline-header">
                                    <span class="userimage">
                                        <img class="rounded-circle" width="45" :src="getProfilePhoto()" alt="avatar">
                                    </span>
                                    <span class="username"><a href="javascript:;">{{ value.user.name }} - </a> </span>
                                    <span>
                                        <i class="fas fa-globe" v-if="value.is_published == 1"> Công khai</i> 
                                        <i class="fas fa-lock" v-else> Chỉ mình tôi</i>
                                    </span>
                                    <span class="pull-right text-muted">
                                        <button class="btn-select-post" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button class="dropdown-item" @click="editPost(value)">Chỉnh sửa bài viết</button>
                                            <button class="dropdown-item" @click="deletePost(value.id)">Xóa bài viết</button></div>
                                    </span>
                                </div>
                                <div class="timeline-content">
                                    <strong>{{value.title}}</strong><br>
                                    <p>{{value.sub_title}}   </p>       
                                    
                                    <div v-for="item in value.categories" :key="item.id">
                                        <span class="category-post float-left" style="margin-right: 9px;">{{ item.title}}</span>
                                    </div>
                                    <div class="clearfix" style="margin-bottom: 7px;"></div>

                                    <p :class="{active: isActive}" style="display: none;"  v-html="value.details"></p>       
                                    <button class="btn-active" @click="isActive = ! isActive" v-show="!isActive"><em>Xem thêm</em></button>
                                    <button class="btn-active" @click="isActive = ! isActive" v-show="isActive"><em>Ẩn bớt</em></button>
                                                
                                    <viewer>
                                        <img :src="'img/post/'+ value.thumbnail" class="images" alt="post" style="cursor: pointer;margin-bottom: 16px;">
                                    </viewer> 
                                </div>
                                <div class="timeline-likes">
                                    <div class="stats-right">
                                        <span class="stats-text">259 Shares</span>
                                        <span class="stats-text">21 Comments</span>
                                    </div>
                                    <div class="stats">
                                        <span class="fa-stack fa-fw stats-icon">
                                            <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                            <i class="fa fa-heart fa-stack-1x fa-inverse t-plus-1"></i>
                                        </span>
                                        <span class="fa-stack fa-fw stats-icon">
                                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                            <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <span class="stats-total">4.3k</span>
                                    </div>
                                </div>
                                <div class="timeline-footer">
                                    <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i> Like</a>
                                    <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Comment</a> 
                                    <ShareNetwork
                                        network="facebook"
                                        url="https://qldt.ptit.edu.vn/default.aspx?page=thoikhoabieu&sta=0"
                                        :title="value.title"
                                        :description="value.sub_title"
                                        :quote="value.title"
                                        hashtags="vuejs,vite"
                                    >
                                        <i class="fa fa-share fa-fw fa-lg m-r-3"></i> Chia sẻ
                                    </ShareNetwork>
                                </div>
                            </div>
                        </li>
                    </ul>
            </div>
          </div>
     
        </div>
        <div v-else>
            <not-found style="text-align: center;"></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="newModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title" id="exampleModalLongTitle">Thay đổi thông tin cá  nhân</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div v-show="!editmode">
                        <form @submit.prevent="updateUser()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <strong>Tên hiển thị:</strong>
                                    <input v-model="user.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': user.errors.has('name') }">
                                    <has-error :form="user" field="name"></has-error>
                                </div>

                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <input v-model="user.email" type="email" name="email"
                                        class="form-control" :class="{ 'is-invalid': user.errors.has('email') }">
                                    <has-error :form="user" field="email"></has-error>
                                </div>

                                <div class="form-group">
                                    <strong>Mật khẩu mới:</strong>
                                    <input v-model="user.password" type="password" name="password" id="password"
                                        class="form-control" :class="{ 'is-invalid': user.errors.has('password') }">
                                    <has-error :form="user" field="password"></has-error>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Cập nhập</button>
                            </div>
                        </form>
                    </div>
                    <div v-show="editmode" style="margin: 25px 22px;">
                        <h4 class="text-center">
                            <span v-show="editpost">Chỉnh sửa bài viết</span>
                            <span v-show="!editpost">Thêm bài viết mới</span>
                        </h4>

                        <form @submit.prevent="editpost ? updatePost() : createPost()">                 
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6"><br><br>
                                        <label for="thumbnail">Hình ảnh chính:</label>
                                        <input type="file" class="text-center center-block file-upload" @change="updatePostImg" style="margin-bottom: 25px;">
                                    </div>
                                    <div class="col-sm-6">
                                        <img :src="getPostImg()" alt="post" style="max-width: 300px; max-height: 200px;margin: 17px 10px;">
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="title">Tiêu đề chính:</label>
                                <input v-model="post.title" type="text" name="title"
                                        class="form-control" :class="{ 'is-invalid': post.errors.has('title') }">
                                <has-error :form="post" field="title"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="sub_title">Tiêu đề phụ:</label>
                                <input v-model="post.sub_title" type="text" name="sub_title"
                                        class="form-control" :class="{ 'is-invalid': post.errors.has('sub_title') }">
                                <has-error :form="post" field="sub_title"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="categories">Thể loại:</label>
                                <multiselect  v-model="post.categories" :options="category" :multiple="true" 
                                            placeholder="Tìm kiếm và thêm thể loại" label="title" track-by="id" >
                                </multiselect>
                            </div>
                            <div class="form-group">
                                <label for="details">Nội dung:</label> 
                                <tinymce id="d1" v-model="post.details"></tinymce>
                            </div>
                            <div class="form-group">
                                <label for="is_published">Trạng thái:</label>
                                <select name="is_published" v-model="post.is_published" id="is_published" class="form-control" 
                                        :class="{ 'is-invalid': post.errors.has('is_published') }">
                                    <option value="1">Công khai</option>
                                    <option value="0">Chỉ mình tôi</option>
                                </select>
                                <has-error :form="post" field="is_published"></has-error>
                            </div>
                            <button class="btn btn-success float-right" type="submit">
                                <span v-show="!editpost">Đăng bài</span>
                                <span v-show="editpost">Cập nhập</span>
                            </button>
                            <button class="btn btn-secondary float-right" style="margin-right: 15px;" type="reset">Làm mới</button>     
                        </form>      
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                isActive: false,
                category: [],
                editmode: false,
                editpost: false,
                posts: {},
                user: new Form({
                    id:'',  name : '',  email: '',  password: '',   type: '',   photo: ''
                }),
                post: new Form({
                    id:'', 
                    user_id: '',
                    thumbnail: '',  title : '', sub_title: '', 
                    details: '', is_published: '',
                    categories: []
                })
            }
        },
        methods: {
            getProfilePhoto() {
                if(this.user.photo != null) {
                    return (this.user.photo.length > 200) ? this.user.photo : "img/profile/"+ this.user.photo ;
                } else {
                    return 'admin/images/icon/profile.png';
                }
            },
            editUser() {
                this.editmode = false;
                $('#addNew').modal('show');
            },
            updateUser() {
                this.$Progress.start();
                if(this.user.password == ''){
                    this.user.password = undefined;
                }
                this.user.put('api/profile')
                .then(()=>{
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Thành công!',
                        'Bạn đã thay đổi thành công thông tin cá nhân.',
                        'success'
                    )
                    Fire.$emit('AfterUpdateUser');
                    this.$Progress.finish();
                    
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            updateProfile(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Dung lượng ảnh quá lớn',
                        text: 'Bạn nên chọn một ảnh có dung lương ít hơn',
                    })
                    return false;
                }
                reader.onloadend = (file) => {
                    this.user.photo = reader.result;
                    this.user.put('api/profile')
                    .then(()=>{
                        toast.fire({
                            icon: 'success',
                            title: 'Cập nhập thành công ảnh đại điện!'
                        })
                     })
                    .catch();
                }
                reader.readAsDataURL(file);
            },
            updatePostImg(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Dung lượng ảnh quá lớn',
                        text: 'Bạn nên chọn một ảnh có dung lương ít hơn',
                    })
                    return false;
                }
                reader.onloadend = (file) => {
                    this.post.thumbnail = reader.result;
                }
                reader.readAsDataURL(file);
            },
            getPostImg() {
                if(this.post.thumbnail != "") {
                    return (this.post.thumbnail.length > 200) ? this.post.thumbnail : 
                                                                    "img/post/"+ this.post.thumbnail ;
                } else {
                    return 'img/category/thumbnail.jpg';
                }
            },
            addPost() {
                this.editmode = true;
                this.editpost = false;
                this.post.reset();
                $('#addNew').modal('show');
            },
            editPost(value) {
                this.editmode = true;
                this.editpost = true;
                this.post.reset();
                $('#addNew').modal('show');
                this.post.fill(value);
            },
            createPost() {
                this.$Progress.start();
                this.post.user_id = this.user.id;
      
                this.post.post('api/post')
                .then(()=>{
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Thành công!',
                        'Bạn thêm thành công bài viết.',
                        'success'
                    )
                    Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'error',
                        title: 'Đã xảy ra lỗi trong quá trình thực hiện'
                    })
                    this.$Progress.fail();
                });
            },
            updatePost() {
                this.$Progress.start();
                this.post.put('api/post/'+this.post.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Thành công!',
                        'Bạn đã thay đổi thành công thông tin của bài viết.',
                        'success'
                    )
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    toast.fire({
                        icon: 'error',
                        title: 'Đã xảy ra lỗi trong quá trình thực hiện'
                    })
                    this.$Progress.fail();
               });
            },
            deletePost(id) {
                this.$Progress.start();
                swal.fire({
                    title: 'Bạn có chắc không?',
                    text: "Bạn sẽ không thể khôi phục lại bài viết này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //Send request to the server
                        this.post.delete('api/post/'+id)
                        .then(() => {
                            swal.fire(
                                'Xóa thành công!',
                                'Bạn đã xóa thành công một post.',
                                'success'
                            )
                                
                            Fire.$emit('AfterCreate');
                            this.$Progress.finish();
                        }).catch(() => {
                            toast.fire({
                                icon: 'error',
                                title: 'Đã xảy ra lỗi trong quá trình thực hiện'
                            })
                            this.$Progress.fail();
                        });
                    }
                })
            
            },
            loadPosts() {
                axios.get("api/postUser/"+this.user.id)
                .then(
                    ({ data }) => (this.posts = data)
                )
                .catch();
            },
        },
        created() {
            if(window.user != undefined) {
                axios.get("api/profile")
                .then(({ data }) => {
                    this.user.fill(data);
                    this.loadPosts();
                });

                axios.get("api/getCategory")
                .then(response => {
                    this.category = response.data;
                });

            }

            Fire.$on('AfterUpdateUser',() => {
               location.reload();
            });

            Fire.$on('AfterCreate',() => {
                this.post.reset();
                this.loadPosts();
           });
        },
        
    }
    
</script>

<style scoped>

.active {
    display: block !important;
}
.btn-active {
    border: 0;
    background: #b5b5b500;
    margin-bottom: 10px;
    color: #0095ff;
    font-size: 15px;
    font-weight: 800;
}
.btn-active:hover {
    border-bottom: 1px solid black;
    color: #da0000;
}


.timeline {
    list-style-type: none;
    margin: 0;
    padding: 0;
    position: relative
}

.timeline:before {
    content: '';
    position: absolute;
    top: 5px;
    bottom: 5px;
    width: 5px;
    background: #2d353c;
    left: 20%;
    margin-left: -2.5px
}

.timeline>li {
    position: relative;
    min-height: 50px;
    padding: 20px 0
}

.timeline .timeline-time {
    position: absolute;
    left: 0;
    width: 18%;
    text-align: right;
    top: 30px
}

.timeline .timeline-time .date, .timeline .timeline-time .time {
    display: block;
    font-weight: 600
}

.timeline .timeline-time .date {
    line-height: 16px;
    font-size: 12px
}

.timeline .timeline-time .time {
    line-height: 24px;
    font-size: 20px;
    color: #242a30
}

.timeline .timeline-icon {
    left: 15%;
    position: absolute;
    width: 10%;
    text-align: center;
    top: 40px
}

.timeline .timeline-icon a {
    text-decoration: none;
    width: 20px;
    height: 20px;
    display: inline-block;
    border-radius: 20px;
    background: #d9e0e7;
    line-height: 10px;
    color: #fff;
    font-size: 14px;
    border: 5px solid #2d353c;
    transition: border-color .2s linear
}

.timeline .timeline-body {
    margin-left: 23%;
    background: #c5c5c54a;
    position: relative;
    padding: 20px 25px;
    border-radius: 6px
}

.timeline .timeline-body:before {
    content: '';
    display: block;
    position: absolute;
    border: 10px solid transparent;
    border-right-color: #c5c5c54a;
    left: -20px;
    top: 20px
}

.timeline .timeline-body>div+div {
    margin-top: 15px
}

.timeline .timeline-body>div+div:last-child {
    /* margin-bottom: -20px; */
    padding-bottom: 20px;
    border-radius: 0 0 6px 6px
}

.timeline-header {
    padding-bottom: 10px;
    border-bottom: 1px solid #e2e7eb;
    line-height: 30px
}

.timeline-header .userimage {
    float: left;
    width: 34px;
    height: 34px;
    border-radius: 40px;
    overflow: hidden;
    margin: -2px 10px -2px 0
}

.timeline-header .username {
    font-size: 16px;
    font-weight: 600
}

.timeline-header .username,
.timeline-header .username a {
    color: #2d353c
}

.timeline img {
    max-width: 100%;
    display: block
}

.timeline-content {
    letter-spacing: .25px;
    line-height: 18px;
    font-size: 13px
}

.timeline-content:after, .timeline-content:before {
    content: '';
    display: table;
    clear: both
}

.timeline-title {
    margin-top: 0
}

.timeline-footer {
    background: #fff;
    border-top: 1px solid #e2e7ec;
    padding-top: 15px
}

.timeline-footer a:not(.btn) {
    color: #575d63
}

.timeline-footer a:not(.btn):focus, .timeline-footer a:not(.btn):hover {
    color: #2d353c
}

.timeline-likes {
    color: #6d767f;
    font-weight: 600;
    font-size: 12px
}

.timeline-likes .stats-right {
    float: right
}

.timeline-likes .stats-total {
    display: inline-block;
    line-height: 20px
}

.timeline-likes .stats-icon {
    float: left;
    margin-right: 5px;
    font-size: 9px
}

.timeline-likes .stats-icon+.stats-icon {
    margin-left: -2px
}

.timeline-likes .stats-text {
    line-height: 20px
}

.timeline-likes .stats-text+.stats-text {
    margin-left: 15px
}

.timeline-comment-box {
    background: #f2f3f4;
    margin-left: -25px;
    margin-right: -25px;
    padding: 20px 25px
}

.timeline-comment-box .user {
    float: left;
    width: 34px;
    height: 34px;
    overflow: hidden;
    border-radius: 30px
}

.timeline-comment-box .user img {
    max-width: 100%;
    max-height: 100%
}

.timeline-comment-box .user+.input {
    margin-left: 44px
}


.user-image {
    border-radius: 50%;
    overflow: hidden;
    max-width: 250px;
    max-height: 250px;
}
.user-image >img {
    margin-bottom: -38px;
}
.user-image >div {
    width: 100%;
    background: #000000ad;
    font-size: 13px;
    cursor: pointer;
}
.user-image >div >input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;    
    cursor: pointer;
}
.btn-edit-user {    
    border-radius: 24px;
    margin: 13px 0px;
    color: black;
}
.header-status {
    width: 100%;
    font-size: 28px;
    font-family: cursive;
    text-align: center;
    border-bottom: 1px solid #00000040;
    box-shadow: 0 0 5px 0px #0000003b;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    padding-bottom: 13px;
    color: black;
}
.category-post {
    font-size: 14px;
    background: linear-gradient(90deg, rgba(161,255,146,0.8799894957983193) 43%, rgba(142,232,250,1) 100%);
    padding: 4px 9px;
    color: black;
    font-family: cursive;
    border-radius: 19px;
}
.btn-select-post {
    border: 0;
    border-radius: 50%;
}
.btn-select-post >i {
    padding: 5px 5px;
    font-size: 21px;
    border-radius: 50%;
}
.btn-select-post >i:hover {
    background: rgb(0 0 0 / 60%);
}
.dropdown-menu-right:before {
    content: '';
    display: block;
    position: absolute;
    border: 15px solid #0a0a0a00;
    border-bottom-color: white;
    top: -26px;
    right: 6px;
}
.dropdown-item:hover {
    background: #863636;
    color: white;
}
</style>