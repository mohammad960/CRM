/*!
 * spur-template - An admin template based on Bootstrap 4
 * Version v1.1.0
 * Copyright 2016 - 2019 Alexander Rechsteiner
 * https://hackerthemes.com
 */

const mobileBreakpoint = window.matchMedia("(max-width: 991px )");

$(document).ready(function(){
    $(".dash-nav-dropdown-toggle").click(function(){
        $(this).closest(".dash-nav-dropdown")
            .toggleClass("show")
            .find(".dash-nav-dropdown")
            .removeClass("show");

        $(this).parent()
            .siblings()
            .removeClass("show");
    });

    $(".menu-toggle-nav").click(function(){
        if (mobileBreakpoint.matches) {
            $(".dash-nav").toggleClass("mobile-show");
            //$(".menu-toggle-nav").toggleClass("")
        } else {
            $(".dash").toggleClass("dash-compact");

        }
    });
    $(".menu-toggle-nav-compact").click(function(){
        if (mobileBreakpoint.matches) {
            $(".dash-nav").toggleClass("mobile-show");
            //$(".menu-toggle-nav").toggleClass("")
        } else {
            $(".dash").toggleClass("dash-compact");

        }
    });
    

    $(".searchbox-toggle").click(function(){
        $(".searchbox").toggleClass("show");
    });
/*
    $('input[type="date"]').change(function(){
        this.value = this.value.split("-").reverse().join("-"); 
     });*/
/*
    $("input[type='date']").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format("YYYY-MM-DD")
        )
    }).trigger("change")*/
    // Dev utilities
    // $("header.dash-toolbar .menu-toggle").click();
    // $(".searchbox-toggle").click();

    $("input").on('change keyup', function() {
        if($(this).val().length > 0){
            console.log($(this).next().text())
            $(this).next().addClass('input-has-value2');
        }
        else{
            $(this).next().removeClass('input-has-value2');
        }

    });
    $(":input:not(:hidden)").each(function(){
        if($(this).val().length > 0){
            console.log($(this).next().text())
            $(this).next().addClass('input-has-value2');
        }
        else{
            $(this).next().removeClass('input-has-value2');
        }
       });

});
