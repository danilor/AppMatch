<?php require_once( "auto.php" ); global $config_page , $config_version , $config_facebook; ?>
<!doctype html>
<html lang="en" ng-app="fbchat" ng-controller="MainController" class="app_definition" ng-init="run()">
<head>
	<?php include_block( "header" ) ?>
</head>
<body class="mainbody">

<!--    LOADING SCREEN-->
    <div id="loading_screen" class="screentype absolute_center">
      <div>
            <p class="loading_message_class"><img src="img/loading.gif" alt="Loading" /></p>
            <p class="loading_message_class" ng-bind-html="loading_message"></p>
        </div>

    </div>
<!--MAIN CONTAINER-->
<!--FACEBOOK LOGIN BUTTON-->
    <div id="facebook_login_button" class="screentype absolute_center">

        <button class="btn btn-lg" ng-click="loginWithFacebook();"><span class="fa fa-facebook-f"></span> Log In with Facebook</button>
    </div>

    <div id="error_analysing" class="screentype absolute_center">
        <div>
            <p class="loading_message_class"><img src="img/dialog_warning.png" alt="Warning" /></p>
            <p class="loading_message_class">We couldn't retrieve your profile likes.<br /> The analysis was incomplete. Please check your profile privacy and try again.</p>
        </div>
    </div>

<div id="error_friends" class="screentype absolute_center">
    <div>
        <p class="loading_message_class"><img src="img/facebook.png" alt="Facebook" width="100px" /></p>
        <p class="loading_message_class">Seems like no one of your friends is using the Match App. Share the page and come back later to find your perfect match!</p>
        <p class="loading_message_class">
            <button onclick="share_fb( location.href );" class="btn btn-primary"> <i class="fa fa-facebook-f" aria-hidden="true"></i> Share on Facebook </button>
        </p>
    </div>
</div>

<div class="container screentype" id="fullpage">
        <!--    FULL PAGE DIV-->

        <div id="top_banner" class="row">
            <img src="" width="100%" />
        </div>
        <div class="row">
            <!-- Share button -->
            <!--<div class="shareButton">
                <a href="<?php echo get_current_url(); ?>" data-message="<?php echo $config_page[ "custom_message" ] ?>" data-image="<?php echo get_current_url(); ?><?php echo $config_page[ "share_image" ] ?>" data-title="<?php echo $config_page[ "title" ] ?>" data-desc="<?php echo $config_page[ "desc" ] ?>" class="btnShare btn btn-facebook-share"> <i class="fa fa-facebook-f" aria-hidden="true"></i> Share in Facebook </a>
            </div>-->

            <div class="col-xs-12 text-center">
                <img ng-src="{{ getProfilePicUrl( userId ) }}" />
            </div>
            <div class="col-xs-12 text-center">
                <h3 ng-bind="user_profile.name"></h3>
            </div>

            <div id="findmeamatch" class="col-xs-12 text-center">
                <div class="find_me_match_button">
                    <button ng-click="findMatch()" class="btn btn-primary"> <i class="fa fa-heart"></i> Find me a match</button>
                </div>
            </div>

            <div id="matchfound">
                <h2>Your perfect Match is:</h2>
                <img ng-click="openFacebookById( match_id );" ng-src="{{ getProfilePicUrl( match_id ) }}" />
                <p ng-bind-html="match_name"></p>
                <div id="heart"></div>
                <p><button class="btn btn-primary" ng-click="openModal();"> <i class="fa fa-facebook-f"></i> Post a message about it </button></p>
            </div>

        </div>

   <!-- <div class="row likes">

        <div class="col-xs-12">
            <h1>My Likes</h1>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 like" ng-repeat="( key , x ) in likes">
            <div class="like_image">
                <img ng-src="{{ getProfilePicUrl( x.id ) }}" />
            </div>
            <div class="like_name">
                {{ x.name  }}
            </div>
        </div>
    </div>-->

    <div class="row likes">

        <div class="like_title col-xs-12 text-center">
            <h3>My Likes</h3>
        </div>

        <div ng-click="openFacebookById( x.id );" data-toggle="tooltip" title="{{ x.name }}" class="like" ng-repeat="( key , x ) in likes">
            <img ng-src="{{ getProfilePicUrl( x.id ) }}" width="100%"/>
        </div>
    </div>

    <div class="row" id="share_area">
        <div class="col-xs-12 text-center">
            <button onclick="share_fb( location.href );" class="btn btn-primary"> <i class="fa fa-facebook-f" aria-hidden="true"></i> Share on Facebook </button>
        </div>
    </div>

    <div class="row">
        <img src="img/roses-bottom.png" width="100%" />
    </div>

</div>


<!-- Modal -->
<div id="sendMessage" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tag <img class="rounded" width="50" ng-src="{{ getProfilePicUrl( match_id ) }}" /> <b ng-bind="match_name">NAME</b> in your post!</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <textarea ng-model="message" class="form-control" rows="10" placeholder="Say something nice!"><</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-times" aria-hidden="true"></i> Cancel </button>
                <button ng-click="sendAndTag();" type="button" class="btn btn-primary" > <i class="fa fa-facebook-f" aria-hidden="true"></i> Post to Facebook</button>
            </div>
        </div>

    </div>
</div>


    <?php include_block( "footer_js" ) ?>
</body>
</html>