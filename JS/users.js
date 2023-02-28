
function insertUser() {




	$("body").on("click", "#btn-add", function () {

		var status = $("input[type='radio'][name='status']:checked").val();

		var statusVal = status == "Active" ? "1" : "0";


		var username = $("#username-input-add").val();
		var password = $("#password-input-add").val();
		var email = $("#email-input-add").val();
		var phone = $("#phoneNumber-input-add").val();
		var utype = $("input[type='radio'][name='u_type']:checked").val();



		var proceed = true;

		var nameError, passwordError, emailError, phoneError;



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
		if (phone.length < 8 || phone.length > 26 || phone.includes(".") || !(phoneStr.startsWith("03") || phoneStr.startsWith("70") || phoneStr.startsWith("01") || phoneStr.startsWith("71"))) {
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

		else if (password.length > 15) {
			passwordError = "password is too long!";
			proceed = false;
		}
		else {
			passwordError = "";
		}





		$('#table-users > tbody  > tr').each(function () {
			var usernameVal = $(this).children("td").eq(0).html();
			var emailVal = $(this).children("td").eq(1).html();
			var phoneVal = $(this).children("td").eq(2).html();

			if (username.trim() == usernameVal.trim()) {

				proceed = false;
				nameError = "Username already exists!";

			}
			if (emailVal.trim() == email.trim()) {
				proceed = false;
				emailError = "Email already exists!";
			}
			if (phoneVal.trim() == phone.trim()) {

				proceed = false;
				phoneError = "Phone already exists!";
			}

		});


		if (proceed === false) {
			$("#add-user-name-error").text(nameError);
			$("#add-user-password-error").text(passwordError);
			$("#add-user-email-error").text(emailError);
			$("#add-user-phone-error").text(phoneError);


		}

		if (proceed === true) {

			$.ajax({
				type: 'GET',
				url: "includes/ws_users.php",
				data: ({ op: 3, uname: username, upass: password, uemail: email, uphone: phone, utype: utype, ustatus: statusVal }),
				dataType: 'text',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be added!");
					else {
						$("#tbodyUsers").empty();
						getUsers("");
						console.log("success");
						$("#add-modal").modal("hide");

					}

				},
				error: function (xhr, status, errorThrown) {
					alert(status, errorThrown);

				}
			});

		}
	});

}












function updateUserID() {

	$("body").on("click", ".btn-update", function () {

		var username = $(this).parents("tr").children("td").eq(0).html();
		$("#username-input").attr("value", username);
		var email = $(this).parents("tr").children("td").eq(1).html();
		$("#email-input").attr("value", email);
		var phoneNumber = $(this).parents("tr").children("td").eq(2).html();
		$("#phoneNumber-input").attr("value", phoneNumber);


		
		var wholeID = $(this).attr("id");
		var numberID = wholeID.substring(6);
		$("#getIdUpdate").val(numberID);
        $("#update-modal").modal('show');
	});
}


function updateUser() {


	$("body").on("click", "#btn-update", function () {


		var username = $("#username-input").val();
		var email = $("#email-input").val();
		var phone = $("#phoneNumber-input").val();
		var utype = $("input[type='radio'][name='u_type-edit']:checked").val();

		var idUp = $("#getIdUpdate").val();
		var proceed = true;

		var nameError, emailError, phoneError = "";

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
		if (phone.length < 8 || phone.length > 8 || phone.includes(".") || !(phoneStr.startsWith("03") || phoneStr.startsWith("70") || phoneStr.startsWith("76") || phoneStr.startsWith("71"))) {
			phoneError = "Please enter a valid phone number!";
			proceed = false;
		}
		else {
			phoneError = "";
		}







		if (proceed === false) {
			$("#edit-user-name-error").text(nameError);
			$("#edit-user-email-error").text(emailError);
			$("#edit-user-phone-error").text(phoneError);




		}


		if (proceed === true) {



			$("#update-modal").modal('hide');

			$.ajax({
				type: 'GET',
				url: "includes/ws_users.php",
				data: ({ op: 2, id: idUp, uname: username, uemail: email, uphone: phone, utype: utype }),
				dataType: 'text',
				timeout: 5000,
				success: function (data, textStatus, xhr) {

					if (data == -1)
						alert("Data couldn't be updated!");
					else {
						$("#tbodyUsers").empty();
						getUsers("");
                        

					}

				},
				error: function (xhr, status, errorThrown) {
					alert(status, errorThrown);

				}
			});

		}
	});
}


