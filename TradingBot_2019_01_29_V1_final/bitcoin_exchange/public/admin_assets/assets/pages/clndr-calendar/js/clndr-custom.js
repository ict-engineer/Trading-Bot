"use strict";
$(document).ready(function() {
    var a = moment().format("YYYY-MM"),
        b = moment().add("month", 1).format("YYYY-MM");
        
    $("#clndr-default").clndr({
        template: $("#clndr-template").html()      
    });
    
});
