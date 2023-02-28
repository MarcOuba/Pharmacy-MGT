





function getlogin(usrval, pwdval) {

	$.ajax({
		type: 'GET',
		url: "includes/ws_users.php",
		data: ({ op: 5, uname: usrval, upwd: pwdval }),

		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {
			if (data == -1)
				alert("Data couldn't be loaded!");

			else {
				data = JSON.parse(xhr.responseText);
				validateLogin(data);
			}
		},
		error: function (xhr, status, errorThrown) {

			alert(status + errorThrown);
		}
	});

}







function validateLogin(data) {

	if (data == false) {
		$("#wrongCredentials").text("Wrong credentials.  Try again");

	}

	else
		window.location.href = "mainpage.php";

}




















function populateCart(data) {

	if (data.length > 0) {

		var item = "";
		$(".cart-container").empty();

		$.each(data, function (index, row) {


			item = '<div class="items-in-cart card rounded-3 mb-4"><div class="card-body p-4"><div class="row d-flex justify-content-between align-items-center"><div class="col-md-2 col-lg-2 col-xl-2">';
			item += ' <img style="width:80px;height:80px;" src="' + row.item_img_path + '" class="img-fluid rounded-3" alt="' + row.item_name + '">';
			item += ' </div><div  class="cart-row col-md-3 col-lg-3 col-xl-3"><p class="lead fw-normal mb-2">' + row.item_name + '</p></div>';
			item += '<div style="margin-top:-30px;margin-bottom:60px;"  class="col-md-3 col-lg-3 col-xl-2 d-flex"><input type="hidden" value="' + row.item_price + '"><button id="decrementQty' + row.od_id + '" class="decrementQty btn btn-link px-2"><i class="fas fa-minus"></i></button>';
			item += '<input readonly="readonly" id="shoppingCartQty' + row.od_id + '" min="0" name="quantity" value="' + row.od_qty + '" type="number" class="form-control form-control-sm" />';
			item += ' <button id="incrementQty' + row.od_id + '" class="incrementQty btn btn-link px-2"><i class="fas fa-plus"></i></button></div>';
			item += ' <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1"><h5 class="mb-0">' + row.od_total_amount + '</h5></div>';
			item += ' <div class="col-md-1 col-lg-1 col-xl-1 text-end"><a href="#!" id="deleteFromCart' + row.od_id + '" class="text-danger deleteFromCart"><i class="fas fa-trash fa-lg"></i></a></div></div></div></div>';

			$(".cart-container").append(item);




		});
	}
	else {
		$(".cart-container").empty();
	}
}





////////// SHOPPING CART PAGE ////////////////////////////


function openShoppingModal(text) {




	var name = $(this).parents("div").children("div").eq(0).children("p").eq(0).html();
	$("#cart-text").html(text);

	$("#cart-modal").modal({
		backdrop: 'static',
		keyboard: false
	});

	$("#cart-modal").modal("show");
	$("#blur-background").addClass("bg");



	$("body").on("click", "#continue-shopping", function () {

		$("#blur-background").removeClass("bg");
	});

	$("body").on("click", "#close-modal", function () {

		$("#blur-background").removeClass("bg");
	});


	$("#view-cart").on("click", function () {
		$("#blur-background").removeClass("bg");
		window.location.href = "http://localhost/ajax/shoppingCart.php#";
	});
}

function getOrderDetailsTotal(){
	$.ajax({
		type: 'GET',
		url: "includes/ws_orders.php",
		data: ({ op: 4 }),

		dataType: 'text',
		timeout: 5000,
		success: function (data, textStatus, xhr) {

			if (data == -1)
				alert("Data couldn't be loaded!");
			else {


				var count = 0;
var newData=data;

		
			for (let i = newData.length - 1; i >= 0; i--) {
				count++;
				if (count == 3) {
					newData = newData.slice(0, i) + "." + newData.slice(i);
					count = 0;
				}


			}
		
		newData += " LL";

		if(newData.trim().startsWith(".")){
newData=newData.substring(1);
		}

		$("#cart-total-amt").text(newData);

			}
		},
		error: function (xhr, status, errorThrown) {

			console.log(status + errorThrown);
		}
	});
}


