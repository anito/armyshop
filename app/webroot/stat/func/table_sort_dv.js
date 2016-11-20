// TableSort 7.21
// Jürgen Berkemeier, 08.02.2007
// www.j-berkemeier.de
function JB_Table(tab) {
 var up = String.fromCharCode(160,9650);
 var down = String.fromCharCode(160,9660);
// var up = String.fromCharCode(160,8593);
// var down = String.fromCharCode(160,8595);
 var no = String.fromCharCode(160,160,160,160);
 var first=1;
 var ssort;
 var tbdy=tab.getElementsByTagName("tbody")[0];
 var tz=tbdy.getElementsByTagName("tr");
 var nzeilen=tz.length;
 var nspalten=tz[0].getElementsByTagName("td").length;
 var Titel=tab.getElementsByTagName("thead")[0].getElementsByTagName("tr")[0].getElementsByTagName("th");
 var Arr=new Array(nzeilen);
 var S_Type=new Array(nspalten); for(var s=0;s<nspalten;s++) S_Type[s]="X";
 var ct=0;
 tab.title="";
 for(var i=0;i<Titel.length;i++) {
  var t=Titel[i];
  if(t.className.indexOf("lh_header")>-1 || t.className.indexOf("sorted")>-1) {
   ct++;
   t.nr=i;
   t.style.cursor="pointer";
   t.thisObj = this;
   t.onclick = function() { this.thisObj.sort(this.nr); }
   t.appendChild(document.createTextNode(no));
   t.title=' "'+t.firstChild.data+'" ';
   if(t.className.indexOf("sorted-")>-1) {
    t.lastChild.data=down;
    ssort=i;
   }
   else if(t.className.indexOf("sorted")>-1) {
    t.lastChild.data=up;
    ssort=i;
   }
  }
 }
 if(ct==0) {
  for(var i=0;i<Titel.length;i++) {
   var t=Titel[i];
   t.nr=i;
   t.style.cursor="pointer";
   t.thisObj = this;
   t.onclick = function() { this.thisObj.sort(this.nr); }
   t.appendChild(document.createTextNode(no));
   t.title=' "'+t.firstChild.data+'" ';
   if(t.className.indexOf("sorted-")>-1) {
    t.lastChild.data=down;
    ssort=i;
   }
   else if(t.className.indexOf("sorted")>-1) {
    t.lastChild.data=up;
    ssort=i;
   }
  }
 }
 var VglFkt_Str=function(a,b) {
  var ta=a[ssort].toUpperCase();
  var tb=b[ssort].toUpperCase();
  if (ta>tb) return 1;
  else if (ta<tb) return -1;
  else {
   ta=a[0].toUpperCase();
   tb=b[0].toUpperCase();
   if (ta>tb) return 1;
   else if (ta<tb) return -1;
   else return 0;
  }
 }
 var VglFkt_Num=function(a,b) {
  var ta=parseFloat(a[ssort]);
  var tb=parseFloat(b[ssort]);
  if (ta>tb) return 1;
  else if (ta<tb) return -1;
  else {
   ta=parseFloat(a[0]);
   tb=parseFloat(b[0]);
   if (ta>tb) return 1;
   else if (ta<tb) return -1;
   else return 0;
  }
 }
 var VglFkt_Datum=function(a,b) {
  var convert=function(str) {
   var ar=str.split(".");
   for(var i=0;i<3;i++) {
    var ari=parseInt(ar[i],10);
    if(ari<10) ar[i]="0"+ari ;
    else ar[i]=""+ari ;
   }
   return ""+ar[2]+ar[1]+ar[0];
  }
  var ta=convert(a[ssort].toUpperCase());
  var tb=convert(b[ssort].toUpperCase());
  if (ta>tb) return 1;
  else if (ta<tb) return -1;
  else {
   ta=convert(a[0].toUpperCase());
   tb=convert(b[0].toUpperCase());
   if (ta>tb) return 1;
   else if (ta<tb) return -1;
   else return 0;
  }
 }
 var VglFkt_Lnk=function(a,b) {
  var ta=a[ssort].substr(a[ssort].indexOf(">")+1).toUpperCase();
  var tb=b[ssort].substr(b[ssort].indexOf(">")+1).toUpperCase();
  if (ta>tb) return 1;
  else if (ta<tb) return -1;
  else {
   ta=a[0].substr(a[ssort].indexOf(">")+1).toUpperCase();
   tb=b[0].substr(b[ssort].indexOf(">")+1).toUpperCase();
   if (ta>tb) return 1;
   else if (ta<tb) return -1;
   else return 0;
  }
 }
 this.sort=function(sp) {
  if (first==1) {
   for(var z=0;z<nzeilen;z++) {
    var zeile=tz[z].getElementsByTagName("td");
    Arr[z]=new Array(nspalten);
    for(var s=0;s<nspalten;s++) {
     var val=zeile[s].innerHTML;
//     var val=zeile[s].firstChild.nodeValue;
     Arr[z][s]=val;
     if(!isNaN(val)&&(S_Type[s]=="n"||S_Type[s]=="X")) S_Type[s]="n";
     else if(val.substr(0,2).toLowerCase()=="<a"&&(S_Type[s]=="l"||S_Type[s]=="s"||S_Type[s]=="X")) S_Type[s]="l";
     else {
      var arr=val.split(".");
      if(arr.length==3&&!isNaN(arr[0])&&!isNaN(arr[1])&&!isNaN(arr[2])&&(S_Type[s]=="d"||S_Type[s]=="X")) S_Type[s]="d";
      else if(S_Type[s]!="l") S_Type[s]="s";
     }
    }
   }
   first=0;
  }
  if(sp==ssort) {
   Arr.reverse() ;
   if ( Titel[ssort].lastChild.data==down )
    Titel[ssort].lastChild.data=up;
   else
    Titel[ssort].lastChild.data=down;
  }
  else {
   if ( ssort>=0 && ssort<nspalten ) Titel[ssort].lastChild.data=no;
   ssort=sp;
   if(S_Type[ssort]=="n")      Arr.sort(VglFkt_Num);
   else if(S_Type[ssort]=="l") Arr.sort(VglFkt_Lnk);
   else if(S_Type[ssort]=="d") Arr.sort(VglFkt_Datum);
   else                        Arr.sort(VglFkt_Str);
   Titel[ssort].lastChild.data=up;
  }
  for(var z=0;z<nzeilen;z++) {
   var zeile=tz[z].getElementsByTagName("td");
   for(var s=0;s<nspalten;s++) {
//    zeile[s].firstChild.nodeValue=Arr[z][s];
    zeile[s].innerHTML=""; // für den MAC-IE
    zeile[s].innerHTML=Arr[z][s];
   }
  }
 }
}
function BrowserTest() {
 var kannDOM=document.getElementsByTagName;
 if (kannDOM) kannDOM=document.getElementsByTagName('body')[0].appendChild;
 if (!kannDOM) return false;
 return true;
}
function addEvent(oTarget, sType, fpDest) {
 var oOldEvent = oTarget[sType];
 if (typeof oOldEvent != "function") {
  oTarget[sType] = fpDest;
  } else {
   oTarget[sType] = function(e) {
   oOldEvent(e);
   fpDest(e);
  }
 }
}
function getElementsByClass_TagName(tagname,classname) {
 var tag=document.getElementsByTagName(tagname);
 var Elements=new Array();
 for(var i=0;i<tag.length;i++) {
  if(tag[i].className.indexOf(classname)>-1) Elements[Elements.length]=tag[i];
 }
 return Elements;
}
function JB_TabSort_Init(e) {
 if (!BrowserTest()) return;
 var Sort_Table=getElementsByClass_TagName("table","stat_table");
 for(var i=0;i<Sort_Table.length;i++) new JB_Table(Sort_Table[i]);
}
addEvent(window,"onload",JB_TabSort_Init);