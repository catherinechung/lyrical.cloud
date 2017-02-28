$(document).ready(function() {

  $.ajax({
    type : 'GET',
    url: 'http://localhost:8080/',
    dataType: 'jsonp',
  });

  $("#vis").hide();

const NO_SELECT = false;
const YES_SELECT = true;
const MIN_LENGTH = 3;

var textFieldState = NO_SELECT;

$("#searchButton").click(function() {

  $("#vis").show();

  var $artistName = $("#automplete-1").val();
  $artistName = $artistName[0].toUpperCase() + $artistName.slice(1)
  document.getElementById("artist").innerHTML = "Artist: " + $artistName;

  $.ajax({
    type : 'GET',
    url: 'http://localhost:8080/api/wordcloud/new/' + $artistName,
    dataType: 'jsonp',
    success: function(data) {
      tags = data;
      update();
    },
    error: function(err) {
      console.log(err);
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
        var artistName = $("#automplete-1").val();
        $.ajax({
            type : 'GET',
            url: 'http://localhost:8080/api/dropdown/suggestions/' + artistName,
            dataType: 'jsonp',
            success: function(data) {
                var stringArray = $.map(data, function(item) {
                    return {
                      artist: item.artist,
                      id: item.id,
                      img: item.img
                    }
                });
                response(stringArray);
            },
            error: function(err) {
                console.log(err);
            }
        });
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
        $header = $("<h3>" + item.artist + "</h3>");

    $img.attr({
       src: item.img,
       alt: item.artist
    });

    $li.append('<a href="#">');
    $li.find('a').append($img).append($header);
    $li.addClass("searchresults");

    return $li.appendTo(ul);
};

});
