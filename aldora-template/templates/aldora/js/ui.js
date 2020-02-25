function UI()
{this.initialize=function()
{if($("#slider").length>0)
{UI.slider();}
if(Config.voteReminder)
{UI.voteReminder();}
$('input[placeholder], textarea[placeholder]').placeholder();UI.dropdown.initialize();Tooltip.initialize();}
this.voteReminder=function()
{$("#popup_bg").fadeTo(200,0.5);$("#vote_reminder").fadeTo(200,1);$("#popup_bg").bind('click',function()
{UI.hidePopup();});}
this.slider=function()
{var config={autoplay:true,controls:true,captions:true,delay:Config.Slider.interval};if(Config.Slider.effect.length>0)
{config.transitions=new Array(Config.Slider.effect);}
window.myFlux=new flux.slider('#slider',config);}
this.alert=function(question,time)
{$("#alert_message").html(question);$("#popup_bg").fadeTo(200,0.5);$("#alert").fadeTo(200,1);if(typeof time=="undefined")
{$("#alert_message").css({marginBottom:"10px"});$(".popup_links").show();$("#alert_button").bind('click',function()
{UI.hidePopup();});}
else
{$("#alert_message").css({marginBottom:"0px"});$(".popup_links").hide();setTimeout(function()
{UI.hidePopup();},time);}
$("#popup_bg").bind('click',function()
{UI.hidePopup();});$(document).keypress(function(event)
{if(event.which==13)
{UI.hidePopup();}});}
this.confirm=function(question,button,callback,callback_cancel,width)
{var normalWidth=$("#confirm").css("width");var normalMargin=$("#confirm").css("margin-left");if(width)
{$("#confirm").css({width:width+"px"});$("#confirm").css({marginLeft:"-"+(width/2)+"px"});}
$(".popup_links").show();$("#confirm_question").html(question);$("#confirm_button").html(button);$("#popup_bg").fadeTo(200,0.5);$("#confirm").fadeTo(200,1);$("#confirm_button").bind('click',function()
{$("#confirm").css({width:normalWidth});$("#confirm").css({marginLeft:normalMargin});callback();UI.hidePopup();});$("#popup_bg").bind('click',function()
{$("#confirm").css({width:normalWidth});$("#confirm").css({marginLeft:normalMargin});UI.hidePopup();});$(document).keypress(function(event)
{if(event.which==13)
{$("#confirm").css({width:normalWidth});$("#confirm").css({marginLeft:normalMargin});callback();UI.hidePopup();}});}
this.hidePopup=function()
{$("#popup_bg").hide();$("#confirm").hide();$("#alert").hide();$("#vote_reminder").hide();$("#confirm_button").unbind('click');$("#alert_button").unbind('click');$(document).unbind('keypress');}
this.limitCharacters=function(field,indicator)
{var max=field.maxLength;var length=field.value.length;document.getElementById(indicator).innerHTML=length+" / "+max;}
this.dropdown={initialize:function()
{$(document).ready(function(){UI.dropdown.create('.dropdown');});},create:function(element)
{$(element).not('[data-dropdown-initialized]').attr('data-dropdown-initialized','true').children('h3').bind('click',function()
{$(this).next('div').slideToggle(200,function(){if($(this).is(':visible'))
$(this).parent('.dropdown').addClass('active');else
$(this).parent('.dropdown').removeClass('active');});});}}}
function Tooltip()
{this.initialize=function()
{$("body").prepend('<div id="tooltip"></div>');this.addEvents();}
this.refresh=function()
{$("[data-tip]").unbind('hover');this.addEvents();}
this.addEvents=function()
{Tooltip.addEvents.handleMouseMove=function(e)
{Tooltip.move(e.pageX,e.pageY);}
$("[data-tip]").hover(function()
{$(document).bind('mousemove',Tooltip.addEvents.handleMouseMove);Tooltip.show($(this).attr("data-tip"));},function()
{$("#tooltip").hide();$(document).unbind('mousemove',Tooltip.addEvents.handleMouseMove);});if(Config.UseFusionTooltip)
{$("[rel]").hover(function()
{$(document).bind('mousemove',Tooltip.addEvents.handleMouseMove);if(/^item=[0-9]*$/.test($(this).attr("rel")))
{Tooltip.Item.get(this,function(data)
{Tooltip.show(data);});}},function()
{$(document).unbind('mousemove',Tooltip.addEvents.handleMouseMove);$("#tooltip").hide();});}}
this.move=function(x,y)
{var width=($("#tooltip").css("width").replace("px","")/2);$("#tooltip").css("left",x-width).css("top",y+25);}
this.show=function(data)
{$("#tooltip").html(data).show();}
this.Item=new function()
{this.loading="Loading...";this.cache=new Array();this.currentId=false;this.get=function(element,callback)
{var obj=$(element);var realm=obj.attr("data-realm");var id=obj.attr("rel").replace("item=","");Tooltip.Item.currentId=id;if(id in this.cache)
{callback(this.cache[id])}
else
{var cache=Tooltip.Item.CacheObj.get("item_"+realm+"_"+id+"_"+Config.language);if(cache!==false)
{callback(cache);}
else
{callback(this.loading);$.get(Config.URL+"tooltip/"+realm+"/"+id,function(data)
{Tooltip.Item.cache[id]=data;Tooltip.Item.CacheObj.save("item_"+realm+"_"+id+"_"+Config.language,data);if($("#tooltip").is(":visible")&&Tooltip.Item.currentId==id)
{callback(data);}});}}}
this.CacheObj=new function()
{this.get=function(name)
{if(typeof localStorage!="undefined")
{var cache=localStorage.getItem(name);if(cache)
{cache=JSON.parse(cache);if(cache.expiration>Math.round((new Date()).getTime()/1000))
{return cache.data;}
else
{return false;}}
else
{return false;}}
else
{return false;}}
this.save=function(name,data)
{if(typeof localStorage!="undefined")
{var time=Math.round((new Date()).getTime()/1000);var expiration=time+60*60*24;localStorage.setItem(name,JSON.stringify({"data":data,"expiration":expiration}));}}}}}
var UI=new UI();var Tooltip=new Tooltip();