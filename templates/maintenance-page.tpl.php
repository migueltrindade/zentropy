<?php
// $Id$

/**
 * @file
 * Implementation to display a single Drupal page while offline.
 *
 * All the available variables are mirrored in page.tpl.php.
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 * @see bartik_process_maintenance_page()
 */
?><?php print $doctype; ?>
<?php $html_tag_attrs = "lang=\"{$language->language}\" dir=\"{$language->dir}\" {$rdf->version}{$rdf->namespaces}";?>
<!-- If you don't care about older browsers remove the following declarations -->
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html <?php echo $html_tag_attrs;?> class="no-js ie6" <![endif]-->
<!--[if IE 7 ]> <html <?php echo $html_tag_attrs;?> class="no-js ie7" <![endif]-->
<!--[if IE 8 ]> <html <?php echo $html_tag_attrs;?> class="no-js ie8" <![endif]-->
<!--[if IE 9 ]> <html <?php echo $html_tag_attrs;?> class="no-js ie9" <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php echo $html_tag_attrs;?> class="no-js"> <!--<![endif]-->

<head<?php print $rdf->profile; ?>>

  <?php print $head; ?>
  
  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame  -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <!--  Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Prevent blocking -->
  <!--[if IE 6]><![endif]-->
  
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <!-- IMPORTANT: Install html5shiv to enable full HTML5 support. See README.txt -->
  <!--[if LT IE 9]>
  <!--<script src="js/libs/html5.js"></script>
  <![endif]-->
  <!--[if LTE IE 8]><style type="text/css" media="all">@import "<?php echo base_path() . path_to_theme() ?>/css/ie.css";?></style><![endif]-->
  <!--[if LTE IE 7]><style type="text/css" media="all">@import "<?php echo base_path() . path_to_theme() ?>/css/ie7.css";?></style><![endif]-->
  <!--[if LTE IE 6]><style type="text/css" media="all">@import "<?php echo base_path() . path_to_theme() ?>/css/ie6.css";?></style><![endif]-->

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css">  -->

  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <!-- IMPORTANT: Uncomment the following line and install Modernizr to enable full HTML5 support. See README.txt -->
  <!--<script src="js/libs/modernizr-1.6.min.js"></script>-->

</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>

  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>

  <?php print $page_top; ?>

  <div id="page-wrapper"><div id="page">

      <header id="header" role="banner">
        <div class="section clearfix">
          <?php if ($site_name || $site_slogan): ?>
            <div id="name-and-slogan"<?php if ($hide_site_name && $hide_site_slogan) { print ' class="element-invisible"'; } ?>>
              <?php if ($site_name): ?>
                <div id="site-name"<?php if ($hide_site_name) { print ' class="element-invisible"'; } ?>>
                  <strong>
                    <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                  </strong>
                </div>
              <?php endif; ?>
              <?php if ($site_slogan): ?>
                <div id="site-slogan"<?php if ($hide_site_slogan) { print ' class="element-invisible"'; } ?>>
                  <?php print $site_slogan; ?>
                </div>
              <?php endif; ?>
            </div> <!-- /#name-and-slogan -->
          <?php endif; ?>
        </div><!-- /.section -->
      </header><!-- /#header -->

      <div id="main-wrapper">
        <div id="main" class="clearfix">
          <div id="content" class="column" role="main">
            <div class="section">
              <a id="main-content"></a>
              <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
              <?php print $content; ?>
              <?php if ($messages): ?>
                <div id="messages">
                  <div class="section clearfix">
                    <?php print $messages; ?>
                  </div><!-- /.section -->
                </div><!-- /#messages -->
              <?php endif; ?>
            </div><!-- /.section -->
          </div><!-- /#content -->
        </div><!-- /#main -->
      </div><!-- /#main-wrapper -->

      </div><!-- /#page -->
    </div><!-- /#page-wrapper -->

  <?php print $page_bottom; ?>

  <!-- Javascript at the bottom for fast page loading -->
  <?php print $scripts; ?>
  
  <!-- Uncomment lines 80 and 81 to support transparent PNGs in IE6 and below -->
  <!--[if lt IE 7 ]>
    <!--<script src="js/libs/dd_belatedpng.js"></script>
    <!--<script> DD_belatedPNG.fix('img, .png_bg'); //fix any <img> or .png_bg background-images </script>
  <![endif]-->
  
  <?php if (!user_is_logged_in() && theme_get_setting('ga_enable')) :?>
  <!-- Google Analytics : mathiasbynens.be/notes/async-analytics-snippet -->
  <script type="text/javascript">
    <!--//--><![CDATA[//><!--
    var _gaq=[['_setAccount','<?php echo theme_get_setting('ga_trackingcode');?'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
    //--><!]]>
  </script>
  <?php endif; ?>

</body>
</html>
