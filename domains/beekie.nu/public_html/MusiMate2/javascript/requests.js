//Define vars
var CLIENT_ID = '02cbda7672eb460d999e50b2b3d20b78';
var SCOPES = [
  'playlist-modify-public',
  'playlist-modify-private'
];
var authToken; //Authorization token
var accToken; //Access token
var reftoken; //Refresh token

function hideLogin() {
  document.getElementById('loginWrap').style.display = 'none';
  document.getElementById('createPlaylistWrap').style.display = 'block';
}

function showLogin() {
  document.getElementById('loginWrap').style.display = 'block';
  document.getElementById('createPlaylistWrap').style.display = 'none';
}

//Execute on page load
window.addEventListener('load', pageload);

function pageload() {
    validateAuthentication(); //Check if already logged in on pageload
}

//On login button press --> get auth token
function login() {
    var redirect_uri = location.protocol + '//' + location.host + location.pathname;
	var url = 'https://accounts.spotify.com/authorize?client_id=' + CLIENT_ID +
		'&redirect_uri=' + encodeURIComponent(redirect_uri) +
		'&scope=' + SCOPES.join('&20') +
        //(scopes ? '&scope=' + encodeURIComponent(scopes) : '') +
		'&response_type=code';
	console.log('login url', url);
	location.href = url;
}

//Check if already logged in
function validateAuthentication() {
    console.log('location.search', location.search); //after ? in url
    var lochash = location.search.substr(1);
    var newAuthToken = lochash.substr(lochash.indexOf('code=')).split('&')[0].split('=')[1]; //Get auth token
    
    if (newAuthToken) { //Check if logged in
		sessionStorage.setItem('authToken', newAuthToken);
		authToken = newAuthToken;
	} else {
		authToken = sessionStorage.getItem('authToken');
	}
    
	if (authToken) { //Second check
		//connect(); //If accessToken has value then connect
		console.log("Auth token: " + authToken);
        hideLogin();
        getTokens();
	} else {
		showLogin(); //Else show the login button
	}
}

//Get access and refresh token
function getTokens() {
    var redirect_uri = location.protocol + '//' + location.host + location.pathname;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhttp.responseText);
            var json = JSON.parse(xhttp.responseText);
            accToken = json.access_token;
            refToken = json.refresh_token;
            //Store tokens
            sessionStorage.setItem('accessToken', accToken);
            sessionStorage.setItem('refreshToken', refToken);
        }
    };
    xhttp.open("GET", "php/getTokens.php?authToken=" + sessionStorage.getItem('authToken') + "&redirect_uri=" + redirect_uri, true);
    xhttp.send();
}