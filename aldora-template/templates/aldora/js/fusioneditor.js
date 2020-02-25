var FusionEditor={Tools:{bold:function(id)
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