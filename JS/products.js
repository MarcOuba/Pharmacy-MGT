


function populateTableProducts(data) {

	if (data.length > 0) {




		var item = "";
		$("#tbdoyProducts").empty();

		$.each(data, function (index, row) {


            var disable=row.item_status=="1"?true:false;

			var imgName = row.item_status == "1" ? "enabledProduct.png" : "disabledProduct.png";
			var disabled=row.item_status=="1"?true:false;
			var disableDelete=row.item_status=="0"?true:false;

			var name1="deleteProduct" + row.item_id;
			var name2="activateItem" + row.item_id;

			item = "<tr>";
			item += '<td>' + row.item_name + '</td>';
			item += '<td>' + row.item_price + '</td>';
			item += '<td>' + row.item_branch + '</td>';
			item += '<td id="cat' + index + '">' + row.item_img_path + '</td>';
			item += '<td>' + row.cat_name + '</td>';
			item += "<td><img style='height:50px; width:50px;color:green;' src='./IMG/" + imgName + "' /></td>";

			item += "<td>";
			item += '<button id="editProduct' + row.item_id + '" class="admin-button-edit admin-buttons btn btn-warning "><span class="glyphicon glyphicon-pencil"></span></button>';
			item += '<button id="deleteProduct' + row.item_id + '" class="admin-button-delete admin-buttons btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
			item += '<button  type="button"  class="btn-activateItem btn btn-success" id="activateItem' + row.item_id + '">Activate</button>'
			item += '</td>'
			item += "</tr>";
			$("#tbodyProducts").append(item);

		if(disable){
$("#deleteProduct"+row.item_id).show();
$("#activateItem"+row.item_id).hide();
        }
        else{

            $("#deleteProduct"+row.item_id).hide();
$("activateItem"+row.item_id).show();

        }
			

		});
	}
}


function getProducts(val) {


	$.ajax({
		type: 'GET',
		url: "includes/ws_items.php",
		data: ({ op: 2, name: val }),

		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {

			if (data == -1)
				alert("Data couldn't be loaded!");
			else {


				data = JSON.parse(xhr.responseText);
				populateTableProducts(data);

			}
		},
		error: function (xhr, status, errorThrown) {

			alert(status + errorThrown);
		}
	});

}

function getIDdeleteProduct() {
	$("body").on("click", ".admin-button-delete", function () {


		var itemName = $(this).parents("tr").children("td").eq(0).html();
		$("#delete-product-text").html("Are you sure you want to temporary delete the item with the name of " + itemName + " ?");
		$("#delete-product-modal").modal('show');
		var wholeID = $(this).attr("id");
		var ID = wholeID.substring(13);
		$("#getIdDeleteOfProduct").val(ID);


	});
}



function changeProductStatus() {
	$("#yes-delete-product").click(function () {

		var idDel = $("#getIdDeleteOfProduct").val();


		$.ajax({
			type: 'GET',
			url: "includes/ws_items.php",
			data: ({ op: 3, id: idDel }),
			dataType: 'text',
			timeout: 5000,
			success: function (data, textStatus, xhr) {

				if (data == -1)
					alert("Data couldn't be deleted!");
				else {
					$("#tbodyProducts").empty();
					getProducts("");
				}

			},
			error: function (xhr, status, errorThrown) {
				alert(status, errorThrown);

			}
		});


	});
}


