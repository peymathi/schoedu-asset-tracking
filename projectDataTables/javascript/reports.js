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

// document.ready wrapper
$(document).ready(function () {

  // Attach event listener to the "Reset Filters" button
  $("button[name='resetBtn']").on('click', resetForm);

  // Attach event listener to the export csv button
  $("button[name='exportCSV']").on('click', function() {
    $("#csvDownload").click();
  });

  // Attach event listener to the export pdf button
  $("button[name='exportPDF']").on('click', function() {
    $("#pdfDownload").click();
  });

});