function getIDActivateUser() {
	$("body").on("click", ".btn-activate", function () {


		var username = $(this).parents("tr").children("td").eq(0).html();
		$("#activate-text").html("Are you sure you want to activate the user with the username of " + username + " ?");
		$("#activate-modal").modal('show');
		var wholeID = $(this).attr("id");
		var numberID = wholeID.substring(8);
		$("#getIdActivate").val(numberID);

	});
}

function activateUser() {
	$("#yes-activate").click(function () {




		var idDel = $("#getIdActivate").val();


		$.ajax({
			type: 'GET',
			url: "includes/ws_users.php",
			data: ({ op: 6, idActivate: idDel }),
			dataType: 'text',
			timeout: 5000,
			success: function (data, textStatus, xhr) {

				if (data == -1)
					alert("Data couldn't be activated!");
				else {
					$("#tbodyUsers").empty();
					getUsers("");
				}

			},
			error: function (xhr, status, errorThrown) {
				alert(status, errorThrown);

			}
		});

	});

}




function getIDdeleteUser() {
	$("body").on("click", ".btn-delete", function () {


		var username = $(this).parents("tr").children("td").eq(0).html();
		$("#delete-text").html("Are you sure you want to temporary delete the user with the username of " + username + " ?");
		$("#delete-modal").modal('show');
		var ID = $(this).attr("id");
		$("#getIdDelete").val(ID);

	});
}

function changeUserStatus() {


	$("#yes-delete").click(function () {

		var idDel = $("#getIdDelete").val();




		$.ajax({
			type: 'GET',
			url: "includes/ws_users.php",
			data: ({ op: 1, id: idDel }),
			dataType: 'text',
			timeout: 5000,
			success: function (data, textStatus, xhr) {

				if (data == -1)
					alert("Data couldn't be deleted!");
				else {
					$("#tbodyUsers").empty();
					getUsers("");
				}

			},
			error: function (xhr, status, errorThrown) {
				alert(status, errorThrown);

			}
		});



	});
}




function populateUsers(data) {
	if (data.length > 0) {

		var item = "";
		$("#tbdoy").empty();

		$.each(data, function (index, row) {
			var imgName = row.u_status == "1" ? "active.png" : "inactive.png";
			
			var enabled=row.u_status=="1"?true:false;
            

			item = "<tr>";
			item += "<td>" + row.u_username + "</td>";
			item += "<td>" + row.u_email + "</td>";
			item += "<td>" + row.u_phone + "</td>";
			item += "<td>" + row.u_type + "</td>";
			item += "<td><img style='height:50px; width:50px;color:green;' src='./IMG/" + imgName + "' /></td>";
			item += "<td>";
			item += '<button  type="button" class="btn-update btn btn-warning" id="update' + row.u_id + '"><span class="glyphicon glyphicon-pencil"></span></button>';
			item += '<button  type="button"  class="btn-delete btn btn-danger" id="' + row.u_id + '"><span class="glyphicon glyphicon-trash"></span></button>'
			item += '<button  type="button"  class="btn-activate btn btn-success" id="activate' + row.u_id + '">Activate</button>'
			item += '</td>'
			item += "</tr>";
			
			$("#tbodyUsers").append(item);

            if(enabled){
                $("#"+row.u_id).show();
$("#activate"+row.u_id).hide();
            }
            else{
                $("#"+row.u_id).hide();
                $("#activate"+row.u_id).show();
            }
		

		});
	}

}


function getUsers(val) {


	$.ajax({
		type: 'GET',
		url: "includes/ws_users.php",
		data: ({ op: 4, name: val }),

		dataType: 'json',
		timeout: 5000,
		success: function (data, textStatus, xhr) {

			if (data == -1)
				alert("Data couldn't be loaded!");
			else {


				data = JSON.parse(xhr.responseText);
				populateUsers(data);

			}
		},
		error: function (xhr, status, errorThrown) {

			alert(status + errorThrown);
		}
	});

}







function searchByUsername() {
	$("#search").on("keyup", function () {
		var value = $("#search").val();

		$("tbody tr").each(function () {
			var usernameVal = $(this).children("td").eq(0).html();


			if (usernameVal.startsWith(value) || value.trim() == "") {
				$(this).show();
			}
			else {
				$(this).hide();
			}
		});

	});
}

function searchByEmail() {
	$("#search").on("keyup", function () {
		var value = $("#search").val();

		$("tbody tr").each(function () {
			var emailVal = $(this).children("td").eq(1).html();


			if (emailVal.startsWith(value) || value.trim() == "") {
				$(this).show();
			}
			else {
				$(this).hide();
			}
		});

	});
}

