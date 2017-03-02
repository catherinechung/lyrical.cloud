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

$("#searchButton").prop("disabled", true);

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

$("#addButton").click(function() {
  $("#vis").show();

  var $currentArtists = document.getElementById("artist").innerText;
  var $artistName = $("#automplete-1").val();
  $artistName = $artistName[0].toUpperCase() + $artistName.slice(1);
  document.getElementById("artist").innerHTML = $currentArtists + ", " + $artistName;

  $.ajax({
    type : 'GET',
    url: 'http://localhost:8080/api/wordcloud/merge/' + $artistName,
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


$("#shareButton").click(function() {

  $(this).prop("disabled", true);

  console.log("HELLO BABU!"); 

});

$("automplete-1").keyup(function() {

  $("#searchButton").prop("disabled", true);
  $("#searchButton").removeClass("btn-class");
  $("#searchButton").addClass("btn-class-disabled");

  console.log("HELLO BABU");

});

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
      $("#searchButton").prop("disabled", false);
      $("#searchButton").removeClass("btn-class-disabled");
      $("#searchButton").removeClass("btn-class");
    },
    minLength: 3
}).data("ui-autocomplete")._renderItem=function(ul, item) {

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
