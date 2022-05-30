<template>
	<!-- Page Wrapper -->
    <div id="wrapper">
        <Sidebar/>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <Topbar/>

                <slot/>
            </div>
            <!-- End of Main Content -->
            <Footer/>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	import "../Assets/Backend/vendor/jquery/jquery.min.js";
	import "../Assets/Backend/vendor/bootstrap/js/bootstrap.bundle.min.js";
	import "../Assets/Backend/vendor/jquery-easing/jquery.easing.min.js";
	import "../Assets/Backend/js/sb-admin-2.min.js";
    // import "../Assets/Backend/vendor/datatables/jquery.dataTables.min.js";
    // import "../Assets/Backend/vendor/datatables/dataTables.bootstrap4.min.js";

	import { Link } from '@inertiajs/inertia-vue3'
	import Sidebar from './Backend/Sidebar.vue'
	import Topbar from './Backend/Topbar.vue'
	import Footer from './Backend/Footer.vue'

	export default {
	  	components: {
	    	Link,
	    	Sidebar,
	    	Topbar,
	    	Footer
	  	}
	}
</script>

<style>
	@import '../Assets/Backend/vendor/fontawesome-free/css/all.min.css';
	@import url("https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i");
	@import '../Assets/Backend/css/sb-admin-2.min.css';
    @import "../Assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css";
</style>