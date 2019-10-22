// settings.js
// 10/2/19
// peymathi

function toggleRecord() {
  $("#currentSetting").text("Toggle a Record");
  $("#toggleRecordForm").show();
  $("#addRecordForm").hide();
  $("#changeDaysCheckedForm").hide();
}

function toggleRecordSelection() {
  // Get the value of the selected option and show/hide the respective select elements
  var selection = $("#toggleRecordSelection").val();

  if(selection === "Model")
  {
    $("#toggleModels").show();
    $("#toggleLocations").hide();
    $("#toggleUsers").hide();
  }

  else if(selection === "Location")
  {
    $("#toggleModels").hide();
    $("#toggleLocations").show();
    $("#toggleUsers").hide();
  }

  else if(selection === "User")
  {
    $("#toggleModels").hide();
    $("#toggleLocations").hide();
    $("#toggleUsers").show();
  }

  else
  {
    $("#toggleModels").hide();
    $("#toggleLocations").hide();
    $("#toggleUsers").hide();
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
