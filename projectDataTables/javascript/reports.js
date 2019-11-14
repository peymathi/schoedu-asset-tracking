// reports.js
// 10/1/19
// peymathi

// Function that submits a default form and thus reloads the page
function resetForm() {

  // Set all values of the form inputs to the default value
  // Gets all select elements
  var selectElements = $("select");

  var curOptionElements;

  // First set all select elements to unselected
  for (var i = 0; i < selectElements.length; i++)
  {
    curOptionElements = $(selectElements).children();
    for (var j = 0; j < curOptionElements.length; j++)
    {
      curOptionElements[j].selected = "";
    }
  }

  for (var i = 0; i < selectElements.length; i++)
  {
    selectElements[i].firstChild.selected = "selected";
  }

  // Gets the two checkboxes
  var checkboxElements = $("input[type='checkbox']");

  for (var i = 0; i < checkboxElements.length; i++)
  {
    checkboxElements[i].checked = "";
  }

  document.filterForm.submit();
}

// Function to make ajax call and get list of model names from server depending on the
// manufacturer selected
function getModels()
{
  // Get the current manufacturer value
  var manVal = $("#manufacturer").val();

  // Create new ajax call
  var xmlhttp = new XMLHttpRequest();

  // Attach function to run upon receiving response
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
    {
      // Attach the list of new model options to the inner html of the model select element
      $("#model").html(xmlhttp.responseText);
      console.log(xmlhttp.responseText);
    }
  }

  // Send the ajax call
  xmlhttp.open("GET", "serverAjax/reportsGetModels.php?q=" + manVal, true);
  xmlhttp.send();
}

// Function to toggle the modal form. Takes the name of which filter the form should load
function toggleModal(filter)
{
  $("modalLabel").text("Enter Multiple " + filter + "s by typing each " + filter + " with a space in between: ");
  $(".modal").css("display", "block");
}

// document.ready wrapper
$(document).ready(function () {

  // Attach event listener to the "Reset Filters" button
  $("button[name='resetBtn']").on('click', resetForm);

  // Attach event listener to the Manufacturers select menu
  $("#manufacturer").on('change', getModels);

  // Attach event listener to the export csv button
  $("button[name='exportCSV']").on('click', function() {
    window.location.href="report.csv";
  });

  // Set up the modal
  // Get the modal
  var modal = document.getElementsByClassName("modal")[0];

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  // Attach event listeners for each of the label anchors
  $("#catButton").on('click', function() {toggleModal("Category");});
  $("#manButton").on('click', function() {toggleModal("Manufacturer");});
  $("#modButton").on('click', function() {toggleModal("Model");});
  $("#locButton").on('click', function() {toggleModal("Location");});
  $("#userButton").on('click', function() {toggleModal("User");});
  $("#netButton").on('click', function() {toggleModal("Network");});
});
