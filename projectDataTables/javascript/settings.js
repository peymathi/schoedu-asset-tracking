// settings.js
// 10/2/19
// peymathi

function toggleRecord() {
  $("#currentSetting").text("Toggle a Record");
  $("#toggleRecordForm").show();
  $("#addRecordForm").hide();
  $("#changeDaysCheckedForm").hide();
}

function fillRecordToggle(element, endpoint, select) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var el = document.getElementById(element)
      el.innerHTML = xmlhttp.responseText;
      if(select !== undefined) {
        el.value = select;
      }
      if(element == "toggleModels") {
        updateCategoryManufacturer();
      } else if(element == "toggleManufacturers") {
        updateWarranty();
      }
    }
  }
  xmlhttp.open("GET", endpoint, true);
  xmlhttp.send();
}

function callRecordToggle(type, query, box) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      toggleRecordSelection(null, query);
    }
  }
  xmlhttp.open("GET", "phpinc/toggleRecordHide.php?type="+type+"&key="+query, true);
  xmlhttp.send();
}

function callRecordEditName(type, key, name, box) {
  $.ajax({
    url: "phpinc/editRecordName.php",
    type: "GET",
    data: {
      type: type,
      key: key,
      name: name
    },
    success: function(d) {
      toggleRecordSelection(null, key);
    }
  });
}

function updateCategoryManufacturer() {
  var modelId = $('#toggleModels').val();

  $.ajax({
    url: 'phpinc/getCategoryManufacturerFromModel.php',
    type: 'GET',
    data: {
      model: modelId
    },
    success: function(data) {
      var response = JSON.parse(data);
      $('#modelCategorySelect').val(response.category);
      $('#modelManufacturerSelect').val(response.manufacturer);
    }
  });
}

function updateWarranty() {
  var manufacturerId = $('#toggleManufacturers').val();

  $.ajax({
    url: 'phpinc/getWarrantyFromManufacturer.php',
    type: 'GET',
    data: {
      manufacturer: manufacturerId
    },
    success: function(data) {
      var response = JSON.parse(data);
      $('#editWarranty').val(response.warranty);
    }
  });
}

function toggleRecordSelection(event, select) {
  // Get the value of the selected option and show/hide the respective select elements
  var selection = $("#toggleRecordSelection").val();

  if(selection === "Category") {
    $("#toggleCategories").show();
    $("#toggleManufacturers").hide();
    $("#toggleModels").hide();
    $("#toggleLocations").hide();
    $("#toggleUsers").hide();

    $("#editModel").hide();
    $("#editManufacturer").hide();

    fillRecordToggle("toggleCategories", "phpinc/getCategoryHideList.php", select);
  } else if(selection === "Manufacturer") {
    $("#toggleCategories").hide();
    $("#toggleManufacturers").show();
    $("#toggleModels").hide();
    $("#toggleLocations").hide();
    $("#toggleUsers").hide();

    $("#editModel").hide();
    $("#editManufacturer").show();

    fillRecordToggle("toggleManufacturers", "phpinc/getManufacturerHideList.php", select);
  } else if(selection === "Model") {
    $("#toggleCategories").hide();
    $("#toggleManufacturers").hide();
    $("#toggleModels").show();
    $("#toggleLocations").hide();
    $("#toggleUsers").hide();

    $("#editModel").show();
    $("#editManufacturer").hide();

    fillRecordToggle("toggleModels", "phpinc/getModelHideList.php", select);
    fillRecordToggle("modelCategorySelect", "phpinc/getCategoryList.php");
    fillRecordToggle("modelManufacturerSelect", "phpinc/getManufacturerList.php");
  } else if(selection === "Location") {
    $("#toggleCategories").hide();
    $("#toggleManufacturers").hide();
    $("#toggleModels").hide();
    $("#toggleLocations").show();
    $("#toggleUsers").hide();

    $("#editModel").hide();
    $("#editManufacturer").hide();

    fillRecordToggle("toggleLocations", "phpinc/getLocationHideList.php", select);
  } else if(selection === "User") {
    $("#toggleCategories").hide();
    $("#toggleManufacturers").hide();
    $("#toggleModels").hide();
    $("#toggleLocations").hide();
    $("#toggleUsers").show();

    $("#editModel").hide();
    $("#editManufacturer").hide();

    fillRecordToggle("toggleUsers", "phpinc/getUserHideList.php", select);
  } else {
    $("#toggleCategories").hide();
    $("#toggleManufacturers").hide();
    $("#toggleModels").hide();
    $("#toggleLocations").hide();
    $("#toggleUsers").hide();

    $("#editModel").hide();
    $("#editManufacturer").hide();
  }

}

