<template>
    <div class="container">
        <div class="bootstrap snippet">
            <div class="row">
                <div class="col-sm-4"><!--left col-->
                    <div class="text-center">
                        <img :src="getProfilePhoto()" class="avatar img-circle img-thumbnail" alt="avatar">
                        <br><h6>Upload a different photo...</h6>
                        <br><input type="file" class="text-center center-block file-upload" @change="updateProfile">
                    </div> 
                    <hr>
                    <ul class="list-group">
                        <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span> 125</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 78</li>
                    </ul>        
                </div>
                <div class="col-sm-8" style="border-left: 1px solid;">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Hoạt động cá nhân</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Thông tin cá nhân</a>
                        </li>
                    </ul>
                    <hr>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <h3>Hoạt động cá nhân</h3>
       
                        
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <form class="form" action="##" method="post" id="registrationForm">
                                <div class="form-group">
                                    <input v-model="form.name" type="text" name="name"
                                        placeholder="Tên hiển thị"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>

                                <div class="form-group">
                                    <input v-model="form.email" type="email" name="email"
                                        placeholder="Email"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>

                                <div class="form-group">
                                    <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                        <option value="">Loại tài khoản</option>
                                        <option value="admin">Admin</option>
                                        <option value="user"> User</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>

                                <div class="form-group">
                                    <input type="file" class="text-center center-block file-upload" @change="updateProfile">
                                </div>

                                <div class="form-group">
                                    <input v-model="form.password" type="password" name="password" id="password" placeholder="Mật khẩu"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <br>
                                        <button @click.prevent="updateInfo" class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Cập nhập</button>
                                        <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Làm mới</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                      
                    </div>
                </div>
            </div><!--/row-->
        </div>  
    </div>                      
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
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
                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return  photo;
            },
            updateInfo() {
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('api/profile')
                .then(()=>{
                    Fire.$emit('AfterCreate');
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
                    swal({
                        type: 'Lỗi',
                        title: 'Đã xả ra lỗi',
                        text: 'Hình ảnh có kích thước quá lớn.',
                    })
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            },
            loadProfile() {
                this.$Progress.start();

                this.form.get('api/profile')
                .then(()=>{
                    swal.fire(
                        'Cập nhập thành công!',
                        '',
                        'success'
                    )
                    this.$Progress.finish();
                })
                .catch(()=>{
                });
            }
        },
        created() {
            axios.get("api/profile")
            .then(({ data }) => (this.form.fill(data)));

            Fire.$on('AfterCreate',() => {
               this.loadProfile();
           });
        }
    }
</script>
