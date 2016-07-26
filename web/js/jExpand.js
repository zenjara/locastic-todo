(function($){
    $.fn.jExpand = function(){

        //$("#report tr:odd").addClass("master");
        //$("#report tr:not(.master)").hide();
        $(".master").next().hide();
        $("#report tr:first-child").show();
        $("#report tr.master").click(function(){
            //$(this).next("tr").toggle();
            $(this).next("tr").toggle();
            $(this).find(".arrow").toggleClass("up");
        });

    }    
})(jQuery); 