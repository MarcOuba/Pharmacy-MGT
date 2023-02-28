

function getOrderQty(dataLength){


	$.ajax({
		url: "includes/ws_charts.php",
		method: "GET",
		data:({op:1}),
	   
		success: function(data) {

var parsedData=JSON.parse(data);
		  
			var label = [];
			var values = [];
			


			if(parsedData.length < dataLength){
			for(var i in parsedData) {
				label.push(parsedData[i].label);
				
				values.push(parsedData[i].value);
			}}
			else{
				
				for(let j=0;j<dataLength;j++) {
					var max=parsedData[0].value;
			var maxIndex=0;
				for (let i = 1; i < parsedData.length; i++) {
					if (parsedData[i].value > max) {
						maxIndex = i;
						max = parsedData[i].value;
					}
				}

				
					label.push(parsedData[maxIndex].label);
					
					values.push(parsedData[maxIndex].value);
					parsedData.splice(maxIndex, 1);
				}
			}
			var ctx = $("#qtyChart");
			var chart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: label,
					datasets: [{
						label: 'sold quantity of items',
						data: values,
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor: 'rgba(255, 99, 132, 1)',
						borderWidth: 1,
						innerHeight:"100px"
					}]
				},
				options: {
					hover: {mode: null},
					responsive: true,
	maintainAspectRatio: false,
	layout: {
		padding: {
			left: 10,
			right: 0,
			top: 10,
			bottom: 10
		}
	},
	
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
		},
		error: function(data) {
			console.log("error");
		}
	});



	

}

function replaceCanvas(elem,id) {
	var canvas = document.createElement('canvas'),
		newContext = canvas.getContext('2d');
		canvas.setAttribute("id",id);
		
	// Insert the new canvas after the old one
	elem.parentNode.insertBefore(canvas, elem.nextSibling);
	// Remove old canvas. Now the new canvas has its position.
	elem.parentNode.removeChild(elem);
	return newContext;
}


function qtyChartOptions(){

	$("body").on("click", ".qtychart", function () {


		var name = $(this).html();
var id=$(this).attr("id");
		$("#btnQtyChart").html(name + " <span class='caret'></span>");
		

		$(".qtychart").each(function () {
			if ($(this).parents("li").hasClass("active")) {
				$(this).parents("li").removeClass("active");
			}
		});

		$(this).parents("li").addClass("active");


		switch(id){
			case "showAllQtyChart":
				replaceCanvas(document.getElementById('qtyChart'),"qtyChart");
getOrderQty(10000000);
				break;
				case "showTop5QtyChart":
					replaceCanvas(document.getElementById('qtyChart'),"qtyChart");
					getOrderQty(5);
				break;
				case "showTop25QtyChart":
					replaceCanvas(document.getElementById('qtyChart'),"qtyChart");
					getOrderQty(25);
				break;
				case "showTop100QtyChart":
					replaceCanvas(document.getElementById('qtyChart'),"qtyChart");
					getOrderQty(100);
				break;
		}




	})


}



function getNetWorth(dataLength){

	$.ajax({
		url: "includes/ws_charts.php",
		method: "GET",
		data:({op:2}),
		success: function(data) {

var parsedData=JSON.parse(data);

		  
		  
			var label = [];
			var values = [];
			if(parsedData.length < dataLength){
				for(var i in parsedData) {
					label.push(parsedData[i].label);
					
					values.push(parsedData[i].value);
				}}
				else{
				
					for(let j=0;j<dataLength;j++) {
						var max=parsedData[0].value;
				var maxIndex=0;
					for (let i = 1; i < parsedData.length; i++) {
						if (parsedData[i].value > max) {
							maxIndex = i;
							max = parsedData[i].value;
						}
					}
	
					
						label.push(parsedData[maxIndex].label);
						
						values.push(parsedData[maxIndex].value);
						parsedData.splice(maxIndex, 1);
					}
				}
			var ctx = $("#netWorthChart");
			var chart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: label,
					datasets: [{
						label: 'Net Worth of sold items in LL',
						data: values,
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor: 'rgba(255, 99, 132, 1)',
						borderWidth: 1,
						innerHeight:"100px"
					}]
				},
				options: {
					responsive: true,
	maintainAspectRatio: false,
	layout: {
		padding: {
			left: 10,
			right: 0,
			top: 10,
			bottom: 10
		}
	},
					scales: {
						x:{
							type: 'linear',
						}
						
					}
				}
			});
		},
		error: function(data) {
			console.log("error");
		}
	});
	




}

