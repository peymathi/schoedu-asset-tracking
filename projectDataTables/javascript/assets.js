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
                console.log(assetId);
            });
        },
        columnDefs: [ { orderable: false, targets: [0] } ],
        order: [[ 1, 'asc' ]]
    });
});
