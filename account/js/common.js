var website = {
    //log:function(){
    //    $("#log .list").each(function(){
    //        $(this).find(".input").each(function(){
    //            if($(this).find("input").val() != ""){
    //                $(this).find(".info").hide()
    //            }
    //            $(this).click(function(){
    //                $(this).find(".info").hide()
    //                $(this).find("input").focus()
    //            })
    //        })
    //    })
    //},
    popclose:function(o){
        $(o).hide()
        $("#pop-bg").hide()
    },
    popopen:function(o){
        if($("#pop-bg").length < 1){
            $("body").append("<div id='pop-bg'></div>")
        }
        $(o).show()
        $("#pop-bg").show()
    },

	init:function() {
		$(".alertDialogClose").click(function() {
			website.popclose("#mzdialog1")
		});
		
		$(".alertDialogSure").click(function() {
			website.popclose("#mzdialog1")
		});
	},

    //tab:function(tab,tabcon,num){
    //    var _$tab = $(tab),
    //        _$tabcon = $(tabcon)
    //    var _shows = function(i){
    //        _$tab.removeClass("current")
    //        _$tab.eq(i).addClass("current")
    //        _$tabcon.removeClass("current")
    //        _$tabcon.eq(i).addClass("current")
    //    }
    //    if(num != undefined){
    //        _shows(num)
    //    }
    //    _$tab.each(function(i){
    //        $(this).click(function(){
    //            _shows(i)
    //        })
    //    })
    //},
    //showinfo:function(){
    //    var _$infomore = $("#info-more"),
    //        _$infoboxmore = $(".info-box-more"),
    //        _$tab = $("#nav a"),
    //        _$tabcon = $("#info .info-box")
    //    _$infomore.click(function(){
    //        _$tab.removeClass("current")
    //        _$tabcon.removeClass("current")
    //        _$infoboxmore.addClass("current")

    //    })
    //}
};
$(function () {
	website.init()
})

