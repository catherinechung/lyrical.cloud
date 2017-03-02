$(document).ready(function() {

  // Set the title of the Song List page
  var songlist = localStorage.getItem('songlist');
  var word = localStorage.getItem('word');
  $("#songListTitle").html(word);

  function makeOL() {
      // Create the list element
      var list = document.createElement('ol');

      $.each(JSON.parse(songlist), function(key, value) {
        // Create the list item
        var item = document.createElement('li');

        // get frequency and artist name
        var freq = value["frequency"];
        var artist_name = value["artist_name"];

        // Set its contents
        item.appendChild(document.createTextNode(key + " " + "(" + freq + ")"));

        (function (key, artist_name, word) {
          item.addEventListener('click', function (event) {
            localStorage.setItem('songName', key);
            localStorage.setItem('artist', artist_name);
            window.location.href = "lyrics.html";
          },
          false);
        }(key, artist_name, word));

        // Add it to the list
        list.appendChild(item);
      });

      // Return the constructed list
      return list;
  }

  // Add the contents of songs[0] to #songList:
  document.getElementById('songList').appendChild(makeOL());

});

// Back button, returns to Word Cloud Page
function returnWordCloud() {
    window.location.href = "index.html";
}