function sendOrderAndOrderDetails() {

	$("body").on("click", ".add-to-cart", function () {








		var itemid = $(this).attr("id").substring(7);
		var name = $(this).parents("div").eq(0).parents("div").eq(0).children("div").eq(0).children("p").eq(0).html();

		var uid = $(".userId").val();
		var price = $("#price_" + itemid).html();
		var qty = $("#quantity" + itemid).val();
		var priceToDouble = parseFloat(price).toFixed(3);
		var total = parseFloat(priceToDouble * qty).toFixed(3);
		var count = 0;

		if (total.length > 7) {
			for (let i = total.length - 1; i >= 0; i--) {
				count++;
				if (count == 7) {
					total = total.slice(0, i) + "." + total.slice(i);
					count = 0;
				}


			}
		}
		total += " LL";



		$.ajax({
			type: 'GET',
			url: "includes/ws_orderdetails.php",
			data: ({ op: 7, id: itemid }),
			dataType: 'text',
			timeout: 5000,
			success: function (data, textStatus, xhr) {
				$.ajax({
					type: 'GET',
					url: "includes/ws_orderdetails.php",
					data: ({ op: 1, price: price, qty: qty, total: total, itemid: itemid }),
					dataType: 'text',
					timeout: 5000,
					success: function (data, textStatus, xhr) {

						if (data == -1)
							alert("Data couldn't be loaded!");
						else {
							getCountOfItems();
											
							
						}
					},
					error: function (xhr, status, errorThrown) {

						console.log(status + errorThrown);
					}
				});


				if (data == -1) {
					alert("Data couldn't be loaded!");
				}
				else {

					if (data.trim() == "true") {
						openShoppingModal(name + " was successfully added to the cart!");
					}

					else {


						openShoppingModal(" <p style='color:red;font-weight:900;'> " + name + " is already in the cart, the quantity will be updated with a limit of 10.<p>");

					}
				}
			},
			error: function (xhr, status, errorThrown) {

				console.log(status + errorThrown);
			}
		});











		$.ajax({
			type: 'GET',
			url: "includes/ws_orders.php",
			data: ({ op: 1, uid: uid }),

			dataType: 'text',
			timeout: 5000,
			success: function (data, textStatus, xhr) {

				if (data == -1)
					alert("Data couldn't be loaded!");
				else {

				}
			},
			error: function (xhr, status, errorThrown) {

				console.log(status + errorThrown);
			}
		});












		getCountOfItems();





	})

	getCountOfItems();



}


function getCartItems() {
	$.ajax({
		type: 'GET',
		url: "includes/ws_orderdetails.php",
		data: ({ op: 2 }),

		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {

			if (data == -1)
				alert("Data couldn't be loaded!");
			else {


				data = JSON.parse(xhr.responseText);
				populateCart(data);

			}
		},
		error: function (xhr, status, errorThrown) {

			console.log(status + errorThrown);
		}
	});
}


