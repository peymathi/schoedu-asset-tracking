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
  var manVal = $("#manufacturerSelect").val();

  // Create new ajax call
  var xmlhttp = new XMLHttpRequest();

  // Attach function to run upon receiving response
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
    {
      // Attach the list of new model options to the inner html of the model select element
      $("#modelSelect").html(xmlhttp.responseText);
    }
  }

  // Send the ajax call
  xmlhttp.open("GET", "serverAjax/reportsGetModels.php?q=" + manVal, true);
  xmlhttp.send();
}

// Function to submit a form with the filters being set from clicking a value
// in the quick summaries section
function quickFilter(element)
{
  // Get the classlist for the element that was clicked
  var classList = element.classList;

  // Get the value
  var text = element.textContent;

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

  console.log(classList.contains("quickMod"));

  // Check for model, manufacturer, or category
  if (classList.contains("quickMod"))
  {
      $("#modelSelect").val(text);
  }

  else if (classList.contains("quickCat"))
  {
      $("#categorySelect").val(text);
  }

  else if (classList.contains("quickMan"))
  {
    $("#manufacturerSelect").val(text);
  }

  else
  {
    throw "Error: Invalid quick filter";
  }

  // Submit the form
  document.filterForm.submit();
}

// document.ready wrapper
$(document).ready(function () {

  // Get the models once
  getModels();

  // Attach event listener to the "Reset Filters" button
  $("button[name='resetBtn']").on('click', resetForm);

  // Attach event listener to the Manufacturers select menu
  $("#manufacturerSelect").on('change', getModels);

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

  // Attach event listener for the filter multiple modal
  $(".filterLabel").on('click', function() {

    // Get the id of the label clicked
    var label = this.id;

    // Make the first character uppercase
    label = label.replace(label[0], label[0].toUpperCase());

    // Set the value of the filterType input element to the label
    $("#filterType").val(label);

    // Add the filter name on the end of the modal header
    $("#modalHeader").text("Filter Multiple - " + label);
    $(".modal").css("display", "block");

  });

  // Attach event listener on all quick summary span elements
  $(".quickClick").on("click", function() {quickFilter(this); return false;});
});
