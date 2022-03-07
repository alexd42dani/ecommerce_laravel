$(document).ready(function(){
    
$("#addtocart").on("click", function (event) {
    event.preventDefault();
    var card = $(this).attr("path");
    var rid = $(this).attr("room");
    var check_in = document.getElementById("check_in").value;
    var check_out = document.getElementById("check_out").value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: card,
        method: "POST",
        data: {
            id: rid,
            c_in: check_in,
            c_out: check_out
        }
        ,
        success: function (data) {
            $('#message').html(data);
            getCart();
        }
    })
})

getCart();

function getCart() {
    var cart_get = document.getElementById("cart_get").value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: cart_get,
        success: function (data) {
            $("#cart_details").html(data.details);
            $("#nro_cart").html(data.count);
            $("#summary-table").html(data.summary);
            //alert(data);
        }
    });
}

/*$("#cart_remove").on("click", function (event) {  
})*/

/*$(document).on('click', "#cart_remove", function (){
});*/

$("body").delegate("#cart_remove","click",function(event){
    event.preventDefault();
    var room = $(this).attr("room");
    var path = $(this).attr("path");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: path,
        method: "POST",
        data: {
            id: room
        }
        ,
        success: function (data) {
            getCart();
        }
    })
})

});