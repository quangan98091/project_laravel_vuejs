<template>
    <div class="container profile-user">
        <div class="emp-profile" v-if="user.id != ''">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img :src="getProfilePhoto()" alt="avatar" style="max-width: 150px; max-height: 150px;"/>
                        <div class="file btn btn-lg btn-primary" >
                            Thay đổi ảnh
                            <input type="file" @change="updateProfile" style="cursor: pointer;"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5><strong>Tên hiển thị: </strong>{{user.name}}</h5>
                        <h6><strong>Email: </strong>{{user.email}}</h6>
                        <br>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Nhật ký hoạt động</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#addPost" role="tab" aria-controls="addPost" aria-selected="false">Đăng bài</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="profile-edit-btn" style="padding: 5px 12px; width: 130px;"  @click="editModel()">
                        Sửa thông tin
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>WORK LINK</p>
                        <a href="">Website Link</a><br/>
                        <a href="">Bootsnipp Profile</a><br/>
                        <a href="">Bootply Profile</a>
                        <p>SKILLS</p>
                        <a href="">Web Designer</a><br/>
                        <a href="">Web Developer</a><br/>
                        <a href="">WordPress</a><br/>
                        <a href="">WooCommerce</a><br/>
                        <a href="">PHP, .Net</a><br/> 
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">               
                            <div class="gedf-main" v-for="value in posts" :key="value.id" > 
                                <div class="card gedf-card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="mr-2">
                                                    <img class="rounded-circle" width="45" :src="getProfilePhoto()" alt="avatar">
                                                </div>
                                                <div class="ml-2">
                                                    <div class="h5 m-0">{{ value.user.name }}</div>
                                                    <div class="h7 text-muted">
                                                        <i class="fa fa-clock-o"></i> {{ value.created_at | myDate}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="dropdown">
                                                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 0;">
                                                        <i class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                        <a class="dropdown-item" href="#">Chỉnh sửa bài viết</a>
                                                        <a class="dropdown-item" href="#">Xóa bài viết</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <strong class="text-center">{{value.title}}</strong><br>
                                            {{value.sub_title}}    
                                        </h5>
                                        <div class="card-text">    
                                            <p :class="{active: isActive}" style="display: none;"  v-html="value.details"></p>
                                            <div>
                                                <button class="btn-active" @click="isActive = ! isActive" v-show="!isActive"><em>Xem thêm</em></button>
                                                <button class="btn-active" @click="isActive = ! isActive" v-show="isActive"><em>Ẩn bớt</em></button>
                                            </div>   
                                        </div>
                                        

                                        <viewer>
                                            <img :src="'img/post/'+ value.thumbnail" class="images" alt="post" style="cursor: pointer;max-width: 517px;overflow: hidden;margin-bottom: 16px;">
                                        </viewer> 
                                        <div v-for="item in value.categories" :key="item.id">
                                            <span class="badge badge-primary float-left" style="margin-right: 9px;">{{ item.title}}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="#" class="card-link"><i class="far fa-heart"></i> Thích</a>
                                        <a href="#" class="card-link"><i class="fa fa-comment"></i> Bình luận</a>
                                        <a href="#" class="card-link"><i class="fa fa-mail-forward"></i> Chia sẻ</a>
                                    </div>
                                </div>
                            </div>

                            
                        </div>

                        <div class="tab-pane fade" id="addPost" role="tabpanel" aria-labelledby="profile-tab"> 
                            <form @submit.prevent="createPost()">
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

                       
                                <button class="btn btn-success float-right" type="submit">Đăng bài</button>
                                <button class="btn btn-secondary float-right" style="margin-right: 15px;" type="reset">Làm mới</button>     
                            </form>      
                        </div>
                    </div>
                </div>
            </div>    
        </div>

        <div v-if="user.id == ''">
            <not-found style="text-align: center;"></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="newModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title" id="exampleModalLongTitle">Thay đổi thông tin cá  nhân</h5>
                        <h5 v-show="editmode" class="modal-title" id="exampleModalLongTitle">Chỉnh sửa bài viết</h5>
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
                    <div v-show="editmode">
                        Chỉnh sửa bài viết
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
                posts: {},
                user: new Form({
                    id:'',  name : '',  email: '',  password: '',   type: '',   photo: ''
                }),
                post: new Form({
                    id:'', 
                    user_id: user.id,
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
            editModel() {
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
            createPost() {
                this.$Progress.start();
                this.post.post('api/post')
                .then(()=>{
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
            loadPosts() {
                axios.get("api/postUser/"+this.user.id)
                .then(
                    ({ data }) => (this.posts = data)
                )
                .catch();
            },
        },
        created() {
            axios.get("api/profile")
            .then(({ data }) => {
                this.user.fill(data);
                this.loadPosts();
            });

            axios.get("api/category")
            .then(({ data }) => (this.category = (data.data)));

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
body{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.active {
    display: block !important;
}
.btn-active {
    border: 0;
    background: white;
    margin-bottom: 10px;
    color: #0095ff;
}
.btn-active:hover {
    border-bottom: 1px solid black;
    color: #da0000;
}
.profile-user {
    border: 1px solid #00000047;
    box-shadow: inset 0 0 3px 0px black;
    border-radius: 10px;
    margin-top: 10px;
    overflow: hidden;
    margin-bottom: 50px;
}
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #000000;
    cursor: pointer;
}
.profile-edit-btn:hover {
    background: black;
    color: white;
    box-shadow: 0 0 7px black;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}

.gedf-wrapper {
    margin-top: 0.97rem;
}
@media (min-width: 992px) {
    .gedf-main {
        padding-left: 4rem;
        padding-right: 4rem;
    }
    .gedf-card {
        margin-bottom: 2.77rem;
    }
}
/**Reset Bootstrap*/
.dropdown-toggle::after {
    content: none;
    display: none;
}
</style>