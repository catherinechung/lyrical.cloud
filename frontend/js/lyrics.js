
var song = {name:"One Dance", artist:"Drake", lyrics:"Baby I like your style \r\n Grips on your legs \r\n Front way, back way \r\n You know that I don't play \r\n Streets not safe \r\n But I never run away \r\n Even when I'm away \r\n OT, OT is never much love when we go OT \r\n I pray to make it back in one piece \r\n I pray, I pray \r\n That's why I need a one dance \r\n Got the Hennessy in my hand \r\n One more time 'fore I go \r\n I have powers taking ahold on me \r\n I need a one dance \r\n Got the Hennessy in my hand \r\n One more time 'fore I go \r\n I have powers taking ahold on me", word:"one"};


document.onreadystatechange = function () {
    if (document.readyState == "complete") {
     document.title = song.name + "by" + song.artist;
     document.getElementById("title").innerHTML = song.name + " by " + song.artist;

     var lyrics = song.lyrics;
     lyrics = lyrics.replace(/(\n|\r|\r\n)/g, "<br />");
	 var regex = new RegExp('('+song.word+')', 'ig');
     lyrics = lyrics.replace(regex, '<span class="highlight">$1</span>');
     document.getElementById("lyrics").innerHTML = lyrics;


   }
}