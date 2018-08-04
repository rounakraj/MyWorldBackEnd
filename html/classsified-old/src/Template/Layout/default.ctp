<!DOCTYPE html>
<?php use Cake\Core\Configure; ?>
<html dir="ltr" lang="en">

<head>



<!-- Meta Tags -->

<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<meta name="description" content="<?php echo $metaDescription;?>" />

<meta name="keywords" content="<?php echo $metaKeyword;?>" />

<meta name="author" content="OyeWebs" />

<!-- Page Title -->

<title><?php echo Configure::read('App.siteName').' :: '.$layoutTitle;?></title>

<!-- Favicon and Touch Icons -->

<link href="<?php echo Configure::read('App.siteurl');?>images/favicon.png" rel="shortcut icon" type="image/png">

<!-- Stylesheet -->

<link href="<?php echo Configure::read('App.siteurl');?>css/bootstrap.min.css" rel="stylesheet" type="text/css">

<link href="<?php echo Configure::read('App.siteurl');?>css/jquery-ui.min.css" rel="stylesheet" type="text/css">

<link href="<?php echo Configure::read('App.siteurl');?>css/animate.css" rel="stylesheet" type="text/css">

<link href="<?php echo Configure::read('App.siteurl');?>css/css-plugin-collections.css" rel="stylesheet"/>

<!-- CSS | menuzord megamenu skins -->

<link id="menuzord-menu-skins" href="<?php echo Configure::read('App.siteurl');?>css/menuzord-skins/menuzord-rounded-boxed.css" rel="stylesheet"/>

<!-- CSS | Main style file -->

<link href="<?php echo Configure::read('App.siteurl');?>css/style-main.css" rel="stylesheet" type="text/css">

<!-- CSS | Preloader Styles -->

<link href="<?php echo Configure::read('App.siteurl');?>css/preloader.css" rel="stylesheet" type="text/css">

<!-- CSS | Custom Margin Padding Collection -->

<link href="<?php echo Configure::read('App.siteurl');?>css/custom-bootstrap-margin-padding.css" rel="stylesheet" type="text/css">

<!-- CSS | Responsive media queries -->

<link href="<?php echo Configure::read('App.siteurl');?>css/responsive.css" rel="stylesheet" type="text/css">

<!-- CSS | Style css. This is the file where you can place your own custom css code. Just uncomment it and use it. -->

<!-- <link href="<?php echo Configure::read('App.siteurl');?>css/style.css" rel="stylesheet" type="text/css"> -->



<!-- Revolution Slider 5.x CSS settings -->

<link  href="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/css/settings.css" rel="stylesheet" type="text/css"/>

<link  href="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/css/layers.css" rel="stylesheet" type="text/css"/>

<link  href="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/css/navigation.css" rel="stylesheet" type="text/css"/>



<!-- CSS | Theme Color -->

<link href="<?php echo Configure::read('App.siteurl');?>css/colors/theme-skin-color-set-1.css" rel="stylesheet" type="text/css">



<!-- external javascripts -->

<script src="<?php echo Configure::read('App.siteurl');?>js/jquery-2.2.4.min.js"></script>

<script src="<?php echo Configure::read('App.siteurl');?>js/jquery-ui.min.js"></script>


<script src="<?php echo Configure::read('App.siteurl');?>js/bootstrap.min.js"></script> 

<script src="<?php echo Configure::read('App.siteurl');?>js/jquery-plugin-collection.js"></script>
<!-- Revolution Slider 5.x SCRIPTS -->



<!-- JS | jquery plugin collection for this theme -->


<script src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/jquery.themepunch.tools.min.js"></script>

<script src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>



</head>

<body class="">

<div id="wrapper" class="clearfix">

  <!-- Header -->

  <?php echo $this->element('header');?>


  <!-- Start main-content -->

  <div class="main-content">

  

  

    <section class="" id="page<?=$pages->id?>">

      <div class="container">

        <div class="section-content">

          <div class="row">

            <?php echo $this->fetch('content');?>
			
          </div>

        </div>

      </div>

    </section>
   
    

    

  <!-- end main-content -->

  </div>



  <!-- Footer -->

  <?php echo $this->element('footer');?>
  
  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>

</div>

<!-- end wrapper -->



<!-- Footer Scripts -->

<!-- JS | Custom script for all pages -->

<script src="<?php echo Configure::read('App.siteurl');?>js/custom.js"></script>



<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  

      (Load Extensions only on Local File Systems ! 

       The following part can be removed on Server for On Demand Loading) -->
<?php //if($this->request->params['controller'] != 'Products'  && $this->request->params['action'] != 'view') { ?>
<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.actions.min.js"></script>

<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.carousel.min.js"></script>

<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js"></script>

<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.275.dela"></script>

<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.migration.min.js"></script>

<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.navigation.min.js"></script>

<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.parallax.min.js"></script>

<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js"></script>

<script type="text/javascript" src="<?php echo Configure::read('App.siteurl');?>js/revolution-slider/js/extensions/revolution.extension.video.min.js"></script>
<?php //} ?>


</body>

</html>