
$(document).ready(function() {

  // JSON object, parsing to get var word, also array of songs
  // parse through JSON object

  // set the title of the Song List Page
  var title = {word: "One Dance"}
    // will parse in the word from the JSON object later (object.word)
  document.getElementById("songListTitle").innerHTML = title.word;

  // populate song List
    // from JSON object --> object.song, object.occurences
  var songs = [
          name = ['One Dance','Bad and Boujee', 'Shape of You', 'Chained to the Rhythm', 'Closer', 'Starboy'],
          frequency = ['10','9','8', '7', '6', '5']
      ];

  function makeOL(array1, array2) {
      // Create the list element:
      var list = document.createElement('ol');

      for(var i = 0; i < array1.length; i++) {
          // Create the list item:
          var item = document.createElement('li');

          // Set its contents:
          item.appendChild(document.createTextNode(array1[i] +" " + "(" + array2[i] + ")"));

          // Add it to the list:
          list.appendChild(item);
      }

      // Finally, return the constructed list:
      return list;
  }

  // Add the contents of songs[0] to #songList:
  document.getElementById('songList').appendChild(makeOL(songs[0], songs[1]));

  // create links for each song


});

  // back button, returns to Word Cloud Page
  function returnWordCloud() {

  }
