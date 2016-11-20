<!--
function showTAB(id) {
	obj_tabs = document.getElementById(id);
	obj_tabs.style.display = "block"
}
function hideTAB() {
	obj_tabs.style.display = "none";
}
function change(obj)
{
//alert(obj.parentNode.id)
for(i=0;i<document.getElementsByTagName("li").length;i++)
{
document.getElementsByTagName("li")[i].id=""
}
obj.parentNode.id="current"
//alert(obj.parentNode.id)
} 
//-->