function toggleSelectedRecord() {
  var selection = $("#toggleRecordSelection").val();

  if(selection === "Category") {
    selectedVal = $("#toggleCategories").val();
    callRecordToggle("category", selectedVal, "#toggleCategories");
  } else if(selection === "Manufacturer") {
    selectedVal = $("#toggleManufacturers").val();
    callRecordToggle("manufacturer", selectedVal, "#toggleManufacturers");
  } else if(selection === "Model") {
    selectedVal = $("#toggleModels").val();
    callRecordToggle("model", selectedVal, "#toggleModels");
  } else if(selection === "Location") {
    selectedVal = $("#toggleLocations").val();
    callRecordToggle("location", selectedVal, "#toggleLocations");
  } else if(selection === "User") {
    selectedVal = $("#toggleUsers").val();
    callRecordToggle("user", selectedVal, "#toggleUsers");
  }
}

function addRecord() {
  $("#currentSetting").text("Add a Record");
  $("#addRecordForm").show();
  $("#toggleRecordForm").hide();
  $("#changeDaysCheckedForm").hide();
}

function addManufacturer() {
  $("#newManufacturerForm").show();
  $("#newModelForm").hide();
  $("#newCategoryForm").hide();
  $("#newLocationForm").hide();
  $("#newUserForm").hide();
}

function addModel() {
  $("#newManufacturerForm").hide();
  $("#newModelForm").show();
  $("#newCategoryForm").hide();
  $("#newLocationForm").hide();
  $("#newUserForm").hide();

  fillRecordToggle("manufacturerSelect", "phpinc/getActiveManufacturersList.php");
  fillRecordToggle("categorySelect", "phpinc/getActiveCategoriesList.php");
}

function addCategory() {
  $("#newManufacturerForm").hide();
  $("#newModelForm").hide();
  $("#newCategoryForm").show();
  $("#newLocationForm").hide();
  $("#newUserForm").hide();
}

function addLocation() {
  $("#newManufacturerForm").hide();
  $("#newModelForm").hide();
  $("#newCategoryForm").hide();
  $("#newLocationForm").show();
  $("#newUserForm").hide();
}

function addUser() {
  $("#newManufacturerForm").hide();
  $("#newModelForm").hide();
  $("#newCategoryForm").hide();
  $("#newLocationForm").hide();
  $("#newUserForm").show();
}

function changeDaysChecked() {
  $("#currentSetting").text("Change Days Since Last Check Filter");
  $("#changeDaysCheckedForm").show();
  $("#addRecordForm").hide();
  $("#toggleRecordForm").hide();
  getDaysChecked();
}

function editRecordName() {
  var selection = $("#toggleRecordSelection").val();

  var name = $('#editNameBox').val();

  if(selection === "Category") {
    selectedVal = $("#toggleCategories").val();
    callRecordEditName("category", selectedVal, name, "#toggleCategories");
  } else if(selection === "Manufacturer") {
    selectedVal = $("#toggleManufacturers").val();
    callRecordEditName("manufacturer", selectedVal, name, "#toggleManufacturers");
  } else if(selection === "Model") {
    selectedVal = $("#toggleModels").val();
    callRecordEditName("model", selectedVal, name, "#toggleModels");
  } else if(selection === "Location") {
    selectedVal = $("#toggleLocations").val();
    callRecordEditName("location", selectedVal, name, "#toggleLocations");
  } else if(selection === "User") {
    selectedVal = $("#toggleUsers").val();
    callRecordEditName("user", selectedVal, name, "#toggleUsers");
  }
}

function editModelInfo() {
  var model = $('#toggleModels').val();
  var category = $('#modelCategorySelect').val();
  var manufacturer = $('#modelManufacturerSelect').val();
  $.ajax({
    url: "phpinc/editModelInfo.php",
    type: "GET",
    data: {
      model: model,
      category: category,
      manufacturer: manufacturer
    },
    success: function(d) {
      toggleRecordSelection(null, model);
      alert("edited model");
    }
  })
}

