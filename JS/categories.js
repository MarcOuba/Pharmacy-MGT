// CATEGORIES FUNCTIONS /////////////////////////////////

function populateTableCategories(data) {

	if (data.length > 0) {


		var item = "";
		$("#tbdoyCategories").empty();

		$.each(data, function (index, row) {

			var imgName = row.cat_status == "1" ? "enabledProduct.png" : "disabledProduct.png";
			var disableDelete=row.cat_status=="0"?true:false;

			item = "<tr>";
			item += '<td>' + row.cat_name + '</td>';
			item += '<td>' + row.cat_item_name + '</td>';
			item += "<td><img style='height:50px; width:50px;color:green;' src='./IMG/" + imgName + "' /></td>";


			item += "<td>";
			item += '<button id="editCategory' + row.cat_id + '" class="admin-button-edit-category admin-buttons btn btn-warning "><span class="glyphicon glyphicon-pencil"></span></button>';
			item += '<button id="deleteCategory' + row.cat_id + '" class="admin-button-delete-category admin-buttons btn btn-danger "><span class="glyphicon glyphicon-trash"></span></button>';

			item += '</td>'
			item += "</tr>";
			$("#tbodyCategories").append(item);
			
			disableDelete?$("#deleteCategory"+row.cat_id).hide():$("#deleteCategory"+row.cat_id).show();
			

		});
	}
}


function searchByCategoryName(){

 
        $("#searchByNameCategories").on("keyup", function () {
            var value = $("#searchByNameCategories").val();
    
            $("tbody tr").each(function () {
                var nameVal = $(this).children("td").eq(0).html();
                lowerName=nameVal.toLowerCase();
    
    
                if (lowerName.startsWith(value) || value.trim() == "") {
                    $(this).show();
                }
                else {
                    $(this).hide();
                }
            });
    
        });
    
}


function getCategories() {


	$.ajax({
		type: 'GET',
		url: "includes/ws_categories.php",
		data: ({ op: 1 }),

		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {

			if (data == -1)
				alert("Data couldn't be loaded!");
			else {


				data = JSON.parse(xhr.responseText);
				populateTableCategories(data);

			}
		},
		error: function (xhr, status, errorThrown) {

			alert(status + errorThrown);
		}
	});

}












function addCategory() {
	$("body").on("click", "#modal-add-category-btn", function () {


		var name = $("#add-category-name").val();
		var proceed = true;
		var nameError = "";

		if (name.length > 26 || name.length < 2) {
			nameError = "Enter a valid name";
			proceed = false;
		}
		else {
			nameError = "";
		}



		$('#table-categories > tbody  > tr').each(function () {
			var nameVal = $(this).children("td").eq(1).html();


			if (name.trim() == nameVal.trim()) {

				proceed = false;
				nameError = "Name already exists!";
			}


		});

		if (proceed == false) {

			$("#add-cat-name-error").text(nameError);

		}

		if (proceed == true) {

			$.ajax({
				type: 'GET',
				url: "includes/ws_categories.php",
				data: ({ op: 2, name: name }),

				dataType: 'text',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be loaded!");
					else {

						$("#tbodyCategories").empty();
						getCategories();
						$("#add-category-modal").modal("hide");


					}
				},
				error: function (xhr, status, errorThrown) {

					alert(status + errorThrown);
				}
			});

		}

	});

}


function updateCategoryID() {

	$("body").on("click", ".admin-button-edit-category", function () {


		var name = $(this).parents("tr").children("td").eq(0).html();
		$("#category-name-edit").attr("value", name);




		$("#update-category-modal").modal('show');
		var wholeID = $(this).attr("id");
		var numberID = wholeID.substring(12);
		$("#getIdUpdateOfCategory").val(numberID);

	});
}


function updateCategory() {

	$("body").on("click", "#btn-update-category", function () {
		var name = $("#category-name-edit").val();

		var id = $("#getIdUpdateOfCategory").val();

		var proceed = true;
		var nameError = "";

		if (name.length > 26 || name.length < 2) {
			nameError = "Enter a valid name";
			proceed = false;
		}
		else {
			nameError = "";
		}




		if (proceed == false) {

			$("#edit-cat-name-error").text(nameError);
		}

		if (proceed == true) {

			$.ajax({
				type: 'GET',
				url: "includes/ws_categories.php",
				data: ({ op: 3, id: id, name: name }),
				dataType: 'text',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be added!");
					else {
						$("#tbodyCategories").empty();
						getCategories();
						$("#update-category-modal").modal("hide");

					}

				},
				error: function (xhr, status, errorThrown) {
					alert(status, errorThrown);

				}
			});

		}
	});

}


function deleteCategoryID() {

	$("body").on("click", ".admin-button-delete-category", function () {



		var name = $(this).parents("tr").children("td").eq(0).html();
		$("#delete-category-modal-title").html("Are you sure you want to temporary deactivate <strong style='color:red;'>All</strong> the items inside the category " + name + " ?");
		$("#delete-category-modal").modal('show');

		var items = $(this).parents("tr").children("td").eq(1).html();

		$("#getIdDeleteOfCategory").val(items);

		var itemsArray = $("#getIdDeleteOfCategory").val().split(',');


	});
}


function deleteCategory() {

	$("body").on("click", "#yes-delete-category", function () {

		var itemsArray = $("#getIdDeleteOfCategory").val().split(',');












		$.ajax({
			type: 'GET',
			url: "includes/ws_categories.php",
			data: ({ op: 4, items: itemsArray }),
			dataType: 'text',
			timeout: 5000,
			success: function (data, textStatus, xhr) {

				if (data == -1)
					alert("Data couldn't be added!");
				else {
					$("#tbodyCategories").empty();
					getCategories();
					$("#delete-category-modal").modal("hide");

				}

			},
			error: function (xhr, status, errorThrown) {
				alert(status, errorThrown);

			}
		});

	}
	);

}



function categoriesShowOptionsDropdown() {

	$("body").on("click", ".categories", function () {
		id = $(this).attr("id");

		switch (id) {
			///////////
			case "showAllCategories":

				$(".categories").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});

				$('#table-categories > tbody  > tr').each(function () {

					$(this).show();

				});


				$("#showAllCategories").parents("li").addClass("active");
				$("#btnCategories").html("Show all categories <span class='caret'></span>");

				break;
			//////////

			case "showActiveCategories":
				$(".categories").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});
				$("#showActiveCategories").parents("li").addClass("active");

				$('#table-categories > tbody  > tr').each(function () {
					var statusVal = $(this).children("td").eq(2).children('img').attr('src');


					if (statusVal == "./IMG/enabledProduct.png") {

						$(this).show();
					}
					else {
						$(this).hide();
					}


				});



				$("#btnCategories").html("Show enabled categories <span class='caret'></span>");
				break;

			case "showInactiveCategories":
				$(".categories").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});
				$("#showInactiveCategories").parents("li").addClass("active");

				$('#table-categories > tbody  > tr').each(function () {
					var statusVal = $(this).children("td").eq(2).children('img').attr('src');


					if (statusVal == "./IMG/disabledProduct.png") {

						$(this).show();
					}
					else {
						$(this).hide();
					}


				});



				$("#btnCategories").html("Show disabled categories <span class='caret'></span>");
				break;





		}

	});
}


$(function () {



searchByCategoryName();
	deleteCategoryID();
	deleteCategory();
	updateCategoryID();
	updateCategory();
	addCategory();
	categoriesShowOptionsDropdown();
	getCategories();

	



	







});