function incrementAndDecrementInMainpage() {

	$('body').on("click", ".incrementQtyInMainpage", function () {

		var itemid = $(this).attr("id").substring(22);

		var value = $("#quantity" + itemid).val();
		var numberValue = +value;
		if (numberValue < 10) {


			$("#quantity" + itemid).val(numberValue + 1);
		}


	});


	$('body').on("click", ".decrementQtyInMainpage", function () {

		var itemid = $(this).attr("id").substring(22);

		var value = $("#quantity" + itemid).val();
		var numberValue = +value;
		if (numberValue > 1) {


			$("#quantity" + itemid).val(numberValue - 1);
		}


	})


	$('body').on("click", ".incrementQty", function () {
		var unitprice = $(this).parents("div").children('input').eq(0).val();
		var pricefloat = parseFloat(unitprice).toFixed(3);

		var itemid = $(this).attr("id").substring(12);


		var value = $("#shoppingCartQty" + itemid).val();
		var numberValue = +value;

		if (numberValue < 10) {


			var newValue = numberValue + 1;


			var total = parseFloat(newValue * pricefloat).toFixed(3);
			var count = 0;

			if (total.length > 7) {
				for (let i = total.length - 1; i >= 0; i--) {
					count++;
					if (count == 7) {
						total = total.slice(0, i) + "." + total.slice(i);
						count = 0;
					}


				}
			}
			total += " LL";




			$.ajax({
				type: 'GET',
				url: "includes/ws_orderdetails.php",
				data: ({ op: 3, id: itemid, qty: newValue, total: total }),
				dataType: 'json',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be loaded!");
					else {

						getCartItems();
						getCountOfItems();
					}
				},
				error: function (xhr, status, errorThrown) {

					console.log(status + errorThrown);
				}
			});


		}




	});


	$('body').on("click", ".decrementQty", function () {

		var unitprice = $(this).parents("div").children('input').eq(0).val();
		var pricefloat = parseFloat(unitprice).toFixed(3);

		var itemid = $(this).attr("id").substring(12);



		var value = $("#shoppingCartQty" + itemid).val();
		var numberValue = +value;

		if (numberValue > 1) {



			var newValue = numberValue - 1;


			var total = parseFloat(newValue * pricefloat).toFixed(3);
			var count = 0;

			if (total.length > 7) {
				for (let i = total.length - 1; i >= 0; i--) {
					count++;
					if (count == 7) {
						total = total.slice(0, i) + "." + total.slice(i);
						count = 0;
					}


				}
			}
			total += " LL";




			$.ajax({
				type: 'GET',
				url: "includes/ws_orderdetails.php",
				data: ({ op: 3, id: itemid, qty: newValue, total: total }),
				dataType: 'json',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be loaded!");
					else {

						getCartItems();
					}
				},
				error: function (xhr, status, errorThrown) {

					console.log(status + errorThrown);
				}
			});


		}



	});



}


function getCountOfItems() {


	$.ajax({
		type: 'GET',
		url: "includes/ws_orderdetails.php",
		data: ({ op: 5 }),
		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {

			if (data == -1)
				alert("Data couldn't be loaded!");
			else {
				$("#cart-item-count").html(data);

				if (data == 0) {
					$(".cart-container").empty();
				}
			}
		},
		error: function (xhr, status, errorThrown) {

			console.log(status + errorThrown);
		}
	});


}


function deleteFromCart() {

	$('body').on("click", ".deleteFromCart", function () {



		var id = $(this).attr("id").substring(14);
		var name = $(this).parents("div").eq(1).children("div").eq(1).children("p").html();


		$("#delete-cart-modal").modal("show");
		$("#delete-cart-text").text("Are you sure you want to remove the product " + name + " from your cart?");


		$("#yes-delete-orderdetail").on("click", function () {

			$.ajax({
				type: 'GET',
				url: "includes/ws_orderdetails.php",
				data: ({ op: 4, id: id }),
				dataType: 'json',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be loaded!");
					else {
						getCartItems(data);
						
							getCountOfItems();
						getOrderDetailsTotal();
						
					}
				},
				error: function (xhr, status, errorThrown) {

					console.log(status + errorThrown);
				}
			});
			


		});



	});
	
	getOrderDetailsTotal();

}


function placeOrder() {

	$("body").on("click", "#placeOrder", function () {

		var containsItems;
		if($(".cart-container").children().length==0){
			
			$("#order-modal").modal("show");
			$("#order-text").html("Your order is empty!");
			$("#yes-place-order").html("Close");
			$("#no-place-order").hide();
		}
		else{
			
			$("#order-text").html("Are you sure you want to place this order?");
		$("#order-modal").modal("show");

		$("#yes-place-order").on("click",function(){

			
			
			$.ajax({
				type: 'GET',
				url: "includes/ws_orders.php",
				data: ({ op: 3 }),
				dataType: 'text',
				timeout: 5000,
				success: function (data, textStatus, xhr) {
		
					if (data == -1)
						alert("Data couldn't be loaded!");
					else {			
						

						$.ajax({
							type: 'GET',
							url: "includes/ws_orders.php",
							data: ({ op: 2 }),
							dataType: 'text',
							timeout: 5000,
							success: function (data, textStatus, xhr) {
				
								if (data == -1)
									alert("Data couldn't be loaded!");
								else {
									$(".cart-container").empty();
									
								}
							},
							error: function (xhr, status, errorThrown) {
				
								console.log(status + errorThrown);
							}
						});
				
						getCartItems();

						
					}
				},
				error: function (xhr, status, errorThrown) {
		
					console.log(status + errorThrown);
				}
			});
	
	
			
			window.location.assign("http://localhost/ajax/mainpage.php");

		})


	}


		
	});


	

	




}