function editManufacturerInfo() {
  var manufacturer = $('#toggleManufacturers').val();
  var warranty = $('#editWarranty').val();
  $.ajax({
    url: "phpinc/editManufacturerInfo.php",
    type: "GET",
    data: {
      manufacturer: manufacturer,
      warranty: warranty
    },
    success: function(d) {
      toggleRecordSelection(null, manufacturer);
      alert("edited manufacturer");
    }
  })
}

function getDaysChecked() {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      $("#currentDaysChecked").text(xmlhttp.responseText);
      $("#newDaysChecked").val(xmlhttp.responseText);
    }
  }
  xmlhttp.open("GET", "phpinc/getCheckDays.php", true);
  xmlhttp.send();
}

// document.ready wrapper
$(document).ready(function() {

  // Attach event listeners
  // Toggle form
  $("#toggleRadio").on("click", toggleRecord);
  //$("#toggleRecordSelection").on("click", toggleRecordSelection);
  $("#toggleRecordSelection").change(toggleRecordSelection);

  $('#toggleSubmit').on("click", toggleSelectedRecord);
  $('#editSubmit').on("click", editRecordName);
  $('#toggleModels').change(updateCategoryManufacturer);
  $('#editModelSubmit').on("click", editModelInfo);

  $('#toggleManufacturers').change(updateWarranty);
  $('#editManufacturerSubmit').on("click", editManufacturerInfo);

  // Add Record Form
  $("#addRadio").on("click", addRecord);
  $("#manufacturerRadio").on("click", addManufacturer);
  $("#modelRadio").on("click", addModel);
  $("#locationRadio").on("click", addLocation);
  $("#categoryRadio").on("click", addCategory);
  $("#userRadio").on("click", addUser);

  $(".warranty").change(function(e) {
    if($(this).val() < 0) {
      $(this).val(0);
    }
  });

  // Days Checked Form
  $("#daysCheckedRadio").on("click", changeDaysChecked);

  $('#newCategorySubmit').on("click", function(e) {
    //validation here
    $.ajax({
      url: "phpinc/processSettings.php",
      data: {
        "type":"category",
        "name":$("#newCategory").val()
      },
      type: "POST",
      success: function(r) {
        $('#newCategory').val('');
        alert("created category");
      }
    });
  });

  $('#newManufacturerSubmit').on("click", function(e) {
    //validation here
    $.ajax({
      url: "phpinc/processSettings.php",
      data: {
        "type":"manufacturer",
        "name":$("#newManufacturer").val(),
        "warranty":$("#warranty").val()
      },
      type: "POST",
      success: function(r) {
        $('#newManufacturer').val('');
        alert("created manufacturer");
      }
    });
  });

  $('#newModelSubmit').on("click", function(e) {
    //validation here
    $.ajax({
      url: "phpinc/processSettings.php",
      data: {
        "type":"model",
        "name":$("#newModel").val(),
        "category":$('#categorySelect').val(),
        "manufacturer":$('#manufacturerSelect').val()
      },
      type: "POST",
      success: function(r) {
        $('#newModel').val('');
        alert("created model");
      }
    });
  });

  $('#newLocationSubmit').on("click", function(e) {
    //validation here
    $.ajax({
      url: "phpinc/processSettings.php",
      data: {
        "type":"location",
        "name":$("#newLocation").val(),
      },
      type: "POST",
      success: function(r) {
        $('#newLocation').val('');
        alert("created location");
      }
    });
  });

  $('#newUserSubmit').on("click", function(e) {
    //validation here
    $.ajax({
      url: "phpinc/processSettings.php",
      data: {
        "type":"user",
        "name":$("#newUser").val(),
      },
      type: "POST",
      success: function(r) {
        $('#newUser').val('');
        alert("created user");
      }
    });
  });

  $('#newDaysCheckedSubmit').on("click", function(e) {
    //validation here
    $.ajax({
      url: "phpinc/processSettings.php",
      data: {
        "type":"daysChecked",
        "days":$("#newDaysChecked").val(),
      },
      type: "POST",
      success: function(r) {
        getDaysChecked();
        alert("updated days checked");
      }
    });
  });
});
