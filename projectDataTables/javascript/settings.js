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

function toggleRecordSelection(event, select) {
  // Get the value of the selected option and show/hide the respective select elements
  var selection = $("#toggleRecordSelection").val();

  if(selection === "Model") {
    $("#toggleModels").show();
    $("#toggleLocations").hide();
    $("#toggleUsers").hide();

    fillRecordToggle("toggleModels", "phpinc/getModelHideList.php", select);
  } else if(selection === "Location") {
    $("#toggleModels").hide();
    $("#toggleLocations").show();
    $("#toggleUsers").hide();

    fillRecordToggle("toggleLocations", "phpinc/getLocationHideList.php", select);
  } else if(selection === "User") {
    $("#toggleModels").hide();
    $("#toggleLocations").hide();
    $("#toggleUsers").show();

    fillRecordToggle("toggleUsers", "phpinc/getUserHideList.php", select);
  } else {
    $("#toggleModels").hide();
    $("#toggleLocations").hide();
    $("#toggleUsers").hide();
  }

}

function toggleSelectedRecord() {
  var selection = $("#toggleRecordSelection").val();

  if(selection === "Model") {
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
}

// document.ready wrapper
$(document).ready(function() {

  // Attach event listeners
  // Toggle form
  $("#toggleRadio").on("click", toggleRecord);
  $("#toggleRecordSelection").on("click", toggleRecordSelection);
  $("#toggleRecordSelection").change(toggleRecordSelection);

  $('#toggleSubmit').on("click", toggleSelectedRecord);

  // Add Record Form
  $("#addRadio").on("click", addRecord);
  $("#manufacturerRadio").on("click", addManufacturer);
  $("#modelRadio").on("click", addModel);
  $("#locationRadio").on("click", addLocation);
  $("#categoryRadio").on("click", addCategory);
  $("#userRadio").on("click", addUser);

  // Days Checked Form
  $("#daysCheckedRadio").on("click", changeDaysChecked);


});
