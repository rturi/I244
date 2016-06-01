window.onload = function() {



    $("div.button_delete").click(function () {

        var task_id = $(this).parent().parent().attr("id");
        var list_id = $(this).parent().parent().attr("list_id");

        $(this).parent().html("<div class='delete_task_confirm_button'><a href='?mode=delete_task&task_id=" + task_id + "&list_id=" + list_id + "'>[delete]</a></div><div class='cancel_delete_button'>[cancel]</div>");
    });

    $("div.edit_task_button").click(function () {

        var task_id = $(this).closest(".task").attr("id");
        var list_id = $(this).closest(".task").attr("list_id");

        $(this).closest(".task").next().toggle();
    });


    $("div.task").dblclick(function () {

        $(this).next().toggle();
    });


    $("div.delete_task_button_area").on("click", "div.delete_task_button", function(){
        $(this).parent().html("<div class=\"delete_task_confirm_button pos_button\">Delete</div><div class=\"delete_task_cancel_button neg_button\">Cancel</div>");
    });


    $("div.delete_task_button_area").on("click", "div.delete_task_cancel_button", function(){
        $(this).parent().html("<div class=\"delete_task_button neg_button\">Delete</div>");
    });


    $("div.delete_task_button_area").on("click", "div.delete_task_confirm_button", function(){

        var task_id = $(this).closest(".edit_task_area").prev().attr("id");
        var mode = getUrlParameter('mode');

        if (mode == "lists") {

            var list_id = getUrlParameter('list_id');
            console.log("?mode=delete_task&source=list&task_id=" + task_id + "&list_id=" + list_id);

            window.open("?mode=delete_task&source=list&task_id=" + task_id + "&list_id=" + list_id, "_self")
        }

        if (mode == "search_task") {

            var search_keyword = $(this).closest(".content").find(".search_key").text();

            window.open("?mode=delete_task&task_id=" + task_id + "&source=search&q=" + search_keyword, "_self")
        }

    });




    $("div.button_toggle_completed").click(function () {


        var mode = getUrlParameter('mode');

        if (mode == "lists") {

            var list_id = getUrlParameter('list_id');

            window.open("?mode=toggle_completed&source=list&list_id=" + list_id,"_self");
        }

        if (mode == "search_task") {

            var search_keyword = $(this).closest(".content").find(".search_key").text();

            window.open("?mode=toggle_completed&source=search&q=" + search_keyword,"_self")

        }



    });



    $("div.done_button").click(function () {

        var task_id = $(this).parent().attr("id");
        var mode = getUrlParameter('mode');

        if (mode == "lists") {

            var list_id = getUrlParameter('list_id');

            window.open("?mode=set_task_completed&source=list&list_id=" + list_id + "&task_id=" + task_id, "_self");
        }

        if (mode == "search_task") {

            var search_keyword = $(this).closest(".content").find(".search_key").text();

            window.open("?mode=set_task_completed&source=search&q=" + search_keyword + "&task_id=" + task_id, "_self");
        }

    });

    $("div.undone_button").click(function () {

        var task_id = $(this).parent().attr("id");
        var mode = getUrlParameter('mode');

        if (mode == "lists") {

            var list_id = getUrlParameter('list_id');

            window.open("?mode=set_task_active&source=list&list_id=" + list_id + "&task_id=" + task_id, "_self");
        }

        if (mode == "search_task") {

            var search_keyword = $(this).closest(".content").find(".search_key").text();

            window.open("?mode=set_task_active&source=search&q=" + search_keyword + "&task_id=" + task_id, "_self");
        }
    });

    // sets task name max width to get 'text-overflow: ellipsis;' to work right
    $(".task_name_area").css("width", window.innerWidth - 355);


    $(".search_box").keyup(function () {

        // ToDo: set upper limit to search key length;


        //https://developer.mozilla.org/en-US/docs/Web/API/History_API
        var stateObj = { foo: "bar" };
        history.pushState(stateObj, "", "?mode=search&key=" + $(".search_box").val());

        //http://www.w3schools.com/jquery/jquery_ajax_get_post.asp
        $.get("?mode=search&q=" + $(".search_box").val(), function(data, status){

            $.each($.parseJSON(data), function(idx, obj) {

                $(".content").append("<li>" + obj.name);
            });

        });

    });



}


// sets task name max width to get 'text-overflow: ellipsis;' to work right
// idea from: http://stackoverflow.com/questions/9828831/jquery-on-window-resize
window.onresize = function() {
    if (window.innerWidth > 500) {
        $(".task_name_area").css("width", window.innerWidth - 355);
        console.log("resize");
    }
}

// from: http://stackoverflow.com/questions/19491336/get-url-parameter-jquery-or-how-to-get-query-string-values-in-js
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};



//function loadCompletedTasks () {
//    $("div.completed_tasks_list").html("test2e");
//
//    $.get("?mode=tasks&list_id=4", function(data, status){
//
//        alert("Data: " + data + "\nStatus: " + status);
//
//        $.each($.parseJSON(data), function(idx, obj) {
//
//            $(".content").append("<li>" + obj.name);
//        });
//
//    });
//
//}