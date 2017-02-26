 
var word = localStorage.getItem('word');
// localStorage.getItem('artist')
var artist = "Drake";

$(document).ready(function() {

  // Set the title of the Song List page
  document.getElementById("songListTitle").innerHTML = word;

  // Populate song list
  var songs = [
          name = ['One Dance','Hotline Bling', 'Fake Love', 'Headlines', 'Jumpman'],
          frequency = ['10','9','8', '7', '6']
      ];

  function makeOL(array1, array2) {
      // Create the list element
      var list = document.createElement('ol');

      for(var i = 0; i < array1.length; i++) {
          // Create the list item
          var item = document.createElement('li');

          // Set its contents
          item.appendChild(document.createTextNode(array1[i] +" " + "(" + array2[i] + ")"));

          // Create link to respective lyrics page
          item.addEventListener("click", loadSongLyricsPage(this, array1[i]), false);

          // Add it to the list
          list.appendChild(item);
      }

      // Return the constructed list
      return list;
  }

  // Add the contents of songs[0] to #songList:
  document.getElementById('songList').appendChild(makeOL(songs[0], songs[1]));

});

// Back button, returns to Word Cloud Page
function returnWordCloud() {
    window.location.href = "index.html";
}

// Pass song, word, and artist to lyrics page
function loadSongLyricsPage(item, song) {
  return function(event) {
    localStorage.setItem('songName', song);
    localStorage.setItem('word', word);
    localStorage.setItem('artist', artist);
    window.location.href = "lyrics.html";
}
}
