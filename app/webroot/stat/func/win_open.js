var win=null;

onerror = stopError;
function stopError(){
	return true;
}

// main folder popup window
function create_archive(){
	myleft=(screen.width)?(screen.width-470)/2:100;mytop=(screen.height)?(screen.height-320)/2:100;
	settings="width=440,height=260,top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=no,dependent=yes";
	win=window.open("archive.php","archive",settings);
	win.focus();
}
function quick_archive(url)
{
 var breite=1008; var hoehe=760; var positionX=((screen.availWidth / 2) - breite / 2); var positionY=((screen.availHeight / 2) - hoehe / 2);
 pop=window.open('','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,fullscreen=0,width='+breite+',height='+hoehe+',top=10000,left=10000'); pop.resizeTo(breite,hoehe); pop.moveTo(positionX,positionY); pop.location=url;
}
function show_archive(){
	myleft=(screen.width)?(screen.width-1018)/2:100;mytop=(screen.height)?(screen.height-850)/2:100;
	settings="width=1008,height=810,top=" + mytop + ",left=" + myleft + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes,dependent=yes";
	win=window.open("index.php?action=backtostat","index",settings);
	win.focus();
}
function show_plugin(){
	myleft=(screen.width)?(screen.width-1018)/2:100;mytop=(screen.height)?(screen.height-850)/2:100;
	settings="width=1008,height=810,top=" + mytop + ",left=" + myleft + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes,dependent=yes";
	win=window.open("plugin_loader.php","plugin",settings);
	win.focus();
}

// config folder popup window
function manual_de(){
	myleft=(screen.width)?(screen.width-868)/2:100;mytop=(screen.height)?(screen.height-700)/2:100;
	settings="width=858,height=640,top=" + mytop + ",left=" + myleft + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes,dependent=yes";
	win=window.open("http://www.php-web-statistik.de/manual/german/index.html","manual",settings);
	win.focus();
}
function manual_en(){
	myleft=(screen.width)?(screen.width-868)/2:100;mytop=(screen.height)?(screen.height-700)/2:100;
	settings="width=858,height=640,top=" + mytop + ",left=" + myleft + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes,dependent=yes";
	win=window.open("http://www.php-web-statistik.de/manual/index.html","manual",settings);
	win.focus();
}
function sysinfo(){
	myleft=(screen.width)?(screen.width-838)/2:100;mytop=(screen.height)?(screen.height-700)/2:100;
	settings="width=828,height=650,top=" + mytop + ",left=" + myleft + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes,dependent=yes";
	win=window.open("../sysinfo.php","sysinfo",settings);
	win.focus();
}
function cache(){
	myleft=(screen.width)?(screen.width-470)/2:100;mytop=(screen.height)?(screen.height-320)/2:100;
	settings="width=440,height=260,top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=no,dependent=yes";
	win=window.open("../cache_panel.php","cache",settings);
	win.focus();
}
function db_transfer(){
	myleft=(screen.width)?(screen.width-470)/2:100;mytop=(screen.height)?(screen.height-320)/2:100;
	settings="width=440,height=260,top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=no,dependent=yes";
	win=window.open("db_transfer.php","import",settings);
	win.focus();
}
function db_result(){
	myleft=(screen.width)?(screen.width-918)/2:100;mytop=(screen.height)?(screen.height-520)/2:100;
	settings="width=908,height=540,top=" + mytop + ",left=" + myleft + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes,dependent=yes";
	win=window.open("edit_db.php","result",settings);
	win.focus();
}