function updateProductID() {

	$("body").on("click", ".admin-button-edit", function () {


		var img = $(this).parents("tr").children("td").eq(3).html();
		$("#product-img-edit").attr("value", img);
		var name = $(this).parents("tr").children("td").eq(0).html();
		$("#product-name-edit").attr("value", name);
		var price = $(this).parents("tr").children("td").eq(1).html();
		$("#product-price-edit").attr("value", price);

		var branch = $(this).parents("tr").children("td").eq(2).html();

		var j = 0;
		var arr = [];
		arr[j] = "";
		for (let i = 0; i < branch.length; i++) {


			if (branch[i] == ",") {
				j++;
				arr[j] = "";
			}
			else {
				arr[j] += branch[i];
			}
		}
		for (let i = 0; i < arr.length; i++) {
			var name = arr[i].trim();
			name += "Edit";
			$("#" + name).prop("checked", true);
		}

		var category = $(this).parents("tr").children("td").eq(4).html();

		$("input[type='radio'][name='categoryEdit']").each(function () {
			if ($(this).attr("id") == category) {
				$(this).prop("checked", true);
			};
		})


		var status = $(this).parents("tr").children("td").eq(5).children('img').attr('src');

		status == "./IMG/enabledProduct.png" ? $("#activeProductEdit").prop("checked", true) : $("#inactiveProductEdit").prop("checked", true);



		$("#update-product-modal").modal('show');
		var wholeID = $(this).attr("id");
		var numberID = wholeID.substring(11);
		$("#getIdUpdateOfProduct").val(numberID);

	});
}




function updateProduct() {
	$("body").on("click", "#btn-update-product", function () {
		var name = $("#product-name-edit").val();
		var img = $("#product-img-edit").val();
		var price = $("#product-price-edit").val();
		var id = $("#getIdUpdateOfProduct").val();

		var branch = $(".checkbox-edit-products:checkbox:checked").map(function () {
			return this.value;
		}).get().join(', ');


		var status = $("input[type='radio'][name='statusEdit']:checked").val();
		var statusVal = status == "Active" ? "1" : "0";


		var category = $("input[type='radio'][name='categoryEdit']:checked").val();


		var nameError, imgError, priceError = "";
		var proceed = true;



		if ((name.trim()).length == 0) {
			nameError = "Name cannot be empty!";
			proceed = false;
		}
		else {
			nameError = "";
		}



		if (!(img.startsWith("./IMG/"))) {
			imgError = "Image should start with the path ./IMG/";
			proceed = false;
		}
		else {
			imgError = "";
		}

		priceTrim = price.trim();
		var first7digits = priceTrim.substring(0, (priceTrim.length) - 2);
		var floatNumb = parseFloat(first7digits).toFixed(3);


		if (priceTrim.length < 8 || priceTrim.length > 14 || price.includes(",") || isNaN(floatNumb) || !(priceTrim.includes("LL") || priceTrim.includes("$"))) {
			priceError = "Please enter a valid price like 200.000 LL";
			proceed = false;
		}
		else {
			priceError = "";
		}









		if (proceed === false) {
			$("#edit-product-name-error").text(nameError);
			$("#edit-product-img-error").text(imgError);
			$("#edit-product-price-error").text(priceError);


		}
		if (proceed === true) {


			$("#update-product-modal").modal('hide');

			$.ajax({
				type: 'GET',
				url: "includes/ws_items.php",
				data: ({ op: 4, id: id, name: name, img: img, price: price, cat: category, branch: branch, status: statusVal }),
				dataType: 'text',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be updated!");
					else {
						$("#tbodyProducts").empty();
						getProducts("");

					}

				},
				error: function (xhr, status, errorThrown) {
					alert(status, errorThrown);

				}
			});


		}
	});

}




