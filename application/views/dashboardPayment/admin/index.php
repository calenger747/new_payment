<?php if ($this->session->flashdata('notif')): ?>
    <script type="text/javascript">
        $(function() {
            "use strict";

            $.toast({
                heading: 'Login Success!',
                text: '<?php echo $this->session->flashdata("notif"); ?>',
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'success',
                hideAfter: 3500
            });
        });
    </script>
    <?php endif; ?>