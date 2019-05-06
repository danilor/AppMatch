//The controller definition

app.controller('MainController', function( $scope, $window , $sce , $http , $location ) {
    $scope.controller      =       true;

    $scope.controller_name      =       'MainController';

    $scope.app_id               =       null;
    $scope.version              =       null;

    $scope.user_profile         =       null;

    $scope.friends              =       [];

    $scope.selected_user        =       null;
    $scope.selected_id          =       null;

    $scope.message              =       '';

    $scope.loading_message      =       'Loading';


    $scope.match_class          =       'is_a_match';

    /**
     * Information from Facebook API
     */
    $scope.likes                =       {};
    $scope.friends              =       {};
    $scope.local_friends        =       new Array();


    $scope.match_id             =       0;
    $scope.match_name           =       '';


    /**
     * The message that is going to be send to the user
     */
    $scope.message              =       'Hey. You are my perfect Match!';


    /**
     * This function will be executed at the beginning of the page load
     */
    $scope.run                          =           function(){
        // First run code in here
        logM( "Angular Run" );
        //$scope.friends = shuffle( $scope.friends );
    };

    angular.element(document).ready(function () {
        logM( "Angular Page Load" );
        $scope.app_id       =       ex_app_id;
        $scope.version      =       ex_version;
        logM( "Facebook Initialize" );
        logM( "API ID:" + $scope.app_id  );
        logM( "VERSION:" + $scope.version  );
        FB.init({
            appId      : $scope.app_id,
            cookie     : true,
            xfbml      : true,
            version    : $scope.version
        });
        showLoadingPage();
        //showErrorScreen();
        $scope.checkLoginStatus();
    });

    /**
     * Executes the Login with Facebook functionality
     */
    $scope.loginWithFacebook            =           function(){
        $window.FB.login(function(response) {
            $scope.checkLoginStatus();
        }, {scope: 'email,user_friends,user_likes,publish_actions' ,  auth_type: 'reauthenticate'});
    }

    /**
     * It checks for the login status in Facebook
     */
    $scope.checkLoginStatus             =           function(){
        logM( "Checking Facebook Status");
        FB.getLoginStatus(function(response) {
            $scope.analizeStatus( response );
        });
    };

    /**
     * It will analyses the Facebook status. It means that it will check if it has all the required permissions
     * @param response
     */
    $scope.analizeStatus                =           function( response ){
        logM( "Facebook Status Response" );
        logM( response );
        /**
         *  Now that we have the response, we have to decide if the user is connected or not.
         */
        if( response.status == "connected" ){
            $scope.connected = true;
            $scope.accessToken      =   response.authResponse.accessToken;
            $scope.userId           =   response.authResponse.userID;
            logM( $scope.userId );
            $scope.getUserInformation();
            // WE are showing the full page only when the user information is loaded
        }else{
            this.connected = false;
            showLoginButton();
        }
        $scope.updateAll();
    };

    $scope.getUserInformation           =           function( ){
        logM( "Getting user Information" );
        showLoadingPage();
        $scope.loading_message      =       'Analysing user information';
        FB.api(
            "/me?fields=email,name,first_name,last_name&access_token=" + $scope.accessToken ,
            function (response) {
                logM( response );
                if (response && !response.error) {
                    $scope.user_profile = response;
                }
                $scope.getUserLikes();
            }
        );
    };

    /**
     * This function will read the likes of an user and store them in the database. If the likes are already there, they will be updated.
     */
    $scope.getUserLikes                 =           function(  ){
        logM( "Getting user likes" );
        FB.api(
            "/me/likes",
            function (response) {
                logM( response );
                if (response && !response.error) {
                    $scope.likes                =       response.data;
                    var likes_to_insert         =       "";

                    /**Now we are going to store the likes information*/
                    angular.forEach($scope.likes, function(value, key) {
                            likes_to_insert += value.id + ";;" + value.name + "[|]";
                    }, $scope.likes);

                    logM( "Likes to Insert" );
                    logM( likes_to_insert );

                    var url = 'process/store_likes.process.php';
                    $.post( url , { user_id: $scope.userId, likes: likes_to_insert , user_name : $scope.user_profile.name } ).done(function( data ) {
                        logM( data );
                        if( data.error.id == 0 ){
                            logM( "Success getting likes" );
                            $scope.getUserFriends();
                        }else{
                            showErrorScreen();
                        }
                    }).fail(function( data ){
                        showErrorScreen();
                    });
                }else{
                    showErrorScreen();
                }
            }
        );
    };

    /**
     * This function will get the user friends list
     */
    $scope.getUserFriends           =           function(  ){
        // Getting the user friends.
        $scope.loading_message  =       "Getting friends list";
        FB.api(
            '/me/friends',
            'GET',
            {},
            function(response) {
                if (response && !response.error) {
                    logM( "Success getting friends" );
                    logM( response.data );
                    $scope.friends      =       response.data;

                    var friends_ids = "";
                    angular.forEach( $scope.friends , function(value, key) {
                        friends_ids += value.id + ',';
                    }, $scope.friends);

                    logM( "Friends IDs String" );
                    logM( "IDs of friends " + friends_ids.length );
                    logM( friends_ids );


                    if(  friends_ids.length > 0 ){
                        var url = 'process/get_match_app_friends.process.php';
                        // Now that we have the users list, we have to get the actual users list using this match
                        $.post( url , { fids: friends_ids } ).done( function( data ){
                            logM( data );
                            if( data.error.id == 0 ){
                                logM( "Complete accesing the local friends list" );
                                angular.forEach(data.data.friends, function(value, key) {
                                    $scope.local_friends.push({
                                        id      :       value.id,
                                        name    :       value.name,
                                    });
                                }, data.data.friends);

                                logM( $scope.local_friends );

                                // We have to show the page only when the information has been stored
                                if( typeof showFullPage != "undefined" ){
                                    showFullPage();
                                    $scope.updateAll();
                                }
                            }else{
                                showErrorScreen();
                            }
                        } );
                    }else{
                        showErrorFriends();
                    }





                }else{
                    showErrorScreen();
                }
            }
        );
    };
    $scope.getProfilePicUrl             =           function( id ){
        return 'http://graph.facebook.com/' + id + '/picture?type=square';
    };
    $scope.getProfileUrl                =           function( id ){
        return 'http://www.facebook.com/' + id;
    };


    /**
     * It will execute the match function to find the partner
     * @param key
     * @param id
     */
    $scope.findMatch                =           function( key , id ){

        /**
         * We are going to show the loading screen while we get this analysis
         */

        showLoadingPage();
        $scope.loading_message = 'Finding your match! Please wait';

        var area_id = 'current_listing_friends';


        var url = 'process/find_me_match.process.php';
        var friends_ids = "";
        angular.forEach( $scope.friends , function(value, key) {
            friends_ids += value.id + ',';
        }, $scope.friends);
        logM( "Friends IDs String" );
        logM( friends_ids );
        $.post( url, { user_id:  $scope.userId , fids: friends_ids } ).done(function( data ){
            showFullPage();
            logM( "Success matching" );
            logM( data );
            if( data.error.id == 0 ){
                //$(window).scrollTop($('#' + area_id ).offset().top); // This is to scroll the page to the area div
                logM( data.data.points[0] );

                $("." + $scope.match_class).removeClass( $scope.match_class );
                //$(".friend_" + data.data.points[0].id).addClass( $scope.match_class );

                $(".find_me_match_button").hide();
                $("#matchfound").show();
                $scope.match_id     =       data.data.points[0].id;
                $scope.match_name   =       data.data.points[0].name;
                $scope.updateAll();

            }else{
                showErrorScreen();
            }
        });
    };

    $scope.openFacebookById             =       function( id ){
        window.open( 'https://facebook.com/' + id );
    };
    $scope.updateAll                    =       function(){
        $scope.$apply();
        $('[data-toggle="tooltip"]').tooltip(); // This is in case we have items with tooltips.
    };



    $scope.openModal                  =           function(){
        $( "#sendMessage" ).modal( "show" );
    };

    $scope.sendAndTag                   =           function(){

        var m = $scope.message;
        var id =    $scope.match_id;
        logM( "Preparing message to be sent" );

        logM( m );
        logM( id );

        var post_data = {
            "message": m,
            "link":window.location.href,
            "tags":id,
            "place":'134337267229205'
        };
        logM( post_data );

        FB.api(
            "/me/feed",
            "POST",
            post_data,
            function (response) {
                logM( response );
                if (response && !response.error) {
                    $( "#sendMessage" ).modal( "hide" );
                    $scope.message = '';
                    $scope.selected_id = '';
                }
            }
        );

    };

});