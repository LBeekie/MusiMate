function getTracks() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           //alert(xhttp.responseText);
            createPlaylist();
        }
    };
    xhttp.open("GET", "php/getTracks.php?accessToken=" + sessionStorage.getItem('accessToken'), true);
    xhttp.send();
}

//Create playlist
function createPlaylist() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Get playlist id
            //console.log(xhttp.responseText);
            var json = JSON.parse(xhttp.responseText);
            var playlistId = json.id;
            sessionStorage.setItem('playlistId', playlistId);
            //Add tracks
            addTracks();
        }
    };
    xhttp.open("GET", "php/createPlaylist.php?userId=" + sessionStorage.getItem('userId') + "&accToken=" + sessionStorage.getItem('accessToken'), true);
    xhttp.send();
}

//Add tracks to playlist
function addTracks() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           //Add tracks to playlist
           //console.log(xhttp.responseText);
        }
    };
    xhttp.open("GET", "php/addTracks.php?accToken=" + sessionStorage.getItem('accessToken') + "&playlistId=" + sessionStorage.getItem('playlistId'), true);
    xhttp.send();
}