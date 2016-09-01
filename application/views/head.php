
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  <title><?php echo $title; ?></title>

  <!--icheck-->
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/square.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/blue.css" rel="stylesheet">

  
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/flat/blue.css" rel="stylesheet">
  <!--dashboard calendar-->
  <link href="<?php echo base_url(); ?>assets/css/clndr.css" rel="stylesheet">

  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/morris-chart/morris.css">

  <!--common-->
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">

  <!--dynamic table-->
  <link href="<?php echo base_url(); ?>assets/js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/data-tables/DT_bootstrap.css" />
  
   <!--pickers css-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
   <!--pickers css-->
   <!--Full calendar CSS-->
   <link href="<?php echo base_url(); ?>assets/js/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
   <!--Full calendar CSS-->
   <!--dropzone css-->
  <link href="<?php echo base_url(); ?>assets/js/dropzone/css/dropzone.css" rel="stylesheet"/>

    <!--file upload-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-fileupload.min.css" />
    <!--file upload-->
    <?php 
     if (isset($css)) {
        foreach ($css as $val) {
         echo '<link href="' . base_url() . 'assets/css/' . $val . '.css" rel="stylesheet" type="text/css" />';
        }
    } 
    ?>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js"></script>	
</head>