function getUserType() {
	var userType = $(".userType").val();
	if (userType == "admin") {
		$(".admin-buttons").css('visibility', 'visible');


	}
	else {
		$(".admin-buttons").css('visibility', 'hidden');
	}
}






function signOut(){

	$("#sign-out").click(function () {

		$.ajax({
			type: 'GET',
			url: "includes/ws_orderdetails.php",
			data: ({ op: 6 }),
			dataType: 'json',
			timeout: 5000,
			success: function (data, textStatus, xhr) {

				if (data == -1)
					alert("Data couldn't be loaded!");
				else {

				}
			},
			error: function (xhr, status, errorThrown) {

				console.log(status + errorThrown);
			}
		});

	});

}





function logIn(){
	$("#login").click(function () {

		var username = $("#username").val();
		var password = $("#password").val();

		getlogin(username, password);

	});
}











function registerUser(){
	$("body").on("click", "#register", function () {

		

		


		var username = $("#usernameRegister").val();
		var password = $("#passwordRegister").val();
		var email = $("#emailRegister").val();
		var phone = $("#phoneRegister").val();
		var utype = 1;
		var statusVal=1;





		var proceed = true;

		var nameError, passwordError, emailError, phoneError;

	


		$("#success-icon").hide();
		if ((username.trim()).length == 0 || username.length > 20) {
			nameError = "Username should be between 1 and 20 characters!";
			proceed = false;
		}
		else {
			nameError = "";
		}


		if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) //REGEX ELEMENT FOR EMAIL CHECKING
		{
			emailError = "Please enter a valid email!";
			proceed = false;
		}
		else {
			emailError = "";
		}

		var phoneStr = phone.toString();
		if (phone.length < 8 || phone.length > 8 || phone.includes(".") || !(phoneStr.startsWith("03") || phoneStr.startsWith("01") || phoneStr.startsWith("76") || phoneStr.startsWith("70") || phoneStr.startsWith("71"))) {
			phoneError = "Please enter a valid phone number!";
			proceed = false;
		}
		else {
			phoneError = "";
		}
		if (password.length < 8) {
			passwordError = "password should be 8 or more characters!";
			proceed = false;
		}

		else if (password.length > 25) {
			passwordError = "password is too long!";
			proceed = false;
		}
		else {
			passwordError = "";
		}




		

		

		


		if (proceed === false) {
			$("#usernameErrorInRegister").text(nameError);
			$("#usernameErrorInRegister").css("color","red");
			$("#passwordErrorInRegister").text(passwordError);
			$("#emailErrorInRegister").text(emailError);
			$("#phoneErrorInRegister").text(phoneError);


		}

		if (proceed === true) {


			$.ajax({
				type: 'GET',
				url: "includes/ws_users.php",
				data: ({ op: 7, uname: username, uemail: email, uphone: phone}),
				dataType: 'text',
				timeout: 5000,
				success: function (data, textStatus, xhr) {
	
					if (data == -1)
						alert("Data couldn't be added!");
					else {
						
						if(data=="usernameError"){
							
							
							nameError="This username is taken";
							$("#usernameErrorInRegister").text(nameError);
							$("#usernameErrorInRegister").css("color","red");
							
							
						}
						else{
							nameError="";
							$("#usernameErrorInRegister").text(nameError);
						}
						

						if(data=="emailError"){
							
							emailError="Email already exists!";
							$("#emailErrorInRegister").text(emailError);
						}
						else{
							emailError="";
							$("#emailErrorInRegister").text(emailError);
						}
						if(data=="phoneError"){
							
							phoneError="Phone number already exists!";
							$("#phoneErrorInRegister").text(phoneError);
							
						}
						else{
							phoneError="";
							$("#phoneErrorInRegister").text(phoneError);
							
						}
						
						
						
						if(data=="noError"){

							$.ajax({
								type: 'GET',
								url: "includes/ws_users.php",
								data: ({ op: 8, uname: username, upass: password, uemail: email, uphone: phone}),
								dataType: 'text',
								timeout: 5000,
								success: function (data, textStatus, xhr) {
				
									if (data == -1)
										alert("Data couldn't be added!");
									else {
				
										$("#success-icon").css("visibility","visible");
							$("#passwordErrorInRegister").text("");
							$("#emailErrorInRegister").text(emailError);
							$("#phoneErrorInRegister").text(phoneError);			
										 $("#success-icon").fadeIn(2000);
										 $("#usernameErrorInRegister").html("You are now ready to login!");
										 $("#usernameErrorInRegister").css("color","green");


										 setTimeout(()=>{
window.location.assign("http://localhost/ajax/index.php")
										 },2000)
				
									}
				
								},
								error: function (xhr, status, errorThrown) {
									alert(status, errorThrown);
				
								}
							});

						}
						
						
	
					}
	
				},
				error: function (xhr, status, errorThrown) {
					alert(status, errorThrown);
	
				}
			});





			

		}
	});

}