function addProduct() {

	$("#modal-add-product-btn").click(function () {

		var name = $("#product-name").val();
		var img = $("#product-img-src").val();
		var price = $("#product-price").val();


		var branch = $("input[type=checkbox]:checked").map(function () {
			return this.value;
		}).get().join(', ');





		var status = $("input[type='radio'][name='status']:checked").val();
		var statusVal = status == "Active" ? "1" : "0";

		var category = $("input[type='radio'][name='category']:checked").val();


		var nameError, imgError, priceError = "";
		var proceed = true;



		if ((name.trim()).length == 0) {
			nameError = "Name cannot be empty!";
			proceed = false;
		}
		else {
			nameError = "";
		}



		if (!(img.startsWith("./IMG/"))) {
			imgError = "Image should start with the path ./IMG/";
			proceed = false;
		}
		else {
			imgError = "";
		}

		priceTrim = price.trim();
		var first7digits = priceTrim.substring(0, (priceTrim.length) - 2);
		var floatNumb = parseFloat(first7digits).toFixed(3);


		if (priceTrim.length < 8 || priceTrim.length > 14 || price.includes(",") || isNaN(floatNumb) || !(priceTrim.includes("LL") || priceTrim.includes("$"))) {
			priceError = "Please enter a valid price like 200.000 LL";
			proceed = false;
		}
		else {
			priceError = "";
		}







		$('#table-products > tbody  > tr').each(function () {
			var nameVal = $(this).children("td").eq(0).html();


			if (name.trim() == nameVal.trim()) {

				proceed = false;
				nameError = "Name already exists!";
			}


		});

		if (proceed === false) {
			$("#add-product-name-error").text(nameError);
			$("#add-product-img-error").text(imgError);
			$("#add-product-price-error").text(priceError);
			$("#add-product-status-error").text(statusError);



		}
		if (proceed === true) {


			$.ajax({
				type: 'GET',
				url: "includes/ws_items.php",
				data: ({ op: 5, name: name, img: img, price: price, cat: category, branch: branch, status: statusVal }),
				dataType: 'text',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be added!");
					else {
						$("#tbodyProducts").empty();
						getProducts("");
						$("#add-product-modal").modal("hide");

					}

				},
				error: function (xhr, status, errorThrown) {
					alert(status, errorThrown);

				}
			});
		}
	});

}






function searchByNameProducts() {
	$("#searchByName").on("keyup", function () {
		var value = $("#searchByName").val();

		$("tbody tr").each(function () {
			var Val = $(this).children("td").eq(0).html();
			var nameVal = Val.toLowerCase();


			if (nameVal.startsWith(value) || Val.startsWith(value) || value.trim() == "") {
				$(this).show();
			}
			else {
				$(this).hide();
			}
		});

	});
}



function getIDActivateItem() {
	$("body").on("click", ".btn-activateItem", function () {


		var itemName = $(this).parents("tr").children("td").eq(0).html();
		$("#activate-text-item").html("Are you sure you want to activate the item with the name of " + itemName + " ?");
		$("#activate-modal-item").modal('show');
		var wholeID = $(this).attr("id");
		var numberID = wholeID.substring(12);
		$("#getIdActivateItem").val(numberID);

	});
}

function activateItem() {
	$("#yes-activate-item").click(function () {




		var idDel = $("#getIdActivateItem").val();


		$.ajax({
			type: 'GET',
			url: "includes/ws_items.php",
			data: ({ op: 6, idActivate: idDel }),
			dataType: 'text',
			timeout: 5000,
			success: function (data, textStatus, xhr) {

				if (data == -1)
					alert("Data couldn't be activated!");
				else {
					$("#tbodyProducts").empty();
					getProducts("");
				}

			},
			error: function (xhr, status, errorThrown) {
				alert(status, errorThrown);

			}
		});

	});

}






