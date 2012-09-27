$(document).ready(function(){
	$(".cBox").click(function(){
		manageCustomer($(this).attr("name"), $(this).attr("value"));
	});
	$(".time").click(function(){
		changeActive($(this).attr("value"), $(this));
	});
	addTableEvents();
	
	$("#save").click(function(){
		updateCurrentValues();
		return false;
	});
	setInterval('updateClock()', 1000);
});

function manageCustomer(func,id){
	var $el = $(this);
	$.post("ajax.php", {"action": func, "id":id}, function(data){if (data != "1"){alert("ERROR: ALLE IN DECKUNG")}else{
		act = func=="add" ? "remove":"add";
		//alert(act+" "+func);
		$("#"+id).attr("name", act);
	}});
}

function changeActive(id, el){
	$('#active').attr("id", "");
	$(el).attr("id", "active");
	$.post("ajax.php", {"change": "true", "id":id}, function(data){
			/*if (data != "1"){alert(data)};*/
			updateTable(true);
			edit(data);
			resetClock();
	});
}

function updateCurrentValues(){
	$.post('ajax.php', $("#editForm").serializeArray(), function(data) {
		if (data != ""){alert(data)};
		updateTable(true);
	});
}

function edit(id){
	$.post("ajax.php", {"edit": "true", "id":id}, function(data){
		$("#editForm").html(data);
		$("#save").click(function(){
			updateCurrentValues();
			return false;
		});
	});	
}

function updateTable(id){
	$.post("ajax.php", {"updateTable": "true", "id":id}, function(data){
		$("#timesheet").html(data);
		addTableEvents();
	});
}

function addTableEvents(){
	$(".edit").click(function(){
		edit($(this).attr("id"));
	});
	$(".list:not(#isrunning)").mouseenter(function(){
		var oldcolor = $(this).attr("bgcolor", "#ccffcc");
	}).mouseleave(function(){
		var bgcolor=$(this).index()%2==0?"#ffffff":"#aaaaaa"; 
		$(this).attr("bgcolor" , bgcolor);
	});
}



function resetClock(){
	this.currentHours = 0
	this.currentMinutes = 0;
	this.currentSeconds = 0;
	this.currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
	this.currentHours = ( currentHours < 10 ? "0" : "" ) + currentHours;
}

var currentHours = 0;
var currentMinutes = 0;
var currentSeconds = 0;
currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
currentHours = ( currentHours < 10 ? "0" : "" ) + currentHours;

function updateClock ()
	{
  	currentSeconds++;
  	    if(currentSeconds >59)
  	{
  	currentMinutes++;
  	currentSeconds = 0;
  	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  	}
  	if(currentMinutes >59)
  	{
  	currentHours++;
  	currentMinutes =0;
  	}
  	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
	currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
	$("#clock").html(currentTimeString);
  	  	
}