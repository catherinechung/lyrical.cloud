$(document).ready(function() {

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

    var artistName = $('input').val();
    // AJAX GET REQUEST
    // $.ajax({
    //     type: "GET",
    //     url: 'test.php',
    //     data: {artist: songArtist},
    //     success: function(data){
    //         alert(data);
    //     }
    // });

});

var availableTutorials  =  [
   "ActionScript",
   "Boostrap",
   "C",
   "C++",
];

var sampleData = {
	   "name":[
	      "Drake",
	      "Drake",
	      "Drake White",
	      "Nick Drake",
	      "Drake Bell"
	   ],
	   "artistid":[
	      "3TVXtAsR1Inumwj472S9r4",
	      "4W9G3Vnt9eXWTo4VeOQkSa",
	      "29ijED2bnnprp2TciAK1aO",
	      "5c3GLXai8YOMid29ZEuR9y",
	      "03ilIKH0i08IxmjKcn63ne"
	   ],
	   "image":[
	      "https:\/\/i.scdn.co\/image\/cb080366dc8af1fe4dc90c4b9959794794884c66",
	      "https:\/\/i.scdn.co\/image\/f4a465c6022a30ee187452f7923e509d480c4c1a",
	      "https:\/\/i.scdn.co\/image\/8b7d34461462466d5a5b32d9d7a3a94729767c13",
	      "https:\/\/i.scdn.co\/image\/267080662cf3c019ea8020a4e0e8dd5a7be4d909",
	      ""
	   ]
	}

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
            dataType: "json",
            type : 'GET',
            url: 'localhost:8080/api/dropdown/suggestions/' + $artistName,
            success: function(data) {
              
                alert("PHP Function worked");

                response(availableTutorials);
                // response( $.map( data, function(item) {
                //     // your operation on data
                // }));
            },
            error: function(data) {
                alert("PHP Function call failed");
            }
        })
      },
   minLength: 3
});

// $("#automplete-1").keyup(function() {

//         var input = $("#automplete-1").val();

//         if(input.length >= MIN_LENGTH) {

//           $.ajax({
//                   url: 'yourPHPFunction',
//                   success: function(response) {
//                         $('input[name="fieldName"]').val(response);
//                   },
//                   error: function(jqXHR, status, message) {
//                         alert(message);
//                   }
//             });

//           var namesArray = getArray(sampleData, "name");
//           var imageArray = getArray(sampleData, "image");

//           for(var i = 0; i < namesArray.length; i++) {
//             console.log(namesArray[i]);
//             console.log(imageArray[i]);
//           }

//         }

// });



});
