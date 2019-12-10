var table;

function newAssets() {
  var modelId = $('.modelSelect.newAsset').val();
  var userId = $('.userSelect.newAsset').val();
  var locationId = $('.locationSelect.newAsset').val();
  var purchaseDate = $('.purchaseDate.newAsset').val();
  var warranty = $('.warranty.newAsset').val();
  var networkId = $('.networkID.newAsset').map(function() {
    return $(this).val();
  }).get();
  var serial = $('.serial.newAsset').map(function() {
    return $(this).val();
  }).get();
  var notes = $('.notes.newAsset').map(function() {
    return $(this).val();
  }).get();

  var i;
  var details = [];
  for(i = 0; i < networkId.length; i++) {
    var detail = {
      network: networkId[i],
      serial: serial[i],
      notes: notes[i]
    };

    details.push(detail);
  }

  console.log(details);

  // do some validation (needs more)
  if(modelId == -1 || userId == -1 || locationId == -1 || serial.some(function(v) { return v == ""; })) {
    alert('invalid');
    return;
  }

  var request = {
    model: modelId,
    user: userId,
    location: locationId,
    purchase: purchaseDate,
    warranty: warranty,
    details: details
  };

  console.log(JSON.stringify(request));

  $.ajax({
    url: "phpinc/newAssets.php",
    type: "POST",
    data: JSON.stringify(request),
    dataType: "json",
    success: function(data) {
      if(data.status == "success") {
        table.ajax.reload();
        alert('Created asset');
      } else {
        alert('Failed to create asset');
      }
    }
  });
}

function editAsset() {
  console.log('edit');
  var modelId = $('.modelSelect.editAsset').val();
  var userId = $('.userSelect.editAsset').val();
  var locationId = $('.locationSelect.editAsset').val();
  var purchaseDate = $('.purchaseDate.editAsset').val();
  var warranty = $('.warranty.editAsset').val();
  var networkId = $('.networkID.editAsset').val();
  var serial = $('.serial.editAsset').val();
  var notes = $('.notes.editAsset').val();
  var asset = $('#editButton').val();
  var surplus = $('.surplus.editAsset').is(":checked");

  // do some validation (needs more)
  if(modelId == -1 || userId == -1 || locationId == -1 || serial == "") {
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
    notes: notes,
    surplus: surplus,
    asset: asset
  };

  $.ajax({
    url: "phpinc/editAsset.php",
    type: "POST",
    data: request,
    success: function(d) {
      $('.modal:eq(0)').css('display', 'none')
      table.ajax.reload(null, false);
    }
  });
}

function updateModels(categoryId, manufacturerId, modelDrop) {
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
}

function updateCategoryManufacturer(modelId, categoryDrop, manufacturerDrop, callback) {
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
      if(callback != undefined) {
        callback();
      }
    }
  });
}

function updateWarranty(manufacturerId, warrantyDrop) {
  $.ajax({
    url: 'phpinc/getWarrantyFromManufacturer.php',
    type: 'GET',
    data: {
      manufacturer: manufacturerId
    },
    success: function(data) {
      var response = JSON.parse(data);
      warrantyDrop.val(response.warranty);
    }
  });
}

function populateEditModal(asset) {
  var categoryId = $('.categorySelect.editAsset');
  var manufacturerId = $('.manufacturerSelect.editAsset');
  var modelId = $('.modelSelect.editAsset');
  var userId = $('.userSelect.editAsset');
  var locationId = $('.locationSelect.editAsset');
  var purchaseDate = $('.purchaseDate.editAsset');
  var warranty = $('.warranty.editAsset');
  var networkId = $('.networkID.editAsset');
  var serial = $('.serial.editAsset');
  var notes = $('.notes.editAsset');
  var surplus = $('.surplus.editAsset');

  $('#editButton').val(asset);

  $.ajax({
    url: 'phpinc/getAsset.php',
    type: 'GET',
    data: { asset: asset },
    success: function(data) {
      response = JSON.parse(data);
      modelId.val(response.asset.ModelID);
      userId.val(response.asset.UserID);
      locationId.val(response.asset.LocationID);
      purchaseDate.val(response.asset.PurchaseDate);
      warranty.val(response.asset.Warranty);
      networkId.val(response.asset.NetworkName);
      serial.val(response.asset.SerialNumber);
      notes.val(response.asset.Notes);
      surplus.prop('checked', response.asset.IsSurplus == '0' ? false : true);
      updateCategoryManufacturer(response.asset.ModelID, categoryId, manufacturerId, function() {
        $('.modal:eq(0)').css('display', 'block')
      });
    }
  });

}

