<?php global $config_page , $config_version , $config_facebook; ?>
<!--JQUERY-->
<script type="text/javascript" src="assets/jquery/<?php echo $config_version["jquery"] ?>/jquery.min.js"></script>
<!--BOOTSTRAP-->
<script type="text/javascript" src="assets/bootstrap/<?php echo $config_version["bootstrap"] ?>/js/bootstrap.min.js"></script>
<!-- ANGULAR ADDS -->
<script type="text/javascript" src="js/angular/app/fbchat.js"></script>
<script type="text/javascript" src="js/angular/controllers/MainController.js"></script>
<!--CLASSES-->
<script type="text/javascript" src="js/classes/Facebook.class.js"></script>
<!-- GENERAL SCRIPTS -->
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
    var ex_app_id      =   '<?php echo $config_facebook["app_id"] ?>';
    var ex_version     =   '<?php echo $config_facebook["version"] ?>';
    /**
     * Windows on Load
     * */
    $(window).on("load", function() {
        logM( "Window on Load" );
    });
    /**
     * Document load
     */
    $( document ).ready( function( event ){
        logM( "Document Ready" );
        $('.btnShare').click(function(){
            logM( "Share button clicked" );
            elem = $(this);
            postToFeed(  elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image') , elem.data('message')  );
            return false;
        });
    } );
</script>