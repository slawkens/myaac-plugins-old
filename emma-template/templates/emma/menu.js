// JavaScript Document

function menuAction(menuName)
{
	if( menu[menuName] == 'on' )
	{
		document.getElementById(menuName + '_Submenu').style.display = 'none';
		document.getElementById(menuName + '_Icon').style.backgroundImage = 'url(' + imgPath + '/images/menu/' + menuName + '_icon.png)';
		document.getElementById(menuName + '_Name').style.backgroundImage = 'url(' + imgPath + '/images/menu/' + menuName + '.png)';
		document.getElementById(menuName + '_Status').style.backgroundImage = 'url(' + imgPath + '/images/menu/open.png)';
		document.cookie = ''+ menuName +'='+escape('off')+';expires='+date.toGMTString()+'';
		menu[menuName] = 'off';
	}
	else
	{
		document.getElementById(menuName + '_Submenu').style.display = 'block';
		document.getElementById(menuName + '_Icon').style.backgroundImage = 'url(' + imgPath + '/images/menu/' + menuName + '_active_icon.png)';
		document.getElementById(menuName + '_Name').style.backgroundImage = 'url(' + imgPath + '/images/menu/' + menuName + '_active.png)';
		document.getElementById(menuName + '_Status').style.backgroundImage = 'url(' + imgPath + '/images/menu/close.png)';
		document.cookie = ''+ menuName +'='+escape('on')+';expires='+date.toGMTString()+'';	
		menu[menuName] = 'on';
	}
}

function makeItemActive(subtopic)
{
	var obj = document.getElementById(subtopic);
	
	if( obj.className == 'menu-item' )
	{
		obj.className = 'menu-item-active';	
	}
	else if( obj.className == 'menu-item-last' )
	{
		obj.className = 'menu-item-last-active';	
	}
}