function updateDropdowns(extraClass) {
  var category = $('.categorySelect.'+extraClass);
  var manufacturer = $('.manufacturerSelect.'+extraClass);
  var model = $('.modelSelect.'+extraClass);
}

function newAsset() {
  var modelId = $('.modelSelect.newAsset').val();
  var userId = $('.userSelect.newAsset').val();
  var locationId = $('.locationSelect.newAsset').val();
  var purchaseDate = $('.purchaseDate.newAsset').val();
  var warranty = $('.warranty.newAsset');
  var networkId = $('networkID.newAsset');
  var serial = $('.serial.newAsset');
  var notes = $('.notes.newAsset');

  // do some validation (needs more)
  if(modelId == -1 || userId == -1 || locationId == -1) {
    alert('invalid');
    return;
  }

  var request = {
    model: modelId,
    user: userId,
    location: locationId,
    purchase: purchaseDate,
    warranty: warranty,
    network: networkId,
    serial: serial,
    notes: notes
  };

  $.ajax({
    url: "phpinc/newAsset.php",
    type: "POST",
    data: request
  });
}

$(document).ready(function(){
    $('.dataTable').DataTable({
        responsive: true,
        serverSide: true,
        ajax: 'phpinc/getAssetDataJson.php',
        rowCallback: function( row, data ) {
            //console.log(data[0]);
            var assetId = data[0];
            $("td:eq(0)", row).html('<button class="editBtn"><i class="fa fa-edit"></i></button>');
            $("td:eq(0) .editBtn", row).on("click", function(evt) {
              var modal = $('.modal:eq(0)');
              modal.css('display', 'block');
              console.log(row);
            });
        },
        columnDefs: [ { orderable: false, targets: [0] } ],
        order: [[ 1, 'asc' ]]
    });

    $('.purchaseDate.newAsset').val(new Date().toISOString().split('T')[0]); //this is sometimes a day off

    $('#addButton').click(newAsset);

    $('.modelSelect').change(function() {
      modelId = $(this).val();
      manufacturerDrop = $(this).prev();
      categoryDrop = manufacturerDrop.prev();
      $.ajax({
        url: 'phpinc/getCategoryManufacturerFromModel.php',
        type: 'GET',
        data: {
          model: modelId
        },
        success: function(data) {
          var response = JSON.parse(data);
          categoryDrop.val(response.category);
          manufacturerDrop.val(response.manufacturer);
        }
      });
    });

    $('.categorySelect').change(function() {
      categoryId = $(this).val();
      manufacturerId = $(this).next().val();
      modelDrop = $(this).next().next();
      $.ajax({
        url: 'phpinc/getModelFromCategoryManufacturer.php',
        type: 'GET',
        data: {
          category: categoryId,
          manufacturer: manufacturerId
        },
        success: function(data) {
          var response = JSON.parse(data);
          $("option", modelDrop).each(function(index) {
            var modelId = $(this).val();

            if(modelId != -1 && !response.models.includes(modelId)) {
              $(this).hide();
            } else {
              $(this).show();
            }
          });
          modelDrop.val("-1");
        }
      });
    });

    $('.manufacturerSelect').change(function() {
      categoryId = $(this).prev().val();
      manufacturerId = $(this).val();
      modelDrop = $(this).next();
      $.ajax({
        url: 'phpinc/getModelFromCategoryManufacturer.php',
        type: 'GET',
        data: {
          category: categoryId,
          manufacturer: manufacturerId
        },
        success: function(data) {
          var response = JSON.parse(data);
          $("option", modelDrop).each(function(index) {
            var modelId = $(this).val();

            if(modelId != -1 && !response.models.includes(modelId)) {
              $(this).hide();
            } else {
              $(this).show();
            }
          });
          modelDrop.val("-1");
        }
      });
    });
});
