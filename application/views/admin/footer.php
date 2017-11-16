<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

                </section>
                <!-- /.content -->
            </div>

    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            MVC Partner PHP Indonesia
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2017 <a href="#">SystemFive</a>.</strong> All rights reserved. </footer>
    <div class="control-sidebar-bg">
    </div>
    <script>
            base_url = "<?= base_url("rest/") ?>";
            redir_base = "<?= base_url("admin") ?>";
            base_assets = "<?= base_url() ?>";
            identity = "<?= $csf ?>";
        </script>
    <?php 
            foreach ($js as $key => $value) {
                printf("<script src='%s'></script>\n",$value);;
            }
        ?>

    </body>

    </html>
