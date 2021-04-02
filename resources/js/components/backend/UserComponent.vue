<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Bảng user</h3>
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        
                    </div>
                    <div class="table-data__tool-right">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small" @click="addModel()">
                            <i class="zmdi zmdi-plus"></i>Thêm user
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
                                <th>Tên hiển thị</th>
                                <th>Email</th>
                                <th>Loại tài khoản</th>
                                <th>Ngày đăng ký</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tr-shadow" v-for="user in users.data" :key="user.id" style="border-bottom-style: solid;">
                                <td>
                                    <label class="au-checkbox">
                                        <input type="checkbox"><span class="au-checkmark"></span>
                                    </label>
                                </td>
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td><span class="block-email">{{user.email}}</span></td>
                                <td class="desc">{{user.type | upText}}</td>
                                <td>{{user.created_at | myDate }}</td>
                                <td>
                                    <div class="table-data-feature">
                                        <button class="item" @click="editModel(user)">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button>
                                        <button @click="deleteUser(user.id)" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Xóa">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin: 13px 12px;">
                        <pagination :data="users" @pagination-change-page="getResults"></pagination>
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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="exampleModalLongTitle">Thêm user</h5>
                    <h5 v-show="editmode" class="modal-title" id="exampleModalLongTitle">Thay đổi thông tin user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateUser() : createUser()">
                    <div class="modal-body">
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
                            <input v-model="form.password" type="password" name="password" id="password" placeholder="Mật khẩu"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="!editmode" type="submit" class="btn btn-success">Thêm user</button>
                        <button v-show="editmode" type="submit" class="btn btn-primary">Cập nhập</button>
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
                users: {},
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
            getResults(page = 1) {
                axios.get('api/user?page=' + page)
                .then(response => {
                    this.users = response.data;
                });
            },
            addModel() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModel(user) {
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            updateUser() {
                this.$Progress.start();

                this.form.put('api/user/'+this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Thành công!',
                        'Bạn đã thay đổi thành công thông tin của user.',
                        'success'
                    )
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            deleteUser(id) {
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
                        this.form.delete('api/user/'+id)
                        .then(() => {
                            
                                swal.fire(
                                'Xóa thành công!',
                                'Bạn đã xóa thành công một user.',
                                'success'
                                )
                            
                            Fire.$emit('AfterCreate');
                        }).catch(() => {
                            swal.fire("Failed!", "There was something wronge.", "warning");
                        });
                    }
                })

            },
            loadUsers() {
                if(this.$gate.isAdmin()) {
                    axios.get("api/user")
                    .then(
                        ({ data }) => (this.users = data)
                    );
                }
                
            },
            createUser() {
                this.$Progress.start();

                this.form.post('api/user')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'Bạn đã đăng ký thành công một user'
                    })
                    this.$Progress.finish();
                })
                .catch(()=>{
                });

            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/findUser?q=' + query)
                .then((data) => {
                    this.users = data.data
                })
                .catch(() => {
                });
            });

            this.loadUsers();
            Fire.$on('AfterCreate',() => {
               this.loadUsers();
           });
        }
    }
</script>
