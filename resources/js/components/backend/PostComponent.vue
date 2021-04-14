<template>
    <div class="container" v-if="$gate.isAdmin()">
        <div class="row">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35 title-component">Bảng bài viết</h3>
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                    </div>
                    <div class="table-data__tool-right">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small" @click="addModel()">
                            <i class="zmdi zmdi-plus"></i>Thêm thể loại
                        </button>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>
                                    <label class="au-checkbox">
                                        <input type="checkbox"><span class="au-checkmark"></span>
                                    </label>
                                </th>
                                <th>ID</th>
                                <th>Tiêu đề chính</th>
                                <th>Thể loại</th>
                                <th>Đăng bởi</th>
                                <th>Ngày đăng</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tr-shadow" v-for="post in posts.data" :key="post.id" style="border-bottom-style: solid;">
                                <td>
                                    <label class="au-checkbox">
                                        <input type="checkbox"><span class="au-checkmark"></span>
                                    </label>
                                </td>
                                <td>{{post.id}}</td>
                                <td>{{post.title}}</td>
                                <td>
                                    <ul>
                                        <li v-for="item in post.categories" :key="item.id">
                                            {{ item.title}}
                                        </li>
                                    </ul>
                                    
                                </td>
                                <td><span class="block-email">{{ post.user.name }}</span></td>
                                <td>{{post.created_at | myDate }}</td>
                                <td>
                                    <toggle-button @change="onChangeEvent(post.id, $event)" :value="Boolean(post.is_published)"/>
                                </td>
                                <td>
                                    <div class="table-data-feature">
                                        <button class="item" @click="editModel(post)">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button>
                                        <button @click="deletePost(post.id)" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Xóa">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                        <button class="item" @click="seeModel(post)">
                                            <i class="zmdi zmdi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin: 13px 12px;">
                        <pagination :data="posts" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>

        <div v-if="!$gate.isAdmin()"> 
            <not-found></not-found>
        </div>

        <!-- Modal add or edit -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="newModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title" id="exampleModalLongTitle">Thêm bài viết</h5>
                        <h5 v-show="editmode" class="modal-title" id="exampleModalLongTitle">Thay đổi thông tin bài viết</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form @submit.prevent="editmode ? updatePost() : createPost()">                 
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6"><br><br>
                                        <label for="thumbnail">Hình ảnh chính:</label>
                                        <input type="file" class="text-center center-block file-upload" @change="updateImg" style="margin-bottom: 25px;">
                                    </div>
                                    <div class="col-sm-6">
                                        <img :src="getPostImg()" alt="avatar" style="max-width: 300px; max-height: 200px;margin: 17px 10px;">
                                    </div>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="title">Tiêu đề chính:</label>
                                <input v-model="form.title" type="text" name="title"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>

                            <div class="form-group">
                                <label for="sub_title">Tiêu đề phụ:</label>
                                <input v-model="form.sub_title" type="text" name="sub_title"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('sub_title') }">
                                <has-error :form="form" field="sub_title"></has-error>
                            </div>

                            <div class="form-group">
                                <label for="categories">Thể loại:</label>
                                <multiselect  v-model="form.categories" :options="category" :multiple="true" 
                                            placeholder="Tìm kiếm và thêm thể loại" label="title" track-by="id" >
                                </multiselect>
                            </div>

                            <div class="form-group">
                                <label for="details">Nội dung:</label> 
                                <tinymce id="d1" v-model="form.details" :value="form.details"></tinymce>
                                <!-- <ckeditor v-model="form.details" value="form.details"></ckeditor> -->
                            </div>

                            <div class="form-group">
                                <label for="is_published">Trạng thái:</label>
                                <select name="is_published" v-model="form.is_published" id="is_published" class="form-control" 
                                        :class="{ 'is-invalid': form.errors.has('is_published') }">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Ẩn</option>
                                </select>
                                <has-error :form="form" field="is_published"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button v-show="!editmode" type="submit" class="btn btn-success">Thêm mới</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">Cập nhập</button>
                        </div>                       
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal see -->
        <div class="modal fade" id="seePost" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thông tin bài viết</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                                    
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6"><br><br>
                                    <label for="thumbnail">Hình ảnh chính:</label>
                                </div>
                                <div class="col-sm-6">
                                    <viewer>
                                        <img :src="getPostImg()" alt="avatar" style="max-width: 300px; max-height: 200px;margin: 17px 10px;">
                                    </viewer> 
                                </div>
                            </div> 
                        </div><hr>

                        <div class="form-group"><strong>Têu đề chính: </strong> {{ form.title }}</div><hr>
                        <div class="form-group"><strong>Têu đề phụ: </strong> {{ form.sub_title }}</div><hr>
                        <div class="form-group">
                            <strong >Thể loại:</strong>
                                <multiselect  v-model="form.categories" :options="category" :multiple="true" 
                                        disabled   label="title" track-by="id" >
                                </multiselect>
                        </div> <hr>
                        <div class="form-group"><strong>Nội dung: </strong> 
                            <p v-html="form.details"></p>
                        </div><hr>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
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
                category: [],
                editmode: false,
                posts: {},
                user: new Form({ 
                    id:'',  name : '',  email: '',  password: '',   type: '',   photo: ''
                }),
                form: new Form({
                    id:'', 
                    user_id: user.id,
                    thumbnail: '',  title : '', sub_title: '', 
                    details: '', is_published: '',
                    categories: []
                })
            }
        },
        methods: {
            getPostImg() {
                if(this.form.thumbnail != "") {
                    return (this.form.thumbnail.length > 200) ? this.form.thumbnail : 
                                                                    "img/post/"+ this.form.thumbnail ;
                } else {
                    return 'img/category/thumbnail.jpg';
                }
            },
            getResults(page = 1) {
                axios.get('api/post?page=' + page)
                .then(response => {
                    this.posts = response.data;
                });
            },
            seeModel(post) {
                this.form.reset();
                $('#seePost').modal('show');
                this.form.fill(post);
            },
            addModel() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModel(post) {
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(post);
            },
            updatePost() {
                this.$Progress.start();

                this.form.put('api/post/'+this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Thành công!',
                        'Bạn đã thay đổi thành công thông tin của post.',
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
            updateImg(e) {
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
                    this.form.thumbnail = reader.result;
                }
                reader.readAsDataURL(file);
            },
            deletePost(id) {
                this.$Progress.start();
                swal.fire({
                    title: 'Bạn có chắc không?',
                    text: "Bạn sẽ không thể khôi phục lại dữ liệu này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //Send request to the server
                        this.form.delete('api/post/'+id)
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
            loadposts() {
                if(this.$gate.isAdmin()) {
                    axios.get("api/post")
                    .then(
                        ({ data }) => (this.posts = data)
                    )
                    .catch(() => {
                        
                    });
                }
                
            },
            createPost() {
                this.$Progress.start();

                this.form.post('api/post')
                .then(()=>{
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'Bạn thêm thành công bài viết'
                    })
                    Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                })
                .catch(()=>{
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'error',
                        title: 'Đã xảy ra lỗi trong quá trình thực hiện'
                    })
                    this.$Progress.fail();
                });

            },
            onChangeEvent(id, event) {
                this.form.reset();
                let value = event.value;
                if(value == true) 
                    value = 1;
                else 
                    value = 0;
                this.form.id = id;  
                this.form.is_published = value; 
                this.form.post('api/isPost/'+ this.form.id)
                .then(() => {
                    toast.fire({
                        icon: 'success',
                        title: 'Bạn thay đổi thành công trạng thái'
                    })
                })
                .catch(() => {
                    toast.fire({
                        icon: 'error',
                        title: 'Đã xảy ra lỗi trong quá trình thực hiện'
                    })
                });
            }
        },
        created() {
            axios.get("api/profile")
            .then(({ data }) => (this.user = (data)));

            axios.get("api/category")
            .then(({ data }) => (this.category = (data.data)));

            // Fire.$on('searching',() => {
            //     let query = this.$parent.search;
            //     axios.get('api/findpost?q=' + query)
            //     .then((data) => {
            //         this.posts = data.data
            //     })
            //     .catch(() => {
            //     });
            // });

            this.loadposts();
            Fire.$on('AfterCreate',() => {
               this.loadposts();
           });
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>