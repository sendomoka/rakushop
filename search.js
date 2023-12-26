$(document).ready(function(){
    $("#search").on("keyup", function(){
        var value = $(this).val().toLowerCase();
        if(value != ""){
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {value: value},
                success: function(data){
                    // $("#search-result").html(data);
                    if(data.trim() != ""){
                        $("#search-result").css("display", "flex").html(data);
                    } else {
                        $("#search-result").css("display", "flex").html("<small>Not Found</small>");
                    }
                }
            });
        } else {
            $("#search-result").css("display", "none").html("");
        }
    });
});