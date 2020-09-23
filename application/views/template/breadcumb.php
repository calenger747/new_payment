<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <?php if(!empty($breadcumb_3)){ ?>
            <h3 class="text-themecolor"><?= $breadcumb_3; ?></h3>
        <?php } else { ?>
            <h3 class="text-themecolor"><?= $breadcumb_2; ?></h3>
        <?php } ?>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $breadcumb_1; ?></a></li>
            <?php if(empty($breadcumb_3)){ ?>
                <li class="breadcrumb-item active"><?= $breadcumb_2; ?></li>
            <?php } else { ?>
                <li class="breadcrumb-item"><?= $breadcumb_2; ?></li>
                <li class="breadcrumb-item active"><?= $breadcumb_3; ?></li>
            <?php } ?>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->