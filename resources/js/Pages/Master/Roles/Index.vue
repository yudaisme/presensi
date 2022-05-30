<script>
    import Layout from "../../../Layouts/Layout.vue"
    import { useForm } from "@inertiajs/inertia-vue3";
    import Swal from 'sweetalert2';
    export default {
        components: {
            Layout,
        },
        props:['roles','errors'],
        mounted(){
            document.title = "Role | Master"
            $('#indukMaster').addClass('active')
            $('#collapseMaster').addClass('show')
            $('#dataTable').DataTable()
        },
        methods:{
            newData(){
                this.resetForm()
                $('#modalRole').modal('show')
            },
            editRole(role){
                this.resetForm()
                this.formRole.id = role.id
                this.formRole.name = role.name
                $('#modalRole').modal('show')
            },
            resetForm(){
                this.formRole.id = null
                this.formRole.name = null
            },
            storeOrUpdate(){
                this.formRole.post(route("master.role.storeOrUpdate"), {
                    onSuccess:() => {
                        this.resetForm()
                        $('#modalRole').modal('hide')
                    }
                })
            },
            deleteRole(id){
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
            const formRole = useForm({
                id: null,
                name: null,
            });

            return { formRole };
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
            <h1 class="h3 mb-4 text-gray-800">Manajemen Role</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Data Role</h6>                            
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-info btn-block" @click="newData()"><i class="fas fa-plus"></i>&nbsp;New Role</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(role,i) in roles" :key="role.id">
                                    <td>{{ i + 1 }}</td>
                                    <td>{{ role.name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="editRole(role)"><i class="fas fa-edit"></i></button>&nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" @click="deleteRole(role.id)"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal-->
            <div class="modal fade" id="modalRole" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Form Role</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form @submit.prevent="storeOrUpdate()">
                            <input type="hidden" v-model="formRole.id">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Role Name</label>
                                    <input type="text" id="name" class="form-control" v-model="formRole.name" required>
                                    <div v-if="errors.name"><span class="text-danger">{{ errors.name }}</span></div>
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
