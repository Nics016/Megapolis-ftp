/* SIDEBAR */

var picId = "sliderPic";
var textId = "sliderText";
var curElem = 0, maxElemNum = 4;
var running = true;
var sTextes = ["Бесплатная резка в размер",
							"Доставка в день заказа",
							"Удобный заказ одним кликом",
							"Большой ассортимент металлопроката",
							"Позвоните нам для получения консультации"
							];

// starting cycling
function bodyLoad(){
	var t = setTimeout(nextPic, 3000);
}

function nextPic(){
	if (running)
	{
		curElem++;
		if (curElem > maxElemNum)
		{
			curElem = 0;
		}
		setPic(curElem);
		setActiveCircle(curElem);
		setText(curElem);
	}
	// recursing ourselves
	var t = setTimeout(nextPic, 5000);
}

// changes image's url to sliderX.jpg
function setPic(x){
	var newPicImg = "img/slider" + x + ".jpg";
	document.getElementById(picId).style.backgroundImage="url('"
	+ newPicImg + "')";
}

// sets yellow circle to circleX
function setActiveCircle(newX){
	var newCircleId = "circle" + newX;
	for (var i = 0; i <= maxElemNum; i++)
	{
		var curId = "circle" + i;
		document.getElementById(curId).className = 
		"fa fa-circle";
	}
	document.getElementById(newCircleId).className = 
	"fa fa-circle active";
}

function stopRunning() {
	running = false;
}

function startRunning(){
	running = true;
}

// user clicks on circle X
function clickCircle(x){
	setPic(x);
	setActiveCircle(x);
	setText(x);
	curElem = x;
}

// changes text to the text from array
function setText(x)
{
	document.getElementById(textId).innerHTML = 
		sTextes[x];
}