function netWorthChartOptions(){

	$("body").on("click", ".netWorthchart", function () {


		var name = $(this).html();
var id=$(this).attr("id");
		$("#btnNetWorthChart").html(name + " <span class='caret'></span>");
		

		$(".netWorthchart").each(function () {
			if ($(this).parents("li").hasClass("active")) {
				$(this).parents("li").removeClass("active");
			}
		});

		$(this).parents("li").addClass("active");


		switch(id){
			case "showAllnetWorthChart":
				replaceCanvas(document.getElementById('netWorthChart'),"netWorthChart");
getNetWorth(10000000);
				break;
				case "showTop5netWorthChart":
					replaceCanvas(document.getElementById('netWorthChart'),"netWorthChart");
					getNetWorth(5);
				break;
				case "showTop25netWorthChart":
					replaceCanvas(document.getElementById('netWorthChart'),"netWorthChart");
					getNetWorth(25);
				break;
				case "showTop100netWorthChart":
					replaceCanvas(document.getElementById('netWorthChart'),"netWorthChart");
					getNetWorth(100);
				break;
		}




	})


}


function getUsersNetWorth(dataLength){

	$.ajax({
		url: "includes/ws_charts.php",
		method: "GET",
		data:({op:3}),
		success: function(data) {

var parsedData=JSON.parse(data);

		 
		  
			var label = [];
			var values = [];
			if(parsedData.length < dataLength){
				for(var i in parsedData) {
					label.push(parsedData[i].label);
					
					values.push(parsedData[i].value);
				}}
				else{
				
					for(let j=0;j<dataLength;j++) {
						var max=parsedData[0].value;
				var maxIndex=0;
					for (let i = 1; i < parsedData.length; i++) {
						if (parsedData[i].value > max) {
							maxIndex = i;
							max = parsedData[i].value;
						}
					}
	
					
						label.push(parsedData[maxIndex].label);
						
						values.push(parsedData[maxIndex].value);
						parsedData.splice(maxIndex, 1);
					}
				}
			var ctx = $("#usersNetWorthChart");
			var chart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: label,
					datasets: [{
						label: 'Net Worth of users transactions in LL',
						data: values,
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor: 'rgba(255, 99, 132, 1)',
						borderWidth: 1,
						innerHeight:"100px"
					}]
				},
				options: {
					responsive: true,
	maintainAspectRatio: false,
	layout: {
		padding: {
			left: 10,
			right: 0,
			top: 10,
			bottom: 10
		}
	},
					scales: {
						x:{
							type: 'linear',
						}
						
					}
				}
			});
		},
		error: function(data) {
			console.log("error");
		}
	});
	




}


function usersNetWorthChartOptions(){

	$("body").on("click", ".usersNetWorthchart", function () {


		var name = $(this).html();
var id=$(this).attr("id");
		$("#btnUsersNetWorthChart").html(name + " <span class='caret'></span>");
		

		$(".usersNetWorthchart").each(function () {
			if ($(this).parents("li").hasClass("active")) {
				$(this).parents("li").removeClass("active");
			}
		});

		$(this).parents("li").addClass("active");


		switch(id){
			case "showAllUsersNetWorthChart":
				replaceCanvas(document.getElementById('usersNetWorthChart'),"usersNetWorthChart");
getUsersNetWorth(10000000);
				break;
				case "showTop5UsersNetWorthChart":
					replaceCanvas(document.getElementById('usersNetWorthChart'),"usersNetWorthChart");
					getUsersNetWorth(5);
				break;
				case "showTop25UsersNetWorthChart":
					replaceCanvas(document.getElementById('usersNetWorthChart'),"usersNetWorthChart");
					getUsersNetWorth(25);
				break;
				case "showTop100UsersNetWorthChart":
					replaceCanvas(document.getElementById('usersNetWorthChart'),"usersNetWorthChart");
					getUsersNetWorth(100);
				break;
		}




	})


}


function checkboxesForCharts(){
	$(".chart-child").each(function(){
		$(this).hide();
	});

	$("body").on("click","#showQtyCanvas",function(){
if($(this).is(":checked")){
	$(".chart-child").eq(0).show();
}
else{
	$(".chart-child").eq(0).hide();
}
	})

	$("body").on("click","#showItemsCanvas",function(){
		if($(this).is(":checked")){
			$(".chart-child").eq(1).show();
		}
		else{
			$(".chart-child").eq(1).hide();
		}
			})

			$("body").on("click","#showUsersCanvas",function(){
				if($(this).is(":checked")){
					$(".chart-child").eq(2).show();
				}
				else{
					$(".chart-child").eq(2).hide();
				}
					})
}







$(function () {

	getOrderQty(100000000);
qtyChartOptions();
getNetWorth(10000000);
netWorthChartOptions();
getUsersNetWorth(10000000);
usersNetWorthChartOptions();
checkboxesForCharts();



});