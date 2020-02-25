var Language=(function()
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
{return Language.get(id,file);}