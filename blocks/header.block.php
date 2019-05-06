<?php global $config_page , $config_version , $config_facebook; ?>
<!--GENERAL META-->
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title><?php echo $config_page[ "title" ] ?></title>

<meta property="og:title" content="<?php echo $config_page[ "title" ] ?>" />
<meta property="og:description" content="<?php echo $config_page[ "desc" ] ?>" />
<meta property="og:image" content="<?php echo get_current_url(); ?><?php echo $config_page[ "share_image" ] ?>" />
<meta property="og:url" content="<?php echo get_current_url(); ?>" />
<meta property="fb:app_id" content="<?php echo $config_facebook["app_id"]; ?>" />
<meta property="og:type" content="<?php echo $config_facebook["type"]; ?>" />


<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />

<!--BOOTSTRAP-->
<link rel="stylesheet" href="assets/bootstrap/<?php echo $config_version["bootstrap"] ?>/css/bootstrap.min.css" />
<link rel="stylesheet" href="assets/bootstrap/<?php echo $config_version["bootstrap"] ?>/css/bootstrap-theme.min.css" />
<!--FONT AWESOME-->
<link rel="stylesheet" href="assets/fontawesome/4.7.0/css/font-awesome.min.css" />
<!--CUSTOM STYLES-->
<link rel="stylesheet" href="css/styles.css" />
<!--ANGULAR : For some reason, they recomend to use it on the top of the page-->
<script type="text/javascript" src="assets/angular/1.6/angular.min.js"></script>
<script type="text/javascript" src="assets/angular/1.6/sanitize.js"></script>
<!--FACEBOOK APP SCRIPT-->
<script type="text/javascript" id="facebook-jssdk" src="https://connect.facebook.net/en_US/sdk.js"></script>
<!--    LOWER THAN IE 9 CONDITIONAL-->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->