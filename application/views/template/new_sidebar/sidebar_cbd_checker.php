<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- <li class="nav-small-cap">PERSONAL</li>
                <li> <a class="<?php if($this->uri->segment(1) == 'Dashboard_CBD_Checker' && $this->uri->segment(2) == ''){echo'active';} ?>active" href="<?= base_url(); ?>Dashboard_CBD_Checker" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </a>
                </li> -->
                <!-- <li class="nav-small-cap">OBV CASE</li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">OBV Case</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?= base_url(); ?>Dashboard_Admin/case_obv">Case List OBV</a></li>
                        <li><a href="<?= base_url(); ?>Dashboard_Admin/batching_obv">Batching List OBV</a></li>
                    </ul>
                </li>
                <li class="nav-small-cap">PENDING PAYMENT CASE</li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Payment Case</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?= base_url(); ?>Dashboard_Admin/case_payment">Case List Pending Payment</a></li>
                        <li><a href="<?= base_url(); ?>Dashboard_Admin/batching_payment">Batching List Pending Payment</a></li>
                    </ul>
                </li> -->
                <!-- <li class="nav-small-cap">DATA CASE</li>
                <li class=""> <a href="<?= base_url(); ?>Dashboard_CBD_Checker/case_data" aria-expanded="false"><i class="mdi mdi-database"></i><span class="hide-menu">Data Case</span></a></li> -->

                <li class="nav-small-cap">BATCHING CASE</li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-group"></i><span class="hide-menu">Batching Case</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?= base_url(); ?>Dashboard_CBD_Checker/batching_case">Proceed Status</a></li>
                        <!-- <li><a href="<?= base_url(); ?>Dashboard_CBD_Checker/payment_batch">Generate CPV</a></li> -->
                    </ul>
                </li>

                <!-- <li class="nav-small-cap">Upload Batching</li>
                <li class=""> <a href="<?= base_url(); ?>Dashboard_Admin/upload_batching" aria-expanded="false"><i class="mdi mdi-cloud-upload"></i><span class="hide-menu">Upload Case Batching</span></a
                    ></li> -->
                <!-- <li class="nav-small-cap">CPV</li>
                <li class=""> <a href="<?= base_url(); ?>Dashboard_Admin/cpv_list" aria-expanded="false"><i class="mdi mdi-file-excel"></i><span class="hide-menu">CPV List</span></a>
                </li> -->
                <!-- <li class="nav-small-cap">CPV</li>
                <li class=""> <a href="<?= base_url(); ?>Dashboard_Admin/list_cpv" aria-expanded="false"><i class="mdi mdi-file-excel"></i><span class="hide-menu">CPV List</span></a>
                </li> -->
                <li class="nav-small-cap">Follow Up Payment</li>
                <li class=""> <a href="<?= base_url(); ?>Dashboard_CBD_Checker/follow_up_payment" aria-expanded="false"><i class="mdi mdi-file-excel"></i><span class="hide-menu">Send Back Batching List</span></a>
                </li>
                <!-- <li class="nav-small-cap">HISTORY</li>
                <li class=""> <a href="<?= base_url(); ?>Dashboard_Admin/history_batching" aria-expanded="false"><i class="mdi mdi-bookmark"></i><span class="hide-menu">History Batching</span></a>
                </li> -->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->