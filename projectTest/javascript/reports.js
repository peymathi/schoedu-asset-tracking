// reports.js
// 9/28/19
// peymathi

function filterInput() {

  console.log("I RAN MAN!!!!");
  // Get form data and store it
  var strCategory = $("#category").val();
  var strManufacturer = $("#manufacturer").val();
  var strModel = $("#model").val();
  var strLocation = $("#location").val();
  var strUser = $("#user").val();
  var strSurplus = $("#surplus").val();
  var strExpiredWarranty = $("#expiredWarranty").val();

  // Array of data to be added to filter title
  var arrOutput = [];

  // Go through each input element and add the data to the output array
  if (strCategory != "- -")
  {
    arrOutput.push("Category: " + strCategory + ";");
  }

  if (strManufacturer != "- -")
  {
    arrOutput.push("Manufacturer: " + strManufacturer + ";");
  }

  if (strModel != "- -")
  {
    arrOutput.push("Model: " + strManufacturer + ";");
  }

  if (strLocation != "- -")
  {
    arrOutput.push("Location: " + strLocation + ";");
  }

  if (strUser != "- -")
  {
    arrOutput.push("User: " + strUser + ";");
  }

  if (strSurplus == "checked")
  {
    arrOutput.push(" (Includes Surplus) ");
  }

  else
  {
    arrOutput.push(" (Excludes Surplus) ");
  }

  if (strExpiredWarranty == "checked")
  {
    arrOutput.push(" (Expired Warranty ) ");
  }


  // Header element that shows the current filter on data
  var elHeader = $("#filterTitle");
  var strOutput = "Current Asset Filters: ";

  // Loop through the output array and add each element to the output string
  for (var i = 0; i < arrOutput.length; i++)
  {
    strOutput += arrOutput[i];
  }

  // Add the new output string to the filter title element
  elHeader.innerHTML = strOutput;

}

// Document.ready() wrapper
$(document).ready(function() {

  // Attach event listener onto filter button
  $("#filterForm").on('submit', function () {
    filterInput();
  });

});
