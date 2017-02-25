$(document).ready(function() {

  // JSON object, parsing to get var word, also array of songs
  // parse through JSON object

  /* (1) Set the title of the Song List page */
  var title = {word: "Word"};
    // will parse in the word from the JSON object later (object.word)
  document.getElementById("songListTitle").innerHTML = title.word;

  /* (2) Populate song list */
    // from JSON object --> object.song, object.occurences
  var songs = [
          name = ['One Dance','Bad and Boujee', 'Shape of You', 'Chained to the Rhythm', 'Closer', 'Starboy'],
          frequency = ['10','9','8', '7', '6', '5']
      ];

  function makeOL(array1, array2) {
      // Create the list element
      var list = document.createElement('ol');

      for(var i = 0; i < array1.length; i++) {
          // Create the list item
          var item = document.createElement('li');

          // create the anchor item
          //var a = document.createElement('a');

          // Set its contents
          //a.textContent = array1[i] +" " + "(" + array2[i] + ")";

          //item.appendChild(a);
          item.appendChild(document.createTextNode(array1[i] +" " + "(" + array2[i] + ")"));

          // Create link to respective lyrics page
          item.addEventListener("click", loadSongLyricsPage(this), false);

          // Add it to the list
          list.appendChild(item);
      }

      // Return the constructed list
      return list;
  }

  // Add the contents of songs[0] to #songList:
  document.getElementById('songList').appendChild(makeOL(songs[0], songs[1]));

});

/* Back button, returns to Word Cloud Page */
function returnWordCloud() {
    window.location.href = "index.html";
}

// pass song, word, and artist to lyrics page
function loadSongLyricsPage(string) {
  return function(event) {
    var li = event.target;
  localStorage.setItem('songName', 'One Dance');
  localStorage.setItem('word', 'one');
  localStorage.setItem('artist', 'Drake');

  window.location.href = "lyrics.html";
}
}