function getAssetDetailFragment() {
  return `<br><div class="assetDetail newAsset" style="margin-left: 0px">
    Network ID:<input type="text" class="networkID newAsset" name="networkID">

    Serial#:<input type="text" class="serial newAsset" name="serial">

    Notes:<input type="text" class="notes newAsset" name="notes">
  </div>`;
}

function changeQtyTo(n) {
  var detailDiv = $('.assetDetails.newAsset');
  var detailCount = $('.assetDetail.newAsset').length;
  var diff = n - detailCount;

  if(diff > 0) {
    var i;
    for(i = 0; i < diff; i++) {
      $(getAssetDetailFragment()).appendTo(detailDiv);
    }
  } else if(diff < 0) {
    var i;
    for(i = 0; i < -diff; i++) {
      detailDiv.children().last().remove();
      detailDiv.children().last().remove();
    }
  }
}

$(document).ready(function(){
    table = $('.dataTable').DataTable({
        responsive: true,
        serverSide: true,
        ajax: 'phpinc/getAssetDataJson.php',
        rowCallback: function( row, data ) {
            var assetId = data[0];
            $("td:eq(0)", row).html('<button class="editBtn"><i class="fa fa-edit"></i></button><button onclick="rentFunction(this)" class="checkout"><i class="fa fa-shopping-cart"></i></button>');
            $("td:eq(0) .editBtn", row).on("click", function(evt) {
              populateEditModal(assetId);
            });
        },
        columnDefs: [
          { orderable: false, targets: [0] },
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 2, targets: 1 },
          { responsivePriority: 3, targets: 4 },
          { responsivePriority: 4, targets: 6 },
          { responsivePriority: 5, targets: 5 },
          { responsivePriority: 6, targets: 3 },
          { responsivePriority: 7, targets: 2 }
        ],
        order: [[ 1, 'asc' ]]
    });

    $('.purchaseDate.newAsset').val(new Date().toISOString().split('T')[0]); //this is sometimes a day off

    $('#addButton').click(newAssets);
    $('#editButton').click(editAsset);

    $('.modelSelect').change(function() {
      modelId = $(this).val();
      manufacturerDrop = $(this).siblings(".manufacturerSelect");
      categoryDrop = $(this).siblings(".categorySelect");
      warrantyDrop = $(this).siblings(".warranty");
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
          updateWarranty(response.manufacturer, warrantyDrop);
        }
      });
    });

    $('.categorySelect').change(function() {
      categoryId = $(this).val();
      manufacturerId = $(this).siblings(".manufacturerSelect").val();
      modelDrop = $(this).siblings(".modelSelect");
      updateModels(categoryId, manufacturerId, modelDrop);
    });

    $('.manufacturerSelect').change(function() {
      categoryId = $(this).siblings(".categorySelect").val();
      manufacturerId = $(this).val();
      modelDrop = $(this).siblings(".modelSelect");
      warrantyDrop = $(this).siblings(".warranty");
      updateWarranty(manufacturerId, warrantyDrop);
      updateModels(categoryId, manufacturerId, modelDrop);
    });

    $('.qty.newAsset').change(function(e) {
      if($(this).val() < 1) {
        $(this).val(1);
      }
      changeQtyTo($(this).val());
    })
});