function productsShowOptions() {

	$("body").on("click", ".products", function () {
		id = $(this).attr("id");

		switch (id) {
			///////////
			case "showAllProducts":

				$(".products").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});

				$('#table-products > tbody  > tr').each(function () {

					var title = $("#btnCategoriesInProductsPage").html();
					var newTitle = title.substring(0, title.indexOf("<")).trim();
					var catName = $(this).children("td").eq(4).html();

					if (newTitle == 'Show all categories') {
						$(this).show();
					}

					else {
						if (title == catName) {
							$(this).show();
						}
						else {
							$(this).hide();
						}
					}

				});


				$("#showAllProducts").parents("li").addClass("active");
				$("#btnProducts").html("Show all products <span class='caret'></span>");

				break;
			//////////

			case "showActiveProducts":
				$(".products").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});
				$("#showActiveProducts").parents("li").addClass("active");

				$('#table-products > tbody  > tr').each(function () {
					var statusVal = $(this).children("td").eq(5).children('img').attr('src');
					var catName = $(this).children("td").eq(4).html();
					var title = $("#btnCategoriesInProductsPage").html();
					var newTitle = title.substring(0, title.indexOf("<")).trim();


					if (newTitle == 'Show all categories' && statusVal == "./IMG/enabledProduct.png") {
						$(this).show();
					}
					else {


						if (statusVal == "./IMG/enabledProduct.png" && title == catName) {

							$(this).show();
						}
						else {
							$(this).hide();
						}

					}
				});



				$("#btnProducts").html("Show enabled products <span class='caret'></span>");
				break;

			case "showInactiveProducts":
				$(".products").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});
				$("#showInactiveProducts").parents("li").addClass("active");

				$('#table-products > tbody  > tr').each(function () {
					var statusVal = $(this).children("td").eq(5).children('img').attr('src');
					var catName = $(this).children("td").eq(4).html();
					var title = $("#btnCategoriesInProductsPage").html();
					var newTitle = title.substring(0, title.indexOf("<")).trim();


					if (newTitle == 'Show all categories' && statusVal == "./IMG/disabledProduct.png") {
						$(this).show();
					}
					else {


						if (statusVal == "./IMG/disabledProduct.png" && title == catName) {

							$(this).show();
						}
						else {
							$(this).hide();
						}

					}

				});



				$("#btnProducts").html("Show disabled products <span class='caret'></span>");
				break;




		}

	});
}

function sortByPrice(n) {
	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	table = document.getElementById("table-products");
	switching = true;
	// Set the sorting direction to ascending:
	dir = "asc";
	/* Make a loop that will continue until
	no switching has been done: */
	while (switching) {
		// Start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/* Loop through all table rows (except the
		first, which contains table headers): */
		for (i = 1; i < (rows.length - 1); i++) {
			// Start by saying there should be no switching:
			shouldSwitch = false;
			/* Get the two elements you want to compare,
			one from current row and one from the next: */
			x = rows[i].getElementsByTagName("TD")[n];
			y = rows[i + 1].getElementsByTagName("TD")[n];

			/* Check if the two rows should switch place,
			based on the direction, asc or desc: */
			if (dir == "asc") {
				var firstRowPrice = x.innerHTML;
				var floatPriceRow1 = parseFloat(firstRowPrice);

				var secondRowPrice = y.innerHTML;
				var floatPriceRow2 = parseFloat(secondRowPrice);



				if (floatPriceRow1 > floatPriceRow2) {
					// If so, mark as a switch and break the loop:
					shouldSwitch = true;
					break;
				}
			} else if (dir == "desc") {

				var firstRowPrice = x.innerHTML;
				var floatPriceRow1 = parseFloat(firstRowPrice);

				var secondRowPrice = y.innerHTML;
				var floatPriceRow2 = parseFloat(secondRowPrice);

				if (floatPriceRow1 < floatPriceRow2) {
					// If so, mark as a switch and break the loop:
					shouldSwitch = true;
					break;
				}
			}
		}
		if (shouldSwitch) {
			/* If a switch has been marked, make the switch
			and mark that a switch has been done: */
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
			// Each time a switch is done, increase this count by 1:
			switchcount++;
		} else {
			/* If no switching has been done AND the direction is "asc",
			set the direction to "desc" and run the while loop again. */
			if (switchcount == 0 && dir == "asc") {
				dir = "desc";
				switching = true;
			}
		}
	}
}