function searchByPhone() {
	$("#search").on("keyup", function () {
		var value = $("#search").val();

		$("tbody tr").each(function () {
			var phoneVal = $(this).children("td").eq(2).html();


			if (phoneVal.startsWith(value) || value.trim() == "") {
				$(this).show();
			}
			else {
				$(this).hide();
			}
		});

	});
}




function usersShowSearchOptions() {

	$("body").on("click", ".searchUsers", function () {
		id = $(this).attr("id");

		switch (id) {
			///////////
			case "searchByUsername":


				$("tbody tr").each(function () {

					$(this).show();

				});

				$(".searchUsers").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});

				searchByUsername();


				$("#searchByUsername").parents("li").addClass("active");
				$("#btnSearchUsers").html("Search by username <span class='caret'></span>");
				$("#search").attr("placeholder", "Search by username");
				$("#search").val("");

				break;
			//////////

			case "searchByEmail":

				$("tbody tr").each(function () {

					$(this).show();

				});



				$(".searchUsers").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});

				searchByEmail();


				$("#searchByEmail").parents("li").addClass("active");
				$("#btnSearchUsers").html("Search by email <span class='caret'></span>");
				$("#search").attr("placeholder", "Search by email");
				$("#search").val("");

				break;

			case "searchByPhone":

				$("tbody tr").each(function () {

					$(this).show();

				});


				$(".searchUsers").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});

				searchByPhone();


				$("#searchByPhone").parents("li").addClass("active");
				$("#btnSearchUsers").html("Search by phone <span class='caret'></span>");
				$("#search").attr("placeholder", "Search by phone");
				$("#search").val("");
				break;





		}

	});
}




function sortTableUsers(n) {
	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	table = document.getElementById("table-users");
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





function usersShowOptions() {

	$("body").on("click", ".users", function () {
		id = $(this).attr("id");

		switch (id) {
			///////////
			case "showAllUsers":

				$(".users").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});

				$('#table-users > tbody  > tr').each(function () {

					$(this).show();

				});


				$("#showAllUsers").parents("li").addClass("active");
				$("#btnUsers").html("Show all users <span class='caret'></span>");

				break;
			//////////

			case "showActiveUsers":
				$(".users").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});
				$("#showActiveUsers").parents("li").addClass("active");

				$('#table-users > tbody  > tr').each(function () {
					var statusVal = $(this).children("td").eq(4).children('img').attr('src');


					if (statusVal == "./IMG/active.png") {

						$(this).show();
					}
					else {
						$(this).hide();
					}


				});



				$("#btnUsers").html("Show active users <span class='caret'></span>");
				break;

			case "showInactiveUsers":
				$(".users").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});
				$("#showInactiveUsers").parents("li").addClass("active");

				$('#table-users > tbody  > tr').each(function () {
					var statusVal = $(this).children("td").eq(4).children('img').attr('src');


					if (statusVal == "./IMG/active.png") {

						$(this).hide();
					}
					else {
						$(this).show();
					}


				});



				$("#btnUsers").html("Show inactive users <span class='caret'></span>");
				break;

			case "showAdmins":

				$(".users").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});
				$("#showAdmins").parents("li").addClass("active");

				$('#table-users > tbody  > tr').each(function () {
					var typeVal = $(this).children("td").eq(3).html();


					if (typeVal == "admin") {

						$(this).show();
					}
					else {
						$(this).hide();
					}


				});



				$("#btnUsers").html("Show admins <span class='caret'></span>");

				break;

			case "showUsers":
				$(".users").each(function () {
					if ($(this).parents("li").hasClass("active")) {
						$(this).parents("li").removeClass("active");
					}
				});
				$("#showUsers").parents("li").addClass("active");

				$('#table-users > tbody  > tr').each(function () {
					var typeVal = $(this).children("td").eq(3).html();


					if (typeVal == "admin") {

						$(this).hide();
					}
					else {
						$(this).show();
					}


				});



				$("#btnUsers").html("Show normal users <span class='caret'></span>");
				break;


		}

	});
}



$(function () {

	


	
    

	
	getIDdeleteUser();
	getIDActivateUser();
	activateUser();
	changeUserStatus();
	updateUserID();
	updateUser();
	insertUser();
	searchByUsername();
	usersShowOptions();
	usersShowSearchOptions();
	getUsers("");






	

	


});