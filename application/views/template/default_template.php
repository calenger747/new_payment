<!DOCTYPE html>
<html lang="en">
<head>
	<?= $page["head"]; ?>
</head>
<body class="fix-header fix-sidebar card-no-border">
	<div class="preloader">
		<svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
		</svg>
	</div>
	<!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
    	<?= $page["navbar"]; ?>
    	<?= $page["sidebar"]; ?>
    	<div class="page-wrapper">
    		<?= $page["breadcumb"]; ?>
    		<div class="container-fluid">
    			<?= $content; ?>
    		</div>
    		<?= $page["footer"]; ?>
    	</div>
    </div>
    <?= $page["js"]; ?>
</body>
</html>