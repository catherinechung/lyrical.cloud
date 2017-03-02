
//var song = {songName: "One Dance", artist: "Drake", word: "one", lyrics:"Baby I like your style \r\n Grips on your legs \r\n Front way, back way \r\n You know that I don't play \r\n Streets not safe \r\n But I never run away \r\n Even when I'm away \r\n OT, OT is never much love when we go OT \r\n I pray to make it back in one piece \r\n I pray, I pray \r\n That's why I need a one dance \r\n Got the Hennessy in my hand \r\n One more time 'fore I go \r\n I have powers taking ahold on me \r\n I need a one dance \r\n Got the Hennessy in my hand \r\n One more time 'fore I go \r\n I have powers taking ahold on me"};

$(document).ready(function() {
    var songName = localStorage.getItem('songName');
    var artist = localStorage.getItem('artist');
    var word = " " + localStorage.getItem('word')+ " ";
    //console.log(word);
    var lyrics;

    //query API for lyrics
    $.ajax({
      type: 'get',
      url: 'http://localhost:8080/api/lyrics/' + artist + '/' + songName,
      success: function(data) {
       lyrics = data;
       console.log(data);
     }
   });

    //update elements on page

     document.title = songName + " by " + artist;
     document.getElementById("title").innerHTML = songName + " by " + artist;
     lyrics = lyrics.replace(/(\n|\r|\r\n)/g, "<br />");
     var regex = new RegExp('('+word+')', 'ig');
     lyrics = lyrics.replace(regex, '<span class="highlight">$1</span>');
     document.getElementById("lyrics").innerHTML = lyrics;
   });
