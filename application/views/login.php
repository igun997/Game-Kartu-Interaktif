<!DOCTYPE html>
<html>
    <head>
        <title>Halaman Masuk</title>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php 
            foreach ($css as $key => $value) {
                printf("<link href='%s' rel='stylesheet' type='text/css'>\n",$value);;
            }
        ?>
    </head>
    <body class="theme-red">
        <div class="container">
            <div class="col-md-4 col-sm-4 col-xs-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                <form class="form-signin">
                    <h2 class="form-signin-heading" align="center">Login</h2>
                    <label for="inputEmail" class="sr-only">Username</label>
                    <input type="text" id="inputUser" autocomplete="off" class="form-control" placeholder="Username" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                    <div class="checkbox">
                    </div>
                    <button class="btn btn-lg btn-primary btn-block waves-effect" id="btnMasuk" type="button">Masuk</button>
                </form>
            </div>

        </div> <!-- /container -->
        <script>
            base_url = "<?= base_url("rest/") ?>";
            redir_base = "<?= base_url("admin") ?>";
        </script>
        <?php 
            foreach ($js as $key => $value) {
                printf("<script src='%s'></script>\n",$value);;
            }
        ?>
    </body>
</html>