function sortTableProducts(n) {
	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	table = document.getElementById("table-products");
	switching = true;
	// Set the sorting direction to ascending:
	dir = "asc";
	/* Make a loop that will continue until
	no switching has been done: */
	while (switching) {
		// Start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/* Loop through all table rows (except the
		first, which contains table headers): */
		for (i = 1; i < (rows.length - 1); i++) {
			// Start by saying there should be no switching:
			shouldSwitch = false;
			/* Get the two elements you want to compare,
			one from current row and one from the next: */
			x = rows[i].getElementsByTagName("TD")[n];
			y = rows[i + 1].getElementsByTagName("TD")[n];
			/* Check if the two rows should switch place,
			based on the direction, asc or desc: */
			if (dir == "asc") {
				if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
					// If so, mark as a switch and break the loop:
					shouldSwitch = true;
					break;
				}
			} else if (dir == "desc") {
				if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
					// If so, mark as a switch and break the loop:
					shouldSwitch = true;
					break;
				}
			}
		}
		if (shouldSwitch) {
			/* If a switch has been marked, make the switch
			and mark that a switch has been done: */
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
			// Each time a switch is done, increase this count by 1:
			switchcount++;
		} else {
			/* If no switching has been done AND the direction is "asc",
			set the direction to "desc" and run the while loop again. */
			if (switchcount == 0 && dir == "asc") {
				dir = "desc";
				switching = true;
			}
		}
	}
}


function showCategoriesInProductsPage() {

	$("#allCatLinkInProductsPage").on("click", function () {
		$(".categoriesInProductsPage").parents("li").removeClass("active");
		$("#allCatLinkInProductsPage").parents("li").addClass("active");

		var title = $("#btnProducts").html();
		var newTitle = title.substring(0, title.indexOf("<")).trim();

		$("#btnCategoriesInProductsPage").html("Show all categories <span class='caret'></span>");

		$("tbody tr").each(function () {
			var statusVal = $(this).children("td").eq(5).children('img').attr('src');

			if (newTitle == "Show all products") {
				$(this).show();

			}
			else if (newTitle == "Show enabled products") {
				if (statusVal == "./IMG/enabledProduct.png") {
					$(this).show();
				}
				else {
					$(this).hide();
				}
			}

			else {
				if (statusVal == "./IMG/disabledProduct.png") {
					$(this).show();
				}
				else {
					$(this).hide();
				}
			}


		});

	})

	$(".categoriesInProductsPage").on("click", function () {



		$("#allCatLinkInProductsPage").parents("li").removeClass("active");
		$(".categoriesInProductsPage").parents("li").removeClass("active");
		$(this).parents("li").addClass("active");
		var catName = $(this).html();
		var trimmedCatName = catName.trim();

		var title = $("#btnProducts").html();
		var newTitle = title.substring(0, title.indexOf("<")).trim();

		$("#btnCategoriesInProductsPage").html(trimmedCatName);


		$("tbody tr").each(function () {
			var nameInTable = $(this).children("td").eq(4).html();
			var statusVal = $(this).children("td").eq(5).children('img').attr('src');

			if (newTitle == "Show all products") {
				if (nameInTable == trimmedCatName) {
					$(this).show();
				}
				else {
					$(this).hide();
				}
			}
			else if (newTitle == "Show enabled products") {
				if (nameInTable == trimmedCatName && statusVal == "./IMG/enabledProduct.png") {
					$(this).show();
				}
				else {
					$(this).hide();
				}
			}

			else {
				if (nameInTable == trimmedCatName && statusVal == "./IMG/disabledProduct.png") {
					$(this).show();
				}
				else {
					$(this).hide();
				}
			}
		});

	})
}


$(function () {

	


	

    getIDdeleteProduct();
	changeProductStatus();
	updateProductID();
	updateProduct();
	addProduct();
	productsShowOptions();
	getIDActivateItem();
	activateItem();
	searchByNameProducts();
changeProductStatus();
	showCategoriesInProductsPage();
	getProducts("");




	

	


});