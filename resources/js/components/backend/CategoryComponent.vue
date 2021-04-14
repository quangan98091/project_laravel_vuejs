<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35 title-component">Bảng thể loại</h3>
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
                                <th>Tên thể loại</th>
                                <th>Đăng bởi</th>
                                <th>Ảnh</th>
                                <th>Ngày đăng</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tr-shadow" v-for="category in categories.data" :key="category.id" style="border-bottom-style: solid;">
                                <td>
                                    <label class="au-checkbox">
                                        <input type="checkbox"><span class="au-checkmark"></span>
                                    </label>
                                </td>
                                <td>{{category.id}}</td>
                                <td>{{category.title}}</td>
                                <td><span class="block-email">{{ category.user.name }}</span></td>
                                <td class="desc">
                                    <viewer>
                                        <img :src="'img/category/'+ category.thumbnail" class="images" alt="category" style="cursor: pointer;max-height:100px;max-width: 100px;">
                                    </viewer> 
                                </td>
                                <td>{{category.created_at | myDate }}</td>
                                <td>
                                    <toggle-button @change="onChangeEvent(category.id, $event)" :value="Boolean(category.is_published)"/>
                                </td>
                                <td>
                                    <div class="table-data-feature">
                                        <button class="item" @click="editModel(category)">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button>
                                        <button @click="deleteCategory(category.id)" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Xóa">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin: 13px 12px;">
                        <pagination :data="categories" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>

        <div v-if="!$gate.isAdmin()"> 
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="newModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="exampleModalLongTitle">Thêm thể loại</h5>
                    <h5 v-show="editmode" class="modal-title" id="exampleModalLongTitle">Thay đổi thông tin thể loại</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form @submit.prevent="editmode ? updateCategory() : createCategory()">
                    <div class="row">
                        <div class="col-sm-6">                   
                            <div class="text-center">
                                <img :src="getCategoryImg()" alt="avatar" style="max-width: 300px; max-height: 200px;margin: 17px 10px;">
                                <br><input type="file" class="text-center center-block file-upload" @change="updateImg" style="margin-bottom: 25px;">
                            </div> 
                        </div>
                        <div class="col-sm-6">   
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title">Tên thể loại:</label>
                                    <input v-model="form.title" type="text" name="title"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>

                                <div class="form-group">
                                    <label for="is_published">Trạng thái:</label>
                                    <select name="is_published" v-model="form.is_published" id="is_published" class="form-control" :class="{ 'is-invalid': form.errors.has('is_published') }">
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
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {  
            return {
                editmode: false,
                categories: {},
                user: new Form({ 
                    id:'',  name : '',  email: '',  password: '',   type: '',   photo: ''
                }),
                form: new Form({
                    id:'',
                    user_id: user.id,
                    thumbnail: '',
                    title : '',
                    is_published: ''

                })
            }
        },
        methods: {
            getCategoryImg() {
                if(this.form.thumbnail != "") {
                    return (this.form.thumbnail.length > 200) ? this.form.thumbnail : 
                                                                    "img/category/"+ this.form.thumbnail ;
                } else {
                    return 'img/category/thumbnail.jpg';
                }
                    
            },
            getResults(page = 1) {
                axios.get('api/category?page=' + page)
                .then(response => {
                    this.categories = response.data;
                });
            },
            addModel() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModel(category) {
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(category);
            },
            updateCategory() {
                this.$Progress.start();

                this.form.put('api/category/'+this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Thành công!',
                        'Bạn đã thay đổi thành công thông tin của category.',
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
            deleteCategory(id) {
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
                        this.form.delete('api/category/'+id)
                        .then(() => {
                            swal.fire(
                                'Xóa thành công!',
                                'Bạn đã xóa thành công một category.',
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
            loadCategories() {
                if(this.$gate.isAdmin()) {
                    axios.get("api/category")
                    .then(
                        ({ data }) => (this.categories = data)
                    )
                    .catch(() => {
                        
                    });
                }
                
            },
            createCategory() {
                this.$Progress.start();

                this.form.post('api/category')
                .then(()=>{
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'Bạn thêm thành công thể loại'
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
                this.form.post('api/isPublished/'+ this.form.id)
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

            Fire.$on('searching',() => { 
                let query = this.$parent.search;
                axios.get('api/findCategory?q=' + query)
                .then((data) => {
                    this.categories = data.data
                })
                .catch(() => {
                });
            });

            this.loadCategories();
            Fire.$on('AfterCreate',() => {
               this.loadCategories();
           });
        }
    }
</script>

