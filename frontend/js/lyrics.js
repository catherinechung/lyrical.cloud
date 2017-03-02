$(document).ready(function() {
    var songName = localStorage.getItem('songName');
    var artist = localStorage.getItem('artist');
    var word = localStorage.getItem('word');
    var lyrics;

    // query musixmatch given song and artist to get lyrics
    $.ajax({
      type: 'GET',
      url: 'http://localhost:8080/api/lyrics/' + artist + '/' + songName,
      dataType: 'jsonp',
      success: function(data) {
        lyrics = data;
        document.title = songName + " by " + artist;
        document.getElementById("title").innerHTML = songName + " by " + artist;
        lyrics = lyrics.replace(/(\n|\r|\r\n)/g, "<br />");
        var regex = new RegExp('('+word+')', 'ig');
        lyrics = lyrics.replace(regex, '<span class="highlight">$1</span>');
        document.getElementById("lyrics").innerHTML = lyrics;
      },
      error: function(err) {
        console.log(err);
      }
    });
});
