<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">PERSONAL</li>
                <li> <a class="<?php if($this->uri->segment(1) == 'Dashboard_Supervisor' && $this->uri->segment(2) == ''){echo'active';} ?>active" href="<?= base_url(); ?>Dashboard_Supervisor" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </a>
                </li>
                <!-- <li class="nav-small-cap">OBV CASE</li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">OBV Case</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?= base_url(); ?>Dashboard_Supervisor/case_obv">Case List OBV</a></li>
                        <li><a href="<?= base_url(); ?>Dashboard_Supervisor/batching_obv">Batching List OBV</a></li>
                    </ul>
                </li>
                <li class="nav-small-cap">PENDING PAYMENT CASE</li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Payment Case</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?= base_url(); ?>Dashboard_Supervisor/case_payment">Case List Pending Payment</a></li>
                        <li><a href="<?= base_url(); ?>Dashboard_Supervisor/batching_payment">Batching List Pending Payment</a></li>
                    </ul>
                </li> -->
                 <li class="nav-small-cap">CPV</li>
                <li class=""> <a href="<?= base_url(); ?>Dashboard_Supervisor/cpv_list" aria-expanded="false"><i class="mdi mdi-file-excel"></i><span class="hide-menu">CPV List</span></a>
                </li>
                <li class="nav-small-cap">HISTORY</li>
                <li class=""> <a href="<?= base_url(); ?>Dashboard_Supervisor/history_batching" aria-expanded="false"><i class="mdi mdi-bookmark"></i><span class="hide-menu">History Batching</span></a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->