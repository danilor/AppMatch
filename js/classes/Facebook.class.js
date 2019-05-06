class Facebook{


    constructor( appid, version ) {
        this.log( "Facebook Constructor: " + appid + " - " + version );
        this.appid      =   appid;
        this.version    =   version;
    };

    /**
     * Log Text
     * @param t
     */
    log( t ){
        try{
            console.log( "FacebookClass: " + t );
        }catch ( err ){}
    };

    /**
     * Log Object
     * @param o
     */
    logO( o ) {
        try{
            console.log( o );
        }catch ( err ){}
    };

    /**
     * Facebook Initialize
     */
    initialize(){
        this.log( "Facebook Initialize" );
        this.log( "API ID:" + this.appid  );
        this.log( "VERSION:" + this.version  );
        FB.init({
            appId      : this.appid,
            cookie     : true,
            xfbml      : true,
            version    : this.version
        });

        this.checkLoginStatus();
    };

    /**
     * Checks login status
     */
    checkLoginStatus(){
        this.log( "Checking Facebook Status" );
        FB.getLoginStatus(function(response) {
            $scope.FacebookClass.analizeStatus( response );

        });
    };

    /**
     * We are going to analize the response
     * @param response
     */
    analizeStatus( response ){
        this.log( "Facebook Status Response" );
        this.logO( response );
        /**
         *  Now that we have the response, we have to decide if the user is connected or not.
         */
        if( response.status == "connected" ){
            this.connected = true;
            this.accessToken     =   response.authResponse.accessToken;
            this.userId         =   response.authResponse.userID;
            this.getUserInformation();
            if( typeof showFullPage != "undefined" ){
                showFullPage();
            }
        }else{
            this.connected = false;
            showLoginButton();
        }
    };


    getUserInformation( ){
        this.log( "Getting user Information" );
        FB.api(
            "/me?fields=email,name,first_name,last_name,cover,&access_token=" + $scope.FacebookClass.accessToken ,
            function (response) {
                FacebookClass.logO( response );
                if (response && !response.error) {
                    $scope.FacebookClass.logO( response );
                    this.user_profile = response;
                }
            }
        );
    };

}
