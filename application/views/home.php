<!DOCTYPE html>
<html>
<head>
  <title>Game QR</title>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="<?= base_url("assets/bootstrap/plugins/jquery/jquery.min.js") ?>"></script>
  <script src="<?= base_url("assets/instanscan.js") ?>"></script>
  <link href="<?= base_url("assets/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
  <link href="<?= base_url("assets/bootstrap/plugins/node-waves/waves.css") ?>" rel="stylesheet" />
  <link href="<?= base_url("assets/bootstrap/plugins/animate-css/animate.css") ?>" rel="stylesheet" />
  <link href="<?= base_url("assets/bootstrap/plugins/material-design-preloader/md-preloader.css") ?>" rel="stylesheet" />
  <link href="<?= base_url("assets/bootstrap/css/style.css") ?>" rel="stylesheet">
  <link href="<?= base_url("assets/bootstrap/plugins/font-awesome/css/font-awesome.css") ?>" rel="stylesheet">
  <link href="<?= base_url("assets/bootstrap/css/themes/all-themes.css") ?>" rel="stylesheet" />
</head>
<body class="theme-red" id="bodi" status-input="0">
   <nav class="navbar">
       <div class="container-fluid">
           <div class="navbar-header">
               <a class="navbar-brand" href="./">Interactive Biograph</a>
           </div>
       </div>
   </nav>
   <section class="content">
    <div class="container-fluid">
      <center id="btnShit">
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-success btn-circle-lg waves-effect" type="button" id="startScan"><li class="fa fa-search"></li></button>
          </div>
        </div>
        <div class="row" style="padding-top:10px">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div align="center" class="embed-responsive embed-responsive-16by9">
              <video class="video" class="embed-responsive-item" id="cam" ></video>
            </div>
            <audio id="checklist" src="<?= base_url("assets/sound/check.wav") ?>"></audio>
          </div>
        </div>
      </center>
    </div>
    <div class="modal fade" id="tokohModal" tabindex="-1" role="dialog">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h4 class="modal-title" id="defaultModalLabel">Loading . .</h4>
                       </div>
                       <div class="modal-body">
                          Loading . .
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-link" data-dismiss="modal">CLOSE</button>
                       </div>
                   </div>
               </div>
           </div>
  </section>
  <!-- Waves Effect Plugin Js -->
  <script src="<?= base_url("assets/bootstrap/plugins/node-waves/waves.js") ?>"></script>
  </div>
</body>
<script>
base_url = "<?= base_url("rest/") ?>";
</script>
<script src="<?= base_url("assets/bootstrap/js/bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/bootbox.min.js") ?>"></script>
<script src="<?= base_url("assets/init.js") ?>"></script>
<script src="<?= base_url("assets/admin.js") ?>"></script>
<script>
$("#startScan").on("click",function() {
  getQR();
});
</script>
</html>