function getlogin(usrval, pwdval) {

	$.ajax({
		type: 'GET',
		url: "includes/ws_users.php",
		data: ({ op: 5, uname: usrval, upwd: pwdval }),

		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {
			if (data == -1)
				alert("Data couldn't be loaded!");

			else {
				data = JSON.parse(xhr.responseText);
				validateLogin(data);
			}
		},
		error: function (xhr, status, errorThrown) {

			alert(status + errorThrown);
		}
	});

}

function validateLogin(data) {

	if (data == false) {
		$("#wrongCredentials").text("Wrong credentials.  Try again");

	}

	else
		window.location.href = "mainpage.php";

}



function populateItems(data) {
	if (data.length > 0) {

		var item = "";
		$(".components-container").empty();
		$.each(data, function (index, row) {

			

			item = "<div class='components'>";
			item += '<input  type="hidden" class="cat' + row.item_cat_id + '" value="' + row.item_cat_id + '">';
			item += ' <input type="hidden" class="cat' + row.item_cat_id + '">';
			item += '<img id="img_' + row.item_id + '" src="' + row.item_img_path + '"  />';
			item += ' <div class="name-container">';

			item += '  <p id="name_' + row.item_id + '">' + row.item_name + '</p>  </div>';
			item += ' <div class="price-container">';
			item += ' <p id="price_' + row.item_id + '"> ' + row.item_price + ' </p> </div>';
			item += '<div class="branch-container">';
			item += '<p>Available at</p> <p id="branch_' + row.item_id + '">' + row.item_branch + ' </p><p> branches</p> </div>';

			item += '<div><button id=addItem' + row.item_id + ' class="btn btn-primary add-to-cart">Add to Cart</button>';

			item += '<button style="float:right" id="decrementQtyInMainpage' + row.item_id + '" class="decrementQtyInMainpage btn btn-link px-2"><i class="fas fa-minus"></i></button>';
			item += '<input style="float:right;color:black" readonly="readonly" id="quantity' + row.item_id + '" min="0" name="quantity" value="1" type="number" min="1" max="10" class="form-control-sm" />';
			item += ' <button style="float:right" id="incrementQtyInMainpage' + row.item_id + '" class="incrementQtyInMainpage btn btn-link px-2"><i class="fas fa-plus"></i></button></div>';


			item += "</div>";
			$(".components-container").append(item);
			

		});
	}
}

function getItems(val) {


	$.ajax({
		type: 'GET',
		url: "includes/ws_items.php",
		data: ({ op: 1, name: val }),

		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {

			if (data == -1)
				alert("Data couldn't be loaded!");
			else {


				data = JSON.parse(xhr.responseText);
				populateItems(data);

			}
		},
		error: function (xhr, status, errorThrown) {

			console.log(status + errorThrown);
		}
	});

}



