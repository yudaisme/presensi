<script>
    import { ref } from 'vue';
    import Layout from "../../../Layouts/Layout.vue";
    import { useForm, usePage } from "@inertiajs/inertia-vue3";
    import Swal from 'sweetalert2';
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';

    export default {
        components: {
            Layout,
            Datepicker,
        },
        props:['config','errors'],
        mounted(){
            document.title = "Config | Master"
            $('#indukMaster').addClass('active')
            $('#collapseMaster').addClass('show')
            $('#dataTable').DataTable()
        },
        methods:{
            update(){
                this.formConfig.put(route("master.config.update"), {
                    onSuccess:() => {
                        $('#modalRole').modal('hide')
                    }
                })
            }
        },
        setup() {
            const config = usePage().props.value.config

            const dtHadir = config.jam_hadir.split(':')
            const dtPulang = config.jam_pulang.split(':')

            const jamHadir = ref({
                hours: dtHadir[0] ? dtHadir[0] : new Date().getHours(),
                minutes: dtHadir[1] ? dtHadir[1] : new Date().getMinutes()
            })

            const jamPulang = ref({
                hours: dtPulang[0] ? dtPulang[0] : new Date().getHours(),
                minutes: dtPulang[1] ? dtPulang[1] : new Date().getMinutes()
            })

            const formConfig = useForm({
                id: config.id,
                latitude: config.latitude,
                longitude: config.longitude,
                radius: config.radius,
                jam_hadir: jamHadir,
                jam_pulang: jamPulang,
            });
            // conso
            return { formConfig, jamHadir, jamPulang };
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
            <h1 class="h3 mb-4 text-gray-800">Config App</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Pengaturan</h6>                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form @submit.prevent="update">
                        <input type="hidden" v-model="formConfig.id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Titik Latitude</label>
                                    <input type="number" id="latitude" class="form-control" v-model="formConfig.latitude" min="-180" max="180" step="0.00000001">
                                    <span class="text-danger" v-if="errors.latitude">{{ errors.latitude }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Titik Longitude</label>
                                    <input type="number" id="longitude" class="form-control" v-model="formConfig.longitude" min="-180" max="180" step="0.000001">
                                    <span class="text-danger" v-if="errors.longitude">{{ errors.longitude }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="radius">Radius Kehadiran (meter)</label>
                                    <input type="number" id="radius" class="form-control" v-model="formConfig.radius" min="0" max="99999" step="1">
                                    <span class="text-danger" v-if="errors.radius">{{ errors.radius }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jam_hadir">Jam Hadir</label>
                                    <Datepicker v-model="formConfig.jam_hadir" timePicker />
                                    <span class="text-danger" v-if="errors.jam_hadir">{{ errors.jam_hadir }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jam_pulang">Jam Pulang</label>
                                    <Datepicker v-model="formConfig.jam_pulang" timePicker />
                                    <span class="text-danger" v-if="errors.jam_pulang">{{ errors.jam_pulang }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->        
    </Layout>
</template>
