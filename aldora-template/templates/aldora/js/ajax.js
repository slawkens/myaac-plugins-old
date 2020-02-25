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
var UI=new UI();var Tooltip=new Tooltip();;var FusionEditor={Tools:{bold:function(id)
{FusionEditor.wrapSelection(id,document.createElement('b'));FusionEditor.addEvents(id);},italic:function(id)
{FusionEditor.wrapSelection(id,document.createElement('i'));FusionEditor.addEvents(id);},underline:function(id)
{FusionEditor.wrapSelection(id,document.createElement('u'));FusionEditor.addEvents(id);},left:function(id)
{var element=document.createElement('div');element.style.textAlign="left";FusionEditor.wrapSelection(id,element);},center:function(id)
{var element=document.createElement('div');element.style.textAlign="center";FusionEditor.wrapSelection(id,element);},right:function(id)
{var element=document.createElement('div');element.style.textAlign="right";FusionEditor.wrapSelection(id,element);},image:function(id)
{var editor='<form onSubmit="FusionEditor.Tools.addImage(\''+id+'\'); return false">'
+'<input type="text" placeholder="http://path.to/my/image.jpg" id="editor_image_'+id+'" />'
+'<input type="submit" value="Add" />'
+'</form>';FusionEditor.open(id,editor);},addImage:function(id)
{var field=$("#editor_image_"+id);if(field.val().length>0&&/^https?:\/\/.*$/.test(field.val()))
{var element=document.createElement('img');element.src=field.val();FusionEditor.wrapSelection(id,element);FusionEditor.close(id);field.val("");FusionEditor.addEvents(id);}
else
{UI.alert("Image must be a valid link");}},color:function(id)
{var colors="",colorArr=["cc0000","cc006e","c500cc","4d00cc","000acc","0043cc","008bcc","00ccc5","00cc48","13cc00","73cc00","c0cc00","cc9e00","cc7300","333333","666666"];for(i in colorArr)
{colors+='<a class="fusioneditor_color" href="javascript:void(0)" onClick="FusionEditor.Tools.addColor(\''+id+'\', \'#'+colorArr[i]+'\')" data-tip="#'+colorArr[i]+'" style="background-color:#'+colorArr[i]+'"></a>';}
FusionEditor.open(id,colors,32);Tooltip.refresh();},addColor:function(id,color)
{var span=document.createElement("span");span.style.color=color;FusionEditor.wrapSelection(id,span);FusionEditor.close(id);},size:function(id)
{var sizes="",sizeArr=["8","10","12","14","16","18","20","22","24","32","42","52","62","72",];for(i in sizeArr)
{sizes+='<a class="fusioneditor_size" href="javascript:void(0)" onClick="FusionEditor.Tools.addSize(\''+id+'\', \''+sizeArr[i]+'\')">'+sizeArr[i]+'</a>';}
FusionEditor.open(id,sizes,32);},addSize:function(id,size)
{var span=document.createElement("span");span.style.fontSize=size+"px";FusionEditor.wrapSelection(id,span);FusionEditor.close(id);},link:function(id)
{var editor='<form onSubmit="FusionEditor.Tools.addLink(\''+id+'\'); return false">'
+'<input type="text" placeholder="http://domain.com" id="editor_link_'+id+'" />'
+'<input type="submit" value="Add" />'
+'</form>';FusionEditor.open(id,editor);},addLink:function(id)
{var field=$("#editor_link_"+id);if(field.val().length>0&&/^http:\/\/.*$/.test(field.val()))
{var element=document.createElement('a');element.href=field.val();element.target="_blank";FusionEditor.wrapSelection(id,element,field.val());FusionEditor.close(id);field.val("");FusionEditor.addEvents(id);}
else
{UI.alert("Link must be valid");}},html:function(id)
{var field='<textarea id="html_field_'+id+'" style="width:95%;height:300px;font-family:Courier" spellcheck="false">'+$("#"+id).html()+'</textarea>';var originalWidth=$("#confirm").css("width"),originalMargin=$("#confirm").css("margin-left");$("#confirm").css({width:"600px",marginLeft:"-300px"});UI.confirm(field,"Save",function()
{$("#"+id).html($("#html_field_"+id).val());FusionEditor.addEvents(id);$("#confirm").css({width:originalWidth,marginLeft:originalMargin});});},tidy:function(id)
{var regex=/\<(\/)?(b|span|i|u|div)\b([A-Za-z0-9 :;,#-="']*)?\>/g,field=$("#"+id),html=field.html();field.html(html.replace(regex,""));}},create:function(id)
{$("#"+id).attr("contenteditable","true");FusionEditor.addEvents(id);$("#fusioneditor_"+id+"_toolbox").bind('click',function(e)
{e.stopPropagation();});},open:function(id,content,size)
{if(size)
{$("#fusioneditor_"+id+"_toolbox").css({height:size});}
else
{if(Config.isACP)
{$("#fusioneditor_"+id+"_toolbox").css({height:"40"});}
else
{$("#fusioneditor_"+id+"_toolbox").css({height:"50"});}}
if($("#fusioneditor_"+id+"_toolbox").is(":visible"))
{$("#fusioneditor_"+id+"_toolbox").transition({rotateX:'90deg',opacity:0},200,function()
{$(this).html(content).transition({rotateX:'0deg',opacity:1},200);});}
else
{$("#fusioneditor_"+id+"_toolbox").transition({rotateX:'90deg',opacity:0},0);$("#fusioneditor_"+id+"_toolbox").html(content).slideDown(100,function()
{$(this).transition({rotateX:'0deg',opacity:1},200);});$("#fusioneditor_"+id+"_close").fadeToggle(200);}},close:function(id)
{$("#fusioneditor_"+id+"_toolbox").transition({rotateX:'90deg',opacity:0},200,function()
{$(this).slideUp(50);$("#fusioneditor_"+id+"_toolbox").transition({rotateX:'0deg'});});$("#fusioneditor_"+id+"_close").fadeOut(200);},addEvents:function(id,element)
{var object;if(element)
{object=$(element);}
else
{object=$("#"+id);}
object.children().each(function()
{FusionEditor.addEvent(id,this);if($(this).children().length>0)
{FusionEditor.addEvents(id,this);}});},addEvent:function(id,element)
{if(typeof $(element).data('events')=="undefined")
{switch(element.nodeName.toLowerCase())
{case"img":$(element).bind('click',function(e)
{FusionEditor.imageMenu(e,element,id);});break;case"a":$(element).bind('click',function(e)
{FusionEditor.linkMenu(e,element,id);});break;}}},currentImage:false,saveImage:function(id)
{FusionEditor.currentImage.src=$("#editor_edit_image_"+id).val();FusionEditor.close(id);},imageMenu:function(e,element,id)
{FusionEditor.currentImage=element;var editor='<form onSubmit="FusionEditor.saveImage(\''+id+'\'); return false">'
+'<input type="text" value="'+element.src+'" id="editor_edit_image_'+id+'" />'
+'<input type="submit" value="Save" />'
+'</form>';FusionEditor.open(id,editor);e.stopPropagation();$(document).unbind('click');$(document).bind('click',function()
{$(document).unbind('click');FusionEditor.close(id);});},currentLink:false,saveLink:function(id)
{FusionEditor.currentLink.href=$("#editor_edit_link_"+id).val();FusionEditor.close(id);},linkMenu:function(e,element,id)
{FusionEditor.currentLink=element;var editor='<form onSubmit="FusionEditor.saveLink(\''+id+'\'); return false">'
+'<input type="text" value="'+element.href+'" id="editor_edit_link_'+id+'" />'
+'<input type="submit" value="Save" />'
+'</form>';FusionEditor.open(id,editor);e.stopPropagation();$(document).unbind('click');$(document).bind('click',function()
{$(document).unbind('click');FusionEditor.close(id);});},wrapSelection:function(id,element,extra)
{var selection=window.getSelection();var string=selection.toString();if(string.length>0&&FusionEditor.hasParent(selection.anchorNode.parentElement,document.getElementById(id)))
{var selectedText=selection.getRangeAt(0).extractContents();element.appendChild(selectedText);selection.getRangeAt(0).insertNode(element);}
else
{if(extra)
{element.innerHTML=extra;}
$("#"+id).append(element);}},hasParent:function(element,goal)
{if(element==goal)
{return true;}
else
{var test=element.parentNode;while(test!=goal)
{try
{test=test.parentNode;}
catch(error)
{return false;}}
return true;}}}
;/*
 Flux Slider v1.4.4
 http://www.joelambert.co.uk/flux

 Copyright 2011, Joe Lambert.
 Free to use under the MIT license.
 http://www.opensource.org/licenses/mit-license.php
*/
window.flux={version:"1.4.4"};(function(a){flux.slider=function(b,c){flux.browser.init();if(!flux.browser.supportsTransitions){if(window.console&&window.console.error)console.error("Flux Slider requires a browser that supports CSS3 transitions")}var d=this;this.element=a(b);this.transitions=[];for(var e in flux.transitions)this.transitions.push(e);this.options=a.extend({autoplay:true,transitions:this.transitions,delay:4e3,pagination:true,controls:false,captions:false,width:null,height:null,onTransitionEnd:null},c);this.height=this.options.height?this.options.height:null;this.width=this.options.width?this.options.width:null;var f=[];a(this.options.transitions).each(function(a,b){var c=new flux.transitions[b](this),d=true;if(c.options.requires3d&&!flux.browser.supports3d)d=false;if(c.options.compatibilityCheck)d=c.options.compatibilityCheck();if(d)f.push(b)});this.options.transitions=f;this.images=new Array;this.imageLoadedCount=0;this.currentImageIndex=0;this.nextImageIndex=1;this.playing=false;this.container=a('<div class="fluxslider"></div>').appendTo(this.element);this.surface=a('<div class="surface" style="position: relative"></div>').appendTo(this.container);this.container.bind("click",function(b){if(a(b.target).hasClass("hasLink"))window.location=a(b.target).data("href")});this.imageContainer=a('<div class="images loading"></div>').css({position:"relative",overflow:"hidden","min-height":"100px"}).appendTo(this.surface);if(this.width&&this.height){this.imageContainer.css({width:this.width+"px",height:this.height+"px"})}this.image1=a('<div class="image1" style="height: 100%; width: 100%"></div>').appendTo(this.imageContainer);this.image2=a('<div class="image2" style="height: 100%; width: 100%"></div>').appendTo(this.imageContainer);a(this.image1).add(this.image2).css({position:"absolute",top:"0px",left:"0px"});this.element.find("img, a img").each(function(b,c){var e=c.cloneNode(false),f=a(c).parent();if(f.is("a"))a(e).data("href",f.attr("href"));d.images.push(e);a(c).remove()});for(var g=0;g<this.images.length;g++){var h=new Image;h.onload=function(){d.imageLoadedCount++;d.width=d.width?d.width:this.width;d.height=d.height?d.height:this.height;if(d.imageLoadedCount>=d.images.length){d.finishedLoading();d.setupImages()}};h.src=this.images[g].src}this.element.bind("fluxTransitionEnd",function(a,b){if(d.options.onTransitionEnd){a.preventDefault();d.options.onTransitionEnd(b)}});if(this.options.autoplay)this.start();this.element.bind("swipeLeft",function(a){d.next(null,{direction:"left"})}).bind("swipeRight",function(a){d.prev(null,{direction:"right"})});setTimeout(function(){a(window).focus(function(){if(d.isPlaying())d.next()})},100)};flux.slider.prototype={constructor:flux.slider,playing:false,start:function(){var a=this;this.playing=true;this.interval=setInterval(function(){a.transition()},this.options.delay)},stop:function(){this.playing=false;clearInterval(this.interval);this.interval=null},isPlaying:function(){return this.playing},next:function(a,b){b=b||{};b.direction="left";this.showImage(this.currentImageIndex+1,a,b)},prev:function(a,b){b=b||{};b.direction="right";this.showImage(this.currentImageIndex-1,a,b)},showImage:function(a,b,c){this.setNextIndex(a);this.setupImages();this.transition(b,c)},finishedLoading:function(){var b=this;this.container.css({width:this.width+"px",height:this.height+"px"});this.imageContainer.removeClass("loading");if(this.options.pagination){this.pagination=a('<ul class="pagination"></ul>').css({margin:"0px",padding:"0px","text-align":"center"});this.pagination.bind("click",function(c){c.preventDefault();b.showImage(a(c.target).data("index"))});a(this.images).each(function(c,d){var e=a('<li data-index="'+c+'">'+(c+1)+"</li>").css({display:"inline-block","margin-left":"0.5em",cursor:"pointer"}).appendTo(b.pagination);if(c==0)e.css("margin-left",0).addClass("current")});this.container.append(this.pagination)}a(this.imageContainer).css({width:this.width+"px",height:this.height+"px"});a(this.image1).css({width:this.width+"px",height:this.height+"px"});a(this.image2).css({width:this.width+"px",height:this.height+"px"});this.container.css({width:this.width+"px",height:this.height+(this.options.pagination?this.pagination.height():0)+"px"});if(this.options.controls){this.nextButton=a('<a href="#" id="slider_next">'+Config.Theme.next+"</a>").appendTo(this.surface).bind("click",function(a){a.preventDefault();b.next()});this.prevButton=a('<a href="#" id="slider_previous">'+Config.Theme.previous+"</a>").appendTo(this.surface).bind("click",function(a){a.preventDefault();b.prev()});var c=(this.height-this.nextButton.height())/2;this.nextButton.css({top:c+"px",right:"10px"});this.prevButton.css({top:c+"px",left:"10px"})}if(this.options.captions){this.captionBar=a('<div class="caption"></div>').css({opacity:0,position:"absolute","z-index":110,width:"100%"}).css3({"transition-property":"opacity","transition-duration":"800ms","box-sizing":"border-box"}).prependTo(this.surface)}this.updateCaption()},setupImages:function(){var b=this.getImage(this.currentImageIndex),c={"background-image":'url("'+b.src+'")',"z-index":101,cursor:"auto"};if(a(b).data("href")){c.cursor="pointer";this.image1.addClass("hasLink");this.image1.data("href",a(b).data("href"))}else{this.image1.removeClass("hasLink");this.image1.data("href",null)}this.image1.css(c).children().remove();this.image2.css({"background-image":'url("'+this.getImage(this.nextImageIndex).src+'")',"z-index":100}).show();if(this.options.pagination&&this.pagination){this.pagination.find("li.current").removeClass("current");a(this.pagination.find("li")[this.currentImageIndex]).addClass("current")}},transition:function(b,c){if(b==undefined||!flux.transitions[b]){var d=Math.floor(Math.random()*this.options.transitions.length);b=this.options.transitions[d]}var e=null;try{e=new flux.transitions[b](this,a.extend(this.options[b]?this.options[b]:{},c))}catch(f){e=new flux.transition(this,{fallback:true})}e.run();this.currentImageIndex=this.nextImageIndex;this.setNextIndex(this.currentImageIndex+1);this.updateCaption()},updateCaption:function(){var b=a(this.getImage(this.currentImageIndex)).attr("title");if(this.options.captions&&this.captionBar){if(b!=="")this.captionBar.html(b);this.captionBar.css("opacity",b===""?0:1)}},getImage:function(a){a=a%this.images.length;return this.images[a]},setNextIndex:function(a){if(a==undefined)a=this.currentImageIndex+1;this.nextImageIndex=a;if(this.nextImageIndex>this.images.length-1)this.nextImageIndex=0;if(this.nextImageIndex<0)this.nextImageIndex=this.images.length-1},increment:function(){this.currentImageIndex++;if(this.currentImageIndex>this.images.length-1)this.currentImageIndex=0}}})(window.jQuery||window.Zepto);(function(a){flux.browser={init:function(){if(flux.browser.supportsTransitions!==undefined)return;var b=document.createElement("div"),c=["-webkit","-moz","-o","-ms"],d=["Webkit","Moz","O","Ms"];if(window.Modernizr&&Modernizr.csstransitions!==undefined)flux.browser.supportsTransitions=Modernizr.csstransitions;else{flux.browser.supportsTransitions=this.supportsCSSProperty("Transition")}if(window.Modernizr&&Modernizr.csstransforms3d!==undefined)flux.browser.supports3d=Modernizr.csstransforms3d;else{flux.browser.supports3d=this.supportsCSSProperty("Perspective");if(flux.browser.supports3d&&"webkitPerspective"in a("body").get(0).style){var e=a('<div id="csstransform3d"></div>');var f=a('<style media="(transform-3d), ('+c.join("-transform-3d),(")+'-transform-3d)">div#csstransform3d { position: absolute; left: 9px }</style>');a("body").append(e);a("head").append(f);flux.browser.supports3d=e.get(0).offsetLeft==9;e.remove();f.remove()}}},supportsCSSProperty:function(a){var b=document.createElement("div"),c=["-webkit","-moz","-o","-ms"],d=["Webkit","Moz","O","Ms"];var e=false;for(var f=0;f<d.length;f++){if(d[f]+a in b.style)e=e||true}return e},translate:function(a,b,c){a=a!=undefined?a:0;b=b!=undefined?b:0;c=c!=undefined?c:0;return"translate"+(flux.browser.supports3d?"3d(":"(")+a+"px,"+b+(flux.browser.supports3d?"px,"+c+"px)":"px)")},rotateX:function(a){return flux.browser.rotate("x",a)},rotateY:function(a){return flux.browser.rotate("y",a)},rotateZ:function(a){return flux.browser.rotate("z",a)},rotate:function(a,b){if(!a in{x:"",y:"",z:""})a="z";b=b!=undefined?b:0;if(flux.browser.supports3d)return"rotate3d("+(a=="x"?"1":"0")+", "+(a=="y"?"1":"0")+", "+(a=="z"?"1":"0")+", "+b+"deg)";else{if(a=="z")return"rotate("+b+"deg)";else return""}}};a(function(){flux.browser.init()})})(window.jQuery||window.Zepto);(function(a){a.fn.css3=function(a){var b={};var c=["webkit","moz","ms","o"];for(var d in a){for(var e=0;e<c.length;e++)b["-"+c[e]+"-"+d]=a[d];b[d]=a[d]}this.css(b);return this};a.fn.transitionEnd=function(b){var c=this;var d=["webkitTransitionEnd","transitionend","oTransitionEnd"];for(var e=0;e<d.length;e++){this.bind(d[e],function(c){for(var e=0;e<d.length;e++)a(this).unbind(d[e]);if(b)b.call(this,c)})}return this};flux.transition=function(b,c){this.options=a.extend({requires3d:false,after:function(){}},c);this.slider=b;if(this.options.requires3d&&!flux.browser.supports3d||!flux.browser.supportsTransitions||this.options.fallback===true){var d=this;this.options.after=undefined;this.options.setup=function(){d.fallbackSetup()};this.options.execute=function(){d.fallbackExecute()}}};flux.transition.prototype={constructor:flux.transition,hasFinished:false,run:function(){var a=this;if(this.options.setup!==undefined)this.options.setup.call(this);this.slider.image1.css({"background-image":"none"});this.slider.imageContainer.css("overflow",this.options.requires3d?"visible":"hidden");setTimeout(function(){if(a.options.execute!==undefined)a.options.execute.call(a)},5)},finished:function(){if(this.hasFinished)return;this.hasFinished=true;if(this.options.after)this.options.after.call(this);this.slider.imageContainer.css("overflow","hidden");this.slider.setupImages();this.slider.element.trigger("fluxTransitionEnd",{currentImage:this.slider.getImage(this.slider.currentImageIndex)})},fallbackSetup:function(){},fallbackExecute:function(){this.finished()}};flux.transitions={};flux.transition_grid=function(b,c){return new flux.transition(b,a.extend({columns:6,rows:6,forceSquare:false,setup:function(){var b=this.slider.image1.width(),c=this.slider.image1.height();var d=Math.floor(b/this.options.columns),e=Math.floor(c/this.options.rows);if(this.options.forceSquare){e=d;this.options.rows=Math.floor(c/e)}var f=b-this.options.columns*d,g=Math.ceil(f/this.options.columns),h=c-this.options.rows*e,i=Math.ceil(h/this.options.rows),j=150,k=this.slider.image1.height(),l=0,m=0,n=document.createDocumentFragment();for(var o=0;o<this.options.columns;o++){var p=d,m=0;if(f>0){var q=f>=g?g:f;p+=q;f-=q}for(var r=0;r<this.options.rows;r++){var s=e,t=h;if(t>0){var q=t>=i?i:t;s+=q;t-=q}var u=a('<div class="tile tile-'+o+"-"+r+'"></div>').css({width:p+"px",height:s+"px",position:"absolute",top:m+"px",left:l+"px"});this.options.renderTile.call(this,u,o,r,p,s,l,m);n.appendChild(u.get(0));m+=s}l+=p}this.slider.image1.get(0).appendChild(n)},execute:function(){var a=this,b=this.slider.image1.height(),c=this.slider.image1.find("div.barcontainer");this.slider.image2.hide();c.last().transitionEnd(function(b){a.slider.image2.show();a.finished()});c.css3({transform:flux.browser.rotateX(-90)+" "+flux.browser.translate(0,b/2,b/2)})},renderTile:function(a,b,c,d,e,f,g){}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.bars=function(b,c){return new flux.transition_grid(b,a.extend({columns:10,rows:1,delayBetweenBars:40,renderTile:function(b,c,d,e,f,g,h){a(b).css({"background-image":this.slider.image1.css("background-image"),"background-position":"-"+g+"px 0px"}).css3({"transition-duration":"400ms","transition-timing-function":"ease-in","transition-property":"all","transition-delay":c*this.options.delayBetweenBars+"ms"})},execute:function(){var b=this;var c=this.slider.image1.height();var d=this.slider.image1.find("div.tile");a(d[d.length-1]).transitionEnd(function(){b.finished()});setTimeout(function(){d.css({opacity:"0.5"}).css3({transform:flux.browser.translate(0,c)})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.bars3d=function(b,c){return new flux.transition_grid(b,a.extend({requires3d:true,columns:7,rows:1,delayBetweenBars:150,perspective:1e3,renderTile:function(b,c,d,e,f,g,h){var i=a('<div class="bar-'+c+'"></div>').css({width:e+"px",height:"100%",position:"absolute",top:"0px",left:"0px","z-index":200,"background-image":this.slider.image1.css("background-image"),"background-position":"-"+g+"px 0px","background-repeat":"no-repeat"}).css3({"backface-visibility":"hidden"}),j=a(i.get(0).cloneNode(false)).css({"background-image":this.slider.image2.css("background-image")}).css3({transform:flux.browser.rotateX(90)+" "+flux.browser.translate(0,-f/2,f/2)}),k=a('<div class="side bar-'+c+'"></div>').css({width:f+"px",height:f+"px",position:"absolute",top:"0px",left:"0px",background:"#222","z-index":190}).css3({transform:flux.browser.rotateY(90)+" "+flux.browser.translate(f/2,0,-f/2)+" "+flux.browser.rotateY(180),"backface-visibility":"hidden"}),l=a(k.get(0).cloneNode(false)).css3({transform:flux.browser.rotateY(90)+" "+flux.browser.translate(f/2,0,e-f/2)});a(b).css({width:e+"px",height:"100%",position:"absolute",top:"0px",left:g+"px","z-index":c>this.options.columns/2?1e3-c:1e3}).css3({"transition-duration":"800ms","transition-timing-function":"linear","transition-property":"all","transition-delay":c*this.options.delayBetweenBars+"ms","transform-style":"preserve-3d"}).append(i).append(j).append(k).append(l)},execute:function(){this.slider.image1.css3({perspective:this.options.perspective,"perspective-origin":"50% 50%"}).css({"-moz-transform":"perspective("+this.options.perspective+"px)","-moz-perspective":"none","-moz-transform-style":"preserve-3d"});var a=this,b=this.slider.image1.height(),c=this.slider.image1.find("div.tile");this.slider.image2.hide();c.last().transitionEnd(function(b){a.slider.image1.css3({"transform-style":"flat"});a.slider.image2.show();a.finished()});setTimeout(function(){c.css3({transform:flux.browser.rotateX(-90)+" "+flux.browser.translate(0,b/2,b/2)})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.blinds=function(b,c){return new flux.transitions.bars(b,a.extend({execute:function(){var b=this;var c=this.slider.image1.height();var d=this.slider.image1.find("div.tile");a(d[d.length-1]).transitionEnd(function(){b.finished()});setTimeout(function(){d.css({opacity:"0.5"}).css3({transform:"scalex(0.0001)"})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.blinds3d=function(b,c){return new flux.transitions.tiles3d(b,a.extend({forceSquare:false,rows:1,columns:6},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.zip=function(b,c){return new flux.transitions.bars(b,a.extend({execute:function(){var b=this;var c=this.slider.image1.height();var d=this.slider.image1.find("div.tile");a(d[d.length-1]).transitionEnd(function(){b.finished()});setTimeout(function(){d.each(function(b,d){a(d).css({opacity:"0.3"}).css3({transform:flux.browser.translate(0,b%2?"-"+2*c:c)})})},20)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.blocks=function(b,c){return new flux.transition_grid(b,a.extend({forceSquare:true,delayBetweenBars:100,renderTile:function(b,c,d,e,f,g,h){var i=Math.floor(Math.random()*10*this.options.delayBetweenBars);a(b).css({"background-image":this.slider.image1.css("background-image"),"background-position":"-"+g+"px -"+h+"px"}).css3({"transition-duration":"350ms","transition-timing-function":"ease-in","transition-property":"all","transition-delay":i+"ms"});if(this.maxDelay===undefined)this.maxDelay=0;if(i>this.maxDelay){this.maxDelay=i;this.maxDelayTile=b}},execute:function(){var b=this;var c=this.slider.image1.find("div.tile");this.maxDelayTile.transitionEnd(function(){b.finished()});setTimeout(function(){c.each(function(b,c){a(c).css({opacity:"0"}).css3({transform:"scale(0.8)"})})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.blocks2=function(b,c){return new flux.transition_grid(b,a.extend({cols:12,forceSquare:true,delayBetweenDiagnols:150,renderTile:function(b,c,d,e,f,g,h){var i=Math.floor(Math.random()*10*this.options.delayBetweenBars);a(b).css({"background-image":this.slider.image1.css("background-image"),"background-position":"-"+g+"px -"+h+"px"}).css3({"transition-duration":"350ms","transition-timing-function":"ease-in","transition-property":"all","transition-delay":(c+d)*this.options.delayBetweenDiagnols+"ms","backface-visibility":"hidden"})},execute:function(){var b=this;var c=this.slider.image1.find("div.tile");c.last().transitionEnd(function(){b.finished()});setTimeout(function(){c.each(function(b,c){a(c).css({opacity:"0"}).css3({transform:"scale(0.8)"})})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.concentric=function(b,c){return new flux.transition(b,a.extend({blockSize:60,delay:150,alternate:false,setup:function(){var b=this.slider.image1.width(),c=this.slider.image1.height(),d=Math.sqrt(b*b+c*c),e=Math.ceil((d-this.options.blockSize)/2/this.options.blockSize)+1,f=document.createDocumentFragment();for(var g=0;g<e;g++){var h=2*g*this.options.blockSize+this.options.blockSize;var i=a("<div></div>").attr("class","block block-"+g).css({width:h+"px",height:h+"px",position:"absolute",top:(c-h)/2+"px",left:(b-h)/2+"px","z-index":100+(e-g),"background-image":this.slider.image1.css("background-image"),"background-position":"center center"}).css3({"border-radius":h+"px","transition-duration":"800ms","transition-timing-function":"linear","transition-property":"all","transition-delay":(e-g)*this.options.delay+"ms"});f.appendChild(i.get(0))}this.slider.image1.get(0).appendChild(f)},execute:function(){var b=this;var c=this.slider.image1.find("div.block");a(c[0]).transitionEnd(function(){b.finished()});setTimeout(function(){c.each(function(c,d){a(d).css({opacity:"0"}).css3({transform:flux.browser.rotateZ((!b.options.alternate||c%2?"":"-")+"90")})})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.warp=function(b,c){return new flux.transitions.concentric(b,a.extend({delay:30,alternate:true},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.cube=function(b,c){return new flux.transition(b,a.extend({requires3d:true,barWidth:100,direction:"left",perspective:1e3,setup:function(){var b=this.slider.image1.width();var c=this.slider.image1.height();this.slider.image1.css3({perspective:this.options.perspective,"perspective-origin":"50% 50%"});this.cubeContainer=a('<div class="cube"></div>').css({width:b+"px",height:c+"px",position:"relative"}).css3({"transition-duration":"800ms","transition-timing-function":"linear","transition-property":"all","transform-style":"preserve-3d"});var d={height:"100%",width:"100%",position:"absolute",top:"0px",left:"0px"};var e=a('<div class="face current"></div>').css(a.extend(d,{background:this.slider.image1.css("background-image")})).css3({"backface-visibility":"hidden"});this.cubeContainer.append(e);var f=a('<div class="face next"></div>').css(a.extend(d,{background:this.slider.image2.css("background-image")})).css3({transform:this.options.transitionStrings.call(this,this.options.direction,"nextFace"),"backface-visibility":"hidden"});this.cubeContainer.append(f);this.slider.image1.append(this.cubeContainer)},execute:function(){var a=this;var b=this.slider.image1.width();var c=this.slider.image1.height();this.slider.image2.hide();this.cubeContainer.transitionEnd(function(){a.slider.image2.show();a.finished()});setTimeout(function(){a.cubeContainer.css3({transform:a.options.transitionStrings.call(a,a.options.direction,"container")})},50)},transitionStrings:function(a,b){var c=this.slider.image1.width();var d=this.slider.image1.height();var e={up:{nextFace:flux.browser.rotateX(-90)+" "+flux.browser.translate(0,d/2,d/2),container:flux.browser.rotateX(90)+" "+flux.browser.translate(0,-d/2,d/2)},down:{nextFace:flux.browser.rotateX(90)+" "+flux.browser.translate(0,-d/2,d/2),container:flux.browser.rotateX(-90)+" "+flux.browser.translate(0,d/2,d/2)},left:{nextFace:flux.browser.rotateY(90)+" "+flux.browser.translate(c/2,0,c/2),container:flux.browser.rotateY(-90)+" "+flux.browser.translate(-c/2,0,c/2)},right:{nextFace:flux.browser.rotateY(-90)+" "+flux.browser.translate(-c/2,0,c/2),container:flux.browser.rotateY(90)+" "+flux.browser.translate(c/2,0,c/2)}};return e[a]&&e[a][b]?e[a][b]:false}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.tiles3d=function(b,c){return new flux.transition_grid(b,a.extend({requires3d:true,forceSquare:true,columns:5,perspective:600,delayBetweenBarsX:200,delayBetweenBarsY:150,renderTile:function(b,c,d,e,f,g,h){var i=a("<div></div>").css({width:e+"px",height:f+"px",position:"absolute",top:"0px",left:"0px","background-image":this.slider.image1.css("background-image"),"background-position":"-"+g+"px -"+h+"px","background-repeat":"no-repeat","-moz-transform":"translateZ(1px)"}).css3({"backface-visibility":"hidden"});var j=a(i.get(0).cloneNode(false)).css({"background-image":this.slider.image2.css("background-image")}).css3({transform:flux.browser.rotateY(180),"backface-visibility":"hidden"});a(b).css({"z-index":(c>this.options.columns/2?500-c:500)+(d>this.options.rows/2?500-d:500)}).css3({"transition-duration":"800ms","transition-timing-function":"ease-out","transition-property":"all","transition-delay":c*this.options.delayBetweenBarsX+d*this.options.delayBetweenBarsY+"ms","transform-style":"preserve-3d"}).append(i).append(j)},execute:function(){this.slider.image1.css3({perspective:this.options.perspective,"perspective-origin":"50% 50%"});var a=this;var b=this.slider.image1.find("div.tile");this.slider.image2.hide();b.last().transitionEnd(function(b){a.slider.image2.show();a.finished()});setTimeout(function(){b.css3({transform:flux.browser.rotateY(180)})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.turn=function(b,c){return new flux.transition(b,a.extend({requires3d:true,perspective:1300,direction:"left",setup:function(){var b=a('<div class="tab"></div>').css({width:"50%",height:"100%",position:"absolute",top:"0px",left:this.options.direction=="left"?"50%":"0%","z-index":101}).css3({"transform-style":"preserve-3d","transition-duration":"1000ms","transition-timing-function":"ease-out","transition-property":"all","transform-origin":this.options.direction=="left"?"left center":"right center"}),c=a("<div></div>").appendTo(b).css({"background-image":this.slider.image1.css("background-image"),"background-position":(this.options.direction=="left"?"-"+this.slider.image1.width()/2:0)+"px 0",width:"100%",height:"100%",position:"absolute",top:"0",left:"0","-moz-transform":"translateZ(1px)"}).css3({"backface-visibility":"hidden"}),d=a("<div></div>").appendTo(b).css({"background-image":this.slider.image2.css("background-image"),"background-position":(this.options.direction=="left"?0:"-"+this.slider.image1.width()/2)+"px 0",width:"100%",height:"100%",position:"absolute",top:"0",left:"0"}).css3({transform:flux.browser.rotateY(180),"backface-visibility":"hidden"}),e=a("<div></div>").css({position:"absolute",top:"0",left:this.options.direction=="left"?"0":"50%",width:"50%",height:"100%","background-image":this.slider.image1.css("background-image"),"background-position":(this.options.direction=="left"?0:"-"+this.slider.image1.width()/2)+"px 0","z-index":100}),f=a('<div class="overlay"></div>').css({position:"absolute",top:"0",left:this.options.direction=="left"?"50%":"0",width:"50%",height:"100%",background:"#000",opacity:1}).css3({"transition-duration":"800ms","transition-timing-function":"linear","transition-property":"opacity"}),g=a("<div></div>").css3({width:"100%",height:"100%"}).css3({perspective:this.options.perspective,"perspective-origin":"50% 50%"}).append(b).append(e).append(f);this.slider.image1.append(g)},execute:function(){var a=this;this.slider.image1.find("div.tab").first().transitionEnd(function(){a.finished()});setTimeout(function(){a.slider.image1.find("div.tab").css3({transform:flux.browser.rotateY(a.options.direction=="left"?-179:179)});a.slider.image1.find("div.overlay").css({opacity:0})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.slide=function(b,c){return new flux.transition(b,a.extend({direction:"left",setup:function(){var b=this.slider.image1.width(),c=this.slider.image1.height(),d=a('<div class="current"></div>').css({height:c+"px",width:b+"px",position:"absolute",top:"0px",left:"0px",background:this.slider[this.options.direction=="left"?"image1":"image2"].css("background-image")}).css3({"backface-visibility":"hidden"}),e=a('<div class="next"></div>').css({height:c+"px",width:b+"px",position:"absolute",top:"0px",left:b+"px",background:this.slider[this.options.direction=="left"?"image2":"image1"].css("background-image")}).css3({"backface-visibility":"hidden"});this.slideContainer=a('<div class="slide"></div>').css({width:2*b+"px",height:c+"px",position:"relative",left:this.options.direction=="left"?"0px":-b+"px","z-index":101}).css3({"transition-duration":"600ms","transition-timing-function":"ease-in","transition-property":"all"});this.slideContainer.append(d).append(e);this.slider.image1.append(this.slideContainer)},execute:function(){var a=this,b=this.slider.image1.width();if(this.options.direction=="left")b=-b;this.slideContainer.transitionEnd(function(){a.finished()});setTimeout(function(){a.slideContainer.css3({transform:flux.browser.translate(b)})},50)}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.swipe=function(b,c){return new flux.transition(b,a.extend({setup:function(){var b=a("<div></div>").css({width:"100%",height:"100%","background-image":this.slider.image1.css("background-image")}).css3({"transition-duration":"1600ms","transition-timing-function":"ease-in","transition-property":"all","mask-image":"-webkit-linear-gradient(left, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 48%, rgba(0,0,0,1) 52%, rgba(0,0,0,1) 100%)","mask-position":"70%","mask-size":"400%"});this.slider.image1.append(b)},execute:function(){var b=this,c=this.slider.image1.find("div");a(c).transitionEnd(function(){b.finished()});setTimeout(function(){a(c).css3({"mask-position":"30%"})},50)},compatibilityCheck:function(){return flux.browser.supportsCSSProperty("MaskImage")}},c))}})(window.jQuery||window.Zepto);(function(a){flux.transitions.dissolve=function(b,c){return new flux.transition(b,a.extend({setup:function(){var b=a('<div class="image"></div>').css({width:"100%",height:"100%","background-image":this.slider.image1.css("background-image")}).css3({"transition-duration":"600ms","transition-timing-function":"ease-in","transition-property":"opacity"});this.slider.image1.append(b)},execute:function(){var b=this,c=this.slider.image1.find("div.image");a(c).transitionEnd(function(){b.finished()});setTimeout(function(){a(c).css({opacity:"0.0"})},50)}},c))}})(window.jQuery||window.Zepto)

;/*
* Placeholder plugin for jQuery
* ---
* Copyright 2010, Daniel Stocks (http://webcloud.se)
* Released under the MIT, BSD, and GPL Licenses.
*/

(function(b){function d(a){this.input=a;a.attr("type")=="password"&&this.handlePassword();b(a[0].form).submit(function(){if(a.hasClass("placeholder")&&a[0].value==a.attr("placeholder"))a[0].value=""})}d.prototype={show:function(a){if(this.input[0].value===""||a&&this.valueIsPlaceholder()){if(this.isPassword)try{this.input[0].setAttribute("type","text")}catch(b){this.input.before(this.fakePassword.show()).hide()}this.input.addClass("placeholder");this.input[0].value=this.input.attr("placeholder")}},
hide:function(){if(this.valueIsPlaceholder()&&this.input.hasClass("placeholder")&&(this.input.removeClass("placeholder"),this.input[0].value="",this.isPassword)){try{this.input[0].setAttribute("type","password")}catch(a){}this.input.show();this.input[0].focus()}},valueIsPlaceholder:function(){return this.input[0].value==this.input.attr("placeholder")},handlePassword:function(){var a=this.input;a.attr("realType","password");this.isPassword=!0;if(b.browser.msie&&a[0].outerHTML){var c=b(a[0].outerHTML.replace(/type=(['"])?password\1/gi,
"type=$1text$1"));this.fakePassword=c.val(a.attr("placeholder")).addClass("placeholder").focus(function(){a.trigger("focus");b(this).hide()});b(a[0].form).submit(function(){c.remove();a.show()})}}};var e=!!("placeholder"in document.createElement("input"));b.fn.placeholder=function(){return e?this:this.each(function(){var a=b(this),c=new d(a);c.show(!0);a.focus(function(){c.hide()});a.blur(function(){c.show(!1)});b.browser.msie&&(b(window).load(function(){a.val()&&a.removeClass("placeholder");c.show(!0)}),
a.focus(function(){if(this.value==""){var a=this.createTextRange();a.collapse(!0);a.moveStart("character",0);a.select()}}))})}})(jQuery);
;jQuery.fn.sortElements=(function(){var sort=[].sort;return function(comparator,getSortable){getSortable=getSortable||function(){return this;};var placements=this.map(function(){var sortElement=getSortable.call(this),parentNode=sortElement.parentNode,nextSibling=parentNode.insertBefore(document.createTextNode(''),sortElement.nextSibling);return function(){if(parentNode===this){throw new Error("You can't sort elements if any one is a descendant of another.");}
parentNode.insertBefore(this,nextSibling);parentNode.removeChild(nextSibling);};});return sort.call(this,comparator).each(function(i){placements[i].call(getSortable.call(this));});};})();
;/*!
 * jQuery Transit - CSS3 transitions and transformations
 * (c) 2011-2012 Rico Sta. Cruz <rico@ricostacruz.com>
 * MIT Licensed.
 *
 * http://ricostacruz.com/jquery.transit
 * http://github.com/rstacruz/jquery.transit
 */
(function(k){k.transit={version:"0.9.9",propertyMap:{marginLeft:"margin",marginRight:"margin",marginBottom:"margin",marginTop:"margin",paddingLeft:"padding",paddingRight:"padding",paddingBottom:"padding",paddingTop:"padding"},enabled:true,useTransitionEnd:false};var d=document.createElement("div");var q={};function b(v){if(v in d.style){return v}var u=["Moz","Webkit","O","ms"];var r=v.charAt(0).toUpperCase()+v.substr(1);if(v in d.style){return v}for(var t=0;t<u.length;++t){var s=u[t]+r;if(s in d.style){return s}}}function e(){d.style[q.transform]="";d.style[q.transform]="rotateY(90deg)";return d.style[q.transform]!==""}var a=navigator.userAgent.toLowerCase().indexOf("chrome")>-1;q.transition=b("transition");q.transitionDelay=b("transitionDelay");q.transform=b("transform");q.transformOrigin=b("transformOrigin");q.transform3d=e();var i={transition:"transitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd",WebkitTransition:"webkitTransitionEnd",msTransition:"MSTransitionEnd"};var f=q.transitionEnd=i[q.transition]||null;for(var p in q){if(q.hasOwnProperty(p)&&typeof k.support[p]==="undefined"){k.support[p]=q[p]}}d=null;k.cssEase={_default:"ease","in":"ease-in",out:"ease-out","in-out":"ease-in-out",snap:"cubic-bezier(0,1,.5,1)",easeOutCubic:"cubic-bezier(.215,.61,.355,1)",easeInOutCubic:"cubic-bezier(.645,.045,.355,1)",easeInCirc:"cubic-bezier(.6,.04,.98,.335)",easeOutCirc:"cubic-bezier(.075,.82,.165,1)",easeInOutCirc:"cubic-bezier(.785,.135,.15,.86)",easeInExpo:"cubic-bezier(.95,.05,.795,.035)",easeOutExpo:"cubic-bezier(.19,1,.22,1)",easeInOutExpo:"cubic-bezier(1,0,0,1)",easeInQuad:"cubic-bezier(.55,.085,.68,.53)",easeOutQuad:"cubic-bezier(.25,.46,.45,.94)",easeInOutQuad:"cubic-bezier(.455,.03,.515,.955)",easeInQuart:"cubic-bezier(.895,.03,.685,.22)",easeOutQuart:"cubic-bezier(.165,.84,.44,1)",easeInOutQuart:"cubic-bezier(.77,0,.175,1)",easeInQuint:"cubic-bezier(.755,.05,.855,.06)",easeOutQuint:"cubic-bezier(.23,1,.32,1)",easeInOutQuint:"cubic-bezier(.86,0,.07,1)",easeInSine:"cubic-bezier(.47,0,.745,.715)",easeOutSine:"cubic-bezier(.39,.575,.565,1)",easeInOutSine:"cubic-bezier(.445,.05,.55,.95)",easeInBack:"cubic-bezier(.6,-.28,.735,.045)",easeOutBack:"cubic-bezier(.175, .885,.32,1.275)",easeInOutBack:"cubic-bezier(.68,-.55,.265,1.55)"};k.cssHooks["transit:transform"]={get:function(r){return k(r).data("transform")||new j()},set:function(s,r){var t=r;if(!(t instanceof j)){t=new j(t)}if(q.transform==="WebkitTransform"&&!a){s.style[q.transform]=t.toString(true)}else{s.style[q.transform]=t.toString()}k(s).data("transform",t)}};k.cssHooks.transform={set:k.cssHooks["transit:transform"].set};if(k.fn.jquery<"1.8"){k.cssHooks.transformOrigin={get:function(r){return r.style[q.transformOrigin]},set:function(r,s){r.style[q.transformOrigin]=s}};k.cssHooks.transition={get:function(r){return r.style[q.transition]},set:function(r,s){r.style[q.transition]=s}}}n("scale");n("translate");n("rotate");n("rotateX");n("rotateY");n("rotate3d");n("perspective");n("skewX");n("skewY");n("x",true);n("y",true);function j(r){if(typeof r==="string"){this.parse(r)}return this}j.prototype={setFromString:function(t,s){var r=(typeof s==="string")?s.split(","):(s.constructor===Array)?s:[s];r.unshift(t);j.prototype.set.apply(this,r)},set:function(s){var r=Array.prototype.slice.apply(arguments,[1]);if(this.setter[s]){this.setter[s].apply(this,r)}else{this[s]=r.join(",")}},get:function(r){if(this.getter[r]){return this.getter[r].apply(this)}else{return this[r]||0}},setter:{rotate:function(r){this.rotate=o(r,"deg")},rotateX:function(r){this.rotateX=o(r,"deg")},rotateY:function(r){this.rotateY=o(r,"deg")},scale:function(r,s){if(s===undefined){s=r}this.scale=r+","+s},skewX:function(r){this.skewX=o(r,"deg")},skewY:function(r){this.skewY=o(r,"deg")},perspective:function(r){this.perspective=o(r,"px")},x:function(r){this.set("translate",r,null)},y:function(r){this.set("translate",null,r)},translate:function(r,s){if(this._translateX===undefined){this._translateX=0}if(this._translateY===undefined){this._translateY=0}if(r!==null&&r!==undefined){this._translateX=o(r,"px")}if(s!==null&&s!==undefined){this._translateY=o(s,"px")}this.translate=this._translateX+","+this._translateY}},getter:{x:function(){return this._translateX||0},y:function(){return this._translateY||0},scale:function(){var r=(this.scale||"1,1").split(",");if(r[0]){r[0]=parseFloat(r[0])}if(r[1]){r[1]=parseFloat(r[1])}return(r[0]===r[1])?r[0]:r},rotate3d:function(){var t=(this.rotate3d||"0,0,0,0deg").split(",");for(var r=0;r<=3;++r){if(t[r]){t[r]=parseFloat(t[r])}}if(t[3]){t[3]=o(t[3],"deg")}return t}},parse:function(s){var r=this;s.replace(/([a-zA-Z0-9]+)\((.*?)\)/g,function(t,v,u){r.setFromString(v,u)})},toString:function(t){var s=[];for(var r in this){if(this.hasOwnProperty(r)){if((!q.transform3d)&&((r==="rotateX")||(r==="rotateY")||(r==="perspective")||(r==="transformOrigin"))){continue}if(r[0]!=="_"){if(t&&(r==="scale")){s.push(r+"3d("+this[r]+",1)")}else{if(t&&(r==="translate")){s.push(r+"3d("+this[r]+",0)")}else{s.push(r+"("+this[r]+")")}}}}}return s.join(" ")}};function m(s,r,t){if(r===true){s.queue(t)}else{if(r){s.queue(r,t)}else{t()}}}function h(s){var r=[];k.each(s,function(t){t=k.camelCase(t);t=k.transit.propertyMap[t]||k.cssProps[t]||t;t=c(t);if(k.inArray(t,r)===-1){r.push(t)}});return r}function g(s,v,x,r){var t=h(s);if(k.cssEase[x]){x=k.cssEase[x]}var w=""+l(v)+" "+x;if(parseInt(r,10)>0){w+=" "+l(r)}var u=[];k.each(t,function(z,y){u.push(y+" "+w)});return u.join(", ")}k.fn.transition=k.fn.transit=function(z,s,y,C){var D=this;var u=0;var w=true;if(typeof s==="function"){C=s;s=undefined}if(typeof y==="function"){C=y;y=undefined}if(typeof z.easing!=="undefined"){y=z.easing;delete z.easing}if(typeof z.duration!=="undefined"){s=z.duration;delete z.duration}if(typeof z.complete!=="undefined"){C=z.complete;delete z.complete}if(typeof z.queue!=="undefined"){w=z.queue;delete z.queue}if(typeof z.delay!=="undefined"){u=z.delay;delete z.delay}if(typeof s==="undefined"){s=k.fx.speeds._default}if(typeof y==="undefined"){y=k.cssEase._default}s=l(s);var E=g(z,s,y,u);var B=k.transit.enabled&&q.transition;var t=B?(parseInt(s,10)+parseInt(u,10)):0;if(t===0){var A=function(F){D.css(z);if(C){C.apply(D)}if(F){F()}};m(D,w,A);return D}var x={};var r=function(H){var G=false;var F=function(){if(G){D.unbind(f,F)}if(t>0){D.each(function(){this.style[q.transition]=(x[this]||null)})}if(typeof C==="function"){C.apply(D)}if(typeof H==="function"){H()}};if((t>0)&&(f)&&(k.transit.useTransitionEnd)){G=true;D.bind(f,F)}else{window.setTimeout(F,t)}D.each(function(){if(t>0){this.style[q.transition]=E}k(this).css(z)})};var v=function(F){this.offsetWidth;r(F)};m(D,w,v);return this};function n(s,r){if(!r){k.cssNumber[s]=true}k.transit.propertyMap[s]=q.transform;k.cssHooks[s]={get:function(v){var u=k(v).css("transit:transform");return u.get(s)},set:function(v,w){var u=k(v).css("transit:transform");u.setFromString(s,w);k(v).css({"transit:transform":u})}}}function c(r){return r.replace(/([A-Z])/g,function(s){return"-"+s.toLowerCase()})}function o(s,r){if((typeof s==="string")&&(!s.match(/^[\-0-9\.]+$/))){return s}else{return""+s+r}}function l(s){var r=s;if(k.fx.speeds[r]){r=k.fx.speeds[r]}return o(r,"ms")}k.transit.getTransitionValue=g})(jQuery);
;var Language=(function()
{var self={},items={};self.add=function(key,file,value)
{if(typeof items[file]=="undefined")
{items[file]=[];}
items[file][key]=value;}
self.set=function(data)
{data=data.replace(/\//,"");items={};items=JSON.parse(data);}
self.get=function(id,file)
{if(!file)
{var file="main";}
if(typeof items[file]!="undefined"&&typeof items[file][id]!="undefined")
{return items[file][id];}
else
{console.log("Language string "+id+" in "+file+" was not found");return false;}}
return self;}());function lang(id,file)
{return Language.get(id,file);};function Ajax()
{this.loaderHTML='<div style="padding:10px;text-align:center;"><img src="'+Config.image_path+'ajax.gif" /></div>';this.commentCount=0;this.showComments=function(id)
{var element=$("#comments_"+id);if(element.html().length>0)
{if(element.is(":visible"))
{element.slideUp(300);}
else
{element.fadeIn(300);}}
else
{element.html(Ajax.loaderHTML)
element.slideDown(200,function()
{$.get(Config.URL+"news/comments/get/"+id,function(data)
{element.fadeOut(300,function()
{element.html(data);element.fadeIn(300);Tooltip.refresh();});});});}}
this.submitComment=function(id)
{var content=$("#comment_field_"+id);if(content.val().length>0)
{var message=content.val();content.attr("disabled","disabled");$("#comment_button_"+id).attr("disabled","disabled");$.post(Config.URL+"news/comments/add/"+id,{content:message,csrf_token_name:Config.CSRF},function(data)
{content.val('');$("#characters_remaining_"+id).html("0 / 255");content.removeAttr("disabled");$("#comment_button_"+id).removeAttr("disabled","disabled");var button=$("#comments_button_"+id);var count=button.html().replace(/[^0-9.]/,"")
Ajax.commentCount++;$("#comments_area_"+id).prepend('<div id="my_comment_'+Ajax.commentCount+'" style="display:none;"></div>');$("#my_comment_"+Ajax.commentCount).html(data).slideDown(300);});}
else
{UI.alert("The message must be between 0-255 characters long!")}}
this.remove=function(field,id)
{$(field).parent().parent().slideUp(function()
{$(this).remove();});$.get(Config.URL+"news/comments/delete/"+id,function(data)
{console.log(data);});}}
var Ajax=new Ajax();

// toggle masked texts with readable texts
function ToggleMaskedText(a_TextFieldID)
{
  m_DisplayedText = document.getElementById('Display' + a_TextFieldID).innerHTML;
  m_MaskedText = document.getElementById('Masked' + a_TextFieldID).innerHTML;
  m_ReadableText = document.getElementById('Readable' + a_TextFieldID).innerHTML;
  if (m_DisplayedText == m_MaskedText) {
    document.getElementById('Display' + a_TextFieldID).innerHTML = document.getElementById('Readable' + a_TextFieldID).innerHTML;
    document.getElementById('Button' + a_TextFieldID).src = './layouts/metro/images/hide.gif';
  } else {
    document.getElementById('Display' + a_TextFieldID).innerHTML = document.getElementById('Masked' + a_TextFieldID).innerHTML;
    document.getElementById('Button' + a_TextFieldID).src = './layouts/metro/images/show.gif';
  }
}