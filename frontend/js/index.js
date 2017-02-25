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

$("#artistName").keyup(function() {

        var keyword = $("#artistName").val();
        if (keyword.length >= MIN_LENGTH) {

            // $.get( "autocomplete.php", { keyword: keyword, method: 'LOTNUM' } )
            // .done(function( data ) {

            var data = {
                "name": [
                    "Drake",
                    "Drake",
                    "Drake",
                    "Drake",
                    "Drake"
                ],
                "id": [
                    "1",
                    "2",
                    "3",
                    "4",
                    "5"
                ],
                "img": [
                    "O",
                    "O",
                    "O",
                    "O",
                    "O"
                ]
            }

            $.each(data, function(key, data) {

                if(key == "name") {
                  $.each(data, function(index, data) {
                      console.log('Artist - ', data);
                      $('.results_lot_number').append('<div class="item">' + data + '</div>');
                  })
                } else if(key == "img") {
                  $.each(data, function(index, data) {
                      console.log('Image - ', data);
                  })
                }

            });

            $('.item').click(function() {
                var text = $(this).html();
                $('#artistName').val(text);
                $('.results_lot_number').hide();
            });

            $('.results_lot_number').show();
          }
          else {
            $('.results_lot_number').html('');
          }
});



});
