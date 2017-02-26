
var song = {lyrics:"Baby I like your style \r\n Grips on your legs \r\n Front way, back way \r\n You know that I don't play \r\n Streets not safe \r\n But I never run away \r\n Even when I'm away \r\n OT, OT is never much love when we go OT \r\n I pray to make it back in one piece \r\n I pray, I pray \r\n That's why I need a one dance \r\n Got the Hennessy in my hand \r\n One more time 'fore I go \r\n I have powers taking ahold on me \r\n I need a one dance \r\n Got the Hennessy in my hand \r\n One more time 'fore I go \r\n I have powers taking ahold on me"};


//document.onreadystatechange = function () {
$(document).ready(function() {
    var songName = localStorage.getItem('songName');
    var artist = localStorage.getItem('artist');
    var word = " " + localStorage.getItem('word')+ " ";
    console.log(word);
    var lyrics;

    /*$.ajax({
      type: 'post',
      url: '../php/lyrics.php',
      data: {songNameData: songName, artistData: artist},
      success: function(output) {
        lyrics = output;
      }
  });*/
     //query musixmatch given song and artist to get lyrics


    //if (document.readyState == "complete") {
     document.title = songName + " by " + artist;
     document.getElementById("title").innerHTML = songName + " by " + artist;

     lyrics = song.lyrics;
     lyrics = lyrics.replace(/(\n|\r|\r\n)/g, "<br />");
	 var regex = new RegExp('('+word+')', 'ig');
     lyrics = lyrics.replace(regex, '<span class="highlight">$1</span>');
     document.getElementById("lyrics").innerHTML = lyrics;
   //}
}
