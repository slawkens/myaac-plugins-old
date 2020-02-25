var Router={loadedJS:[],loadedCSS:[],first:true,page:false,initialize:function()
    {if(history.pushState)
    {$("a[href*='"+Config.URL+"']").each(function()
    {if(!$(this).attr('data-hasEvent')&&$(this).attr("target")!="_blank")
    {$(this).attr('data-hasEvent','1');$(this).click(function(event)
    {$("html").css("cursor","wait");var href=$(this).attr("href");var direct=$(this).attr("direct");Router.load(href,direct);history.pushState('','New URL: '+href,href);event.preventDefault();});}});}},load:function(link,direct)
    {if(Router.first)
    {Router.first=false;$(window).bind('popstate',function()
    {Router.load(location.pathname,0);});}
    Router.page=link;$("#tooltip").hide();if(/logout/.test(link))
    {window.location=link;}
    else if(/admin/.test(link))
    {window.location=link;}
    else if(direct=="1")
    {window.location=link;}
    else
    {$.get(link,{is_json_ajax:"1"},function(data,textStatus,response)
    {if(/^\<!DOCTYPE html\>/.test(data))
    {window.location.reload(true);return;}
    if(Router.page==link)
    {window.scrollTo(0,0);try
    {data=JSON.parse(data);}
    catch(error)
    {data={title:"Error",content:"Something went wrong!<br /><br /><b>Technical data:</b> "+data,js:null,css:null,slider:false,language:false};}
    $("html").css("cursor","default");$("#content_ajax").html(data.content);Tooltip.refresh();$("title").html(data.title);Router.initialize();if(data.language)
    {Language.set(data.language);}
    if($.inArray(data.css,Router.loadedCSS)==-1&&data.css.length>0)
    {Router.loadedCSS.push(data.css);$("head").append('<link rel="stylesheet" type="text/css" href="'+Config.URL+'application/'+data.css+'" />');}
    if($.inArray(data.js,Router.loadedJS)==-1&&data.js.length>0)
    {Router.loadedJS.push(data.js);require([Config.URL+"application/"+data.js]);}
    if(data.slider)
    {$("#"+Config.Slider.id).show();}
    else
    {$("#"+Config.Slider.id).hide();}}}).fail(function()
    {if(Router.page==link)
    {$("body").css("cursor","default");$("title").html("FusionCMS");UI.alert("Something went wrong! Attempting to load the page directly... <center style='margin-top:20px;'><img src='"+Config.URL+"application/images/modal-ajax.gif' /></center>",3000);setTimeout(function()
    {window.location=link;},3000);}});}}}
    $(document).ready(Router.initialize);