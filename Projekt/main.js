window.onload = function() {

    $("div.task img").click(function () {
        console.log("clicked del " + $(this).parent().attr("id"));

    });

    $("div.task").dblclick(function () {
       alert("topeltklikk");
    });


    $("div.button_delete").click(function () {

        var task_id = $(this).parent().parent().attr("id");
        var list_id = $(this).parent().parent().attr("list_id");

        $(this).parent().html("<div class='delete_task_confirm_button'><a href='?mode=delete_task&task_id=" + task_id + "&list_id=" + list_id + "'>[delete]</a></div><div class='cancel_delete_button'>[cancel]</div>");
    });


    //http://stackoverflow.com/questions/6658752/click-event-doesnt-work-on-dynamically-generated-elements
    $("div.delete_button_area").on("click", "div.cancel_delete_button", function(){
        console.log("cancel delete");
        $(this).parent().html("<div class=\"button_delete\">[delete]</div>");
    });

    $("div.delete_button_area").on("click", "div.button_delete", function(){
        var task_id = $(this).parent().parent().attr("id");
        var list_id = $(this).parent().parent().attr("list_id");

        $(this).parent().html("<div class='delete_task_confirm_button'><a href='?mode=delete_task&task_id=" + task_id + "&list_id=" + list_id + "'>[delete]</a></div><div class='cancel_delete_button'>[cancel]</div>");
    });


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

    $("div.completed_tasks").on("load", "div.completed_tasks_list", function(){

    });

    $("div.button_toggle_completed").click(function () {

        var list_id = getUrlParameter('list_id');
        console.log(list_id);

        window.open("?mode=toggle_completed&list_id=" + list_id,"_self")
    });


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