function populateItemsBasedOnCategory(data) {
	if (data.length > 0) {

		$(".components-container").empty();
		var item = "";

		$.each(data, function (index, row) {
			if (row.item_status != 0) {


				item = "<div class='components'>";
				item += ' <input type="hidden" class="' + row.cat_name + '">';
				item += '<img id="img_' + row.item_id + '" src="' + row.item_img_path + '"  />';
				item += ' <div class="name-container">';
				
				item += '  <p id="name_' + row.item_id + '">' + row.item_name + '</p>  </div>';
				item += ' <div class="price-container">';
				item += '<p id="price_' + row.item_id + ' "> ' + row.item_price + ' </p> </div>';
				item += '<div class="branch-container">';
				item += '<p>Available at:</p> <p id="branch_' + row.item_id + '">' + row.item_branch + ' </p><p> branches</p> </div>';

				item += '<div><button id=addItem' + row.item_id + ' class="btn btn-primary add-to-cart">Add to Cart</button>';

				item += '<button style="float:right" id="incrementQtyInMainpage' + row.item_id + '" class="incrementQtyInMainpage btn btn-link px-2"><i class="fas fa-minus"></i></button>';
				item += '<input style="float:right;color:black" readonly="readonly" id="quantity' + row.item_id + '" min="0" name="quantity" value="1" type="number" min="1" max="10" class="form-control-sm" />';
				item += ' <button style="float:right" id="decrementQtyInMainpage' + row.item_id + '" class="incrementQtyInMainpage btn btn-link px-2"><i class="fas fa-plus"></i></button></div>';

				item += "</div>";
				$(".components-container").append(item);
			}

		});
	}
}

function getItemsBasedOnCategory(val) {


	$.ajax({
		type: 'GET',
		url: "includes/ws_items.php",
		data: ({ op: 7, name: val }),

		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {

			if (data == -1)
				alert("Data couldn't be loaded!");
			else {


				data = JSON.parse(xhr.responseText);
				populateItemsBasedOnCategory(data);

			}
		},
		error: function (xhr, status, errorThrown) {

			console.log(status + errorThrown);
		}
	});

}






function showSelectedCategoryInMainpage() {




	$("body").on("click", ".categories", function () {


		var catName = $(this).attr("id").trim();
		$("#btnCat").html(catName + " <span class='caret'></span>");
		getItemsBasedOnCategory(catName);

		$(".categories").each(function () {
			if ($(this).parents("li").hasClass("active")) {
				$(this).parents("li").removeClass("active");
			}
		});

		$(this).parents("li").addClass("active");



		$(".components").each(function () {

			cat = $(this).children("input").eq(0).hasClass(catName);
			cat ? $(this).show() : $(this).hide();

		});



	}



	)


	$("#All").click(function () {



		getItems("");
		$("#btnCat").html("All + <span class='caret'></span>");
		$(".categories").each(function () {
			if ($(this).parents("li").hasClass("active")) {
				$(this).parents("li").removeClass("active");
			}
		});

		$(this).parents("li").addClass("active");


	})
}



function searchForProductMainpage() {
	$("#searchForProductMainpage").on("keyup", function () {
		var value = $("#searchForProductMainpage").val();

		$(".components").each(function () {
			var nameVal = $(this).children("div").eq(0).children("p").eq(0).html();




			if (nameVal.startsWith(value) || nameVal.toLowerCase().startsWith(value) || value.trim() == "") {
				$(this).show();
			}
			else {
				$(this).hide();
			}
		});

	});
}

$(function () {

	


	
	logIn();
	signOut();
	registerUser();

getUserType();

	getCountOfItems();
	

	getItemsBasedOnCategory("");
	getItems("");
	searchForProductMainpage();
	showSelectedCategoryInMainpage();


	

	sendOrderAndOrderDetails();
	deleteFromCart();
	getCartItems();
	incrementAndDecrementInMainpage();

	placeOrder();

getOrderDetailsTotal();




});