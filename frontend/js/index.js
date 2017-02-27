$(document).ready(function() {

  $("#vis").hide();

const NO_SELECT = false;
const YES_SELECT = true;
const MIN_LENGTH = 3;

var textFieldState = NO_SELECT;

var data = [{
        name: 'Michael',
        description: 'The Writer'
    },
    {
        name: 'Ben',
        description: 'The Other Writer'
    },
    {
        name: 'Joel',
        description: 'The CodeIgniter Writer'
    }
];

$("#searchButton").click(function() {

  $("#vis").show();

  var $artistName = $("#automplete-1").val();
  $artistName = $artistName[0].toUpperCase() + $artistName.slice(1)
  document.getElementById("artist").innerHTML = "Artist: " + $artistName;

  $.ajax({
    type : 'GET',
    url: 'http://localhost:8080/api/wordcloud/new/' + $artistName,
    success: function(data) {
      tags = [];
      update();
      tags = data;
      update();
    },
    error: function(data) {
      alert("PHP Function call failed");
    }
  });

});

// grab the artist names/image
var getArray = function(JSONObject, givenKey) {
  var returnArray =[];
  $.each(JSONObject, function(key, data) {
         if(key == givenKey) {
           returnArray = data;
         }
  });
  return returnArray;
}

// call AJAX function
$("#automplete-1").autocomplete({
    source: function(request, response) {

        var $artistName = $("#automplete-1").val();
        console.log($artistName);

        $.ajax({
            type : 'GET',
            url: 'http://localhost:8080/api/dropdown/suggestions/' + $artistName,
            success: function(data) {

                var stringArray = $.map(data, function(item) {
                    return {
                      artist: item.artist,
                      id: item.id,
                      img: item.img
                    }
                });

                console.log(stringArray);

                response(stringArray);
            },
            error: function(data) {
                alert("PHP Function call failed");
            }
        })
    },
    focus: function(event, ui) {
      event.preventDefault();
      $("#automplete-1").val(ui.item.artist);
    },
    select: function(event, ui) {
      event.preventDefault();
      $("#automplete-1").val(ui.item.artist);
    },
    minLength: 3
}).data("ui-autocomplete")._renderItem=function(ul, item) {

    // old shit

    // var $li = $('<li>'),
    //     $img = $('<img style="object-fit:cover; width=50px; height=50px">');
    //
    // $img.attr({
    //   src: item.img,
    //   alt: item.artist
    // });
    //
    // $li.attr('data-value', item.artist);
    // $li.append('<a href="#">');
    // $li.find('a').append($img).append(item.artist);

    // new shit

    var $li = $('<li>'),
        $img = $('<img>');
        $header = $('<h2>');

    $img.attr({
       src: item.img,
       alt: item.artist
    });

    $header.val(item.artist);

    $li.append($img);
    $li.append($h2);
    
    ul.addClass("searchresults");

    return $li.appendTo(ul);
};

});
