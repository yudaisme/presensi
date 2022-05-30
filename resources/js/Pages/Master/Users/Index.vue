<script>
    import Layout from "../../../Layouts/Layout.vue"
    import { useForm } from "@inertiajs/inertia-vue3";
    import Swal from 'sweetalert2';
    export default {
        components: {
            Layout,
        },
        props:['users','roles','errors'],
        mounted(){
            document.title = "Pengguna | Master"
            $('#indukMaster').addClass('active')
            $('#collapseMaster').addClass('show')
            $('#dataTable').DataTable()
        },
        methods:{
            newData(){
                this.resetForm()
                $('#modalUser').modal('show')
            },
            editUser(user){
                this.resetForm()
                this.formUser.id = user.id
                this.formUser.name = user.name
                this.formUser.email = user.email
                this.formUser.password = null
                this.formUser.old_photo = user.photo
                this.formUser.contact = user.contact
                this.formUser.role_id = user.role_id
                $('#modalUser').modal('show')
            },
            resetForm(){
                this.formUser.id = null
                this.formUser.name = null
                this.formUser.email = null
                this.formUser.password = null
                this.formUser.photo = null
                this.formUser.old_photo = null
                this.formUser.contact = null
                this.formUser.role_id = null
            },
            storeOrUpdate(){
                this.formUser.post(route("master.users.storeOrUpdate"), {
                    onSuccess:() => {
                        this.resetForm()
                        $('#modalUser').modal('hide')
                    }
                })
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Delete this user?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        this.$inertia.delete(route("master.role.delete", id));
                    }
                })
            }
        },
        setup() {
            const formUser = useForm({
                id: null,
                name: null,
                email: null,
                password: null,
                photo: null,
                old_photo: null,
                contact: null,
                role_id: null,
            });

            return { formUser };
        },
    }
</script>

<style>
    @import url("../../../Assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css");
</style>

<template>
    <Layout>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div v-if="$page.props.flash.success">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h5>{{ $page.props.flash.success }}</h5>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div v-if="$page.props.flash.error">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5>{{ $page.props.flash.error }}</h5>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Manajemen Pengguna</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>                            
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-info btn-block" @click="newData()"><i class="fas fa-plus"></i>&nbsp;New User</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email Pengguna</th>
                                    <th>Kontak</th>
                                    <th>Role</th>
                                    <th>Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user,i) in users" :key="user.id">
                                    <td>{{ i + 1 }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.contact }}</td>
                                    <td>{{ user.role ? user.role.name : 'Tidak Ada Role' }}</td>
                                    <td><img :src="user.photo" :alt="user.name" width="80" height="80" /></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="editUser(user)"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" @click="deleteUser(user.id)"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal-->
            <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Form Pengguna</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form @submit.prevent="storeOrUpdate()">
                            <input type="hidden" v-model="formUser.id">
                            <input type="hidden" v-model="formUser.old_photo">
                            <div class="modal-body">
                                <!-- <div class="form-group">
                                    <label for="role_id">Role Pengguna</label>
                                    <select" id="role_id" class="form-control" v-model="formUser.role_id">
                                        <option v-for="(role, i) in roles" :value="role.id" :key="i">{{ role.name }}</option>
                                    </select">
                                    <div v-if="errors.role_id"><span class="text-danger">{{ errors.role_id }}</span></div>
                                </div> -->
                                <div class="form-group">
                                    <label for="name">Nama Pengguna</label>
                                    <input type="text" id="name" class="form-control" v-model="formUser.name">
                                    <div v-if="errors.name"><span class="text-danger">{{ errors.name }}</span></div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Pengguna</label>
                                    <input type="email" id="email" class="form-control" v-model="formUser.email">
                                    <div v-if="errors.email"><span class="text-danger">{{ errors.email }}</span></div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password Pengguna</label>
                                    <input type="password" id="password" class="form-control" v-model="formUser.password">
                                    <div v-if="errors.password"><span class="text-danger">{{ errors.password }}</span></div>
                                </div>
                                <div class="form-group">
                                    <label for="contact">Kontak Pengguna</label>
                                    <input type="text" id="contact" class="form-control" v-model="formUser.contact">
                                    <div v-if="errors.contact"><span class="text-danger">{{ errors.contact }}</span></div>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Foto Pengguna</label>
                                    <input type="file" id="photo" class="form-control" @input="formUser.photo = $event.target.files[0]" accept=".jpg,.jpeg,.png">
                                    <div v-if="errors.photo"><span class="text-danger">{{ errors.photo }}</span></div>
                                    <progress v-if="formUser.progress" :value="formUser.progress.percentage" max="100">
                                        {{ formUser.progress.percentage }}%
                                    </progress>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->        
    </Layout>
</template>
