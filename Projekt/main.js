window.onload = function() {

    $("div.task img").click(function () {
        console.log("clicked del " + $(this).parent().attr("id"));

    });

    $("div.task").dblclick(function () {
       alert("topeltklikk");
    });



    $(".search_box").keyup(function () {

        // ToDo: set upper limit to search key length;


        //https://developer.mozilla.org/en-US/docs/Web/API/History_API
        var stateObj = { foo: "bar" };
        history.pushState(stateObj, "", "?mode=search&key=" + $(".search_box").val());

        //http://www.w3schools.com/jquery/jquery_ajax_get_post.asp
        $.get("?mode=search_json&q=" + $(".search_box").val(), function(data, status){
            //console.log("Data: " + data + "\nStatus: " + status);



            $.each($.parseJSON(data), function(idx, obj) {

                $(".content").append("<li>" + obj.name);
            });


        });

    });

}