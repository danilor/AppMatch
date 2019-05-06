/**
 * This will log a message to the console
 * @param t
 */
function logM( t ){
    try{
        console.log( t );
    }catch ( err ){}
}
/**
 * This will hide all other sections and show the login
 */
function showLoginButton(){
    $( ".screentype" ).hide();
    $( "#facebook_login_button" ).show().css('display', 'flex');
}

function showFullPage(){
    $( ".screentype" ).hide();
    $( "#fullpage" ).show();
   // angular.element(document.getElementById('mainControllerID')).injector().‌​get('$rootScope');
}

function showLoadingPage(){
    $( ".screentype" ).hide();
    $( "#loading_screen" ).show();
    // angular.element(document.getElementById('mainControllerID')).injector().‌​get('$rootScope');
}

function showErrorScreen(){
    $( ".screentype" ).hide();
    $( "#error_analysing" ).show();
}

function showErrorFriends(){
    $( ".screentype" ).hide();
    $( "#error_friends" ).show();
}

function share_fb(url) {
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURI(url),'facebook-share-dialog',"width=600, height=400")
}

/**
 * This function will randomize an array
 * @param array
 * @returns {*}
 */
function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}

/**
 * This will generate an automatic post to feed for Facebook
 * @param title
 * @param desc
 * @param url
 * @param image
 */
function postToFeed(title, desc, url, image , mes){
    var obj = {method: 'feed',link: url, picture: image, name: title,description: desc, message:mes};
    logM( obj );
    function callback(response){}
    FB.ui(obj, callback);
}