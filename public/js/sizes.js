$(document).ready(function() {
    let locations = {};

    let size_table = $("#size-table").DataTable({
        responsive: true,
        ajax: {
            url: "/getSizes"
        },
        lengthMenu: [[10, 50 ,100, 250, 500, 1000, -1], [10, 50 ,100, 250, 500, 1000, "All"]],
        columns: [
            {
                data: "no"
            },
            {
                data: "name"
            },
            {
                data: "stock_cnt"
            },
            {
                data: ""
            }
        ],
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                render: function() {
                    return `
                      <a href="javascript:;" class="edit-size"><i class="mdi mdi-lead-pencil"></i></a>&nbsp;&nbsp;
                      <a href="javascript:;" class="delete-size"><i class="mdi mdi-delete"></i></a>
                    `;
                }
            }
        ],
        order: [[0, "asc"]]
    });

    $("#size-table tbody").on("click", ".edit-size", function() {
        let selectedData = size_table.row($(this).closest("tr")).data();

        $("#size-modal").modal("show");
        $("#size-modal #size-id").val(selectedData.id);
        $("#size-modal #size_name").val(selectedData.name);

        $("#size-modal .modal-title").text("Edit Size");
        $("#size-modal .btn-size").text("Edit");
    });

    $("#size-table tbody").on("click", ".delete-size", function() {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: "/sizes/destroy",
                    type: "delete",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: size_table.row($(this).closest("tr")).data().id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == "1") {
                            swal(
                                "Deleted!",
                                "Data has been deleted.",
                                "success"
                            );
                            size_table.ajax.reload();

                            loadSubjectSelection();
                        } else {
                            swal(
                                "Warning!",
                                "Can't delete this size. First delete all products that related with this size.",
                                "warning"
                            );
                        }
                    }
                });
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
            }
        });
    });

    $("#color").on("change", function() {
        $("#colorLabel").text($(this).val());
    });

    $("#size-modal").on("hide.bs.modal", function() {
        $("#size-modal #size-id").val("0");
        $("#size-modal #size_name").val("");

        $("#size-modal .modal-title").text("Add Size");
        $("#size-modal .btn-size").text("Add");

        $("#size-modal")
            .find(".alert")
            .remove();
    });

    $(".form-size").on("submit", function(e) {
        e.preventDefault();

        let id = $("#size-id").val(),
            url = "/sizes",
            method = "post";
        if (id > 0) {
            url = "/sizes/" + id;
            method = "put";
        }

        $.ajax({
            url: url,
            type: method,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                name: $("#size_name").val(),
                color: $("#color").val(),
            },
            dataType: "json",
            success: function(data) {
                processResult(data);
            }
        });
    });

    function processResult(data) {
        console.log(data, "------");
        if (data.status == 1) {
            size_table.ajax.reload();
            $("#size-modal").modal("hide");
        } else {
            showMessage(
                $("#size-modal")
                    .find("form")
                    .find(".modal-body"),
                "warning",
                "Size name is already existed!"
            );
        }
    }

    function invertColor(hexTripletColor) {
        var color = hexTripletColor;
        color = color.substring(1); // remove #
        color = parseInt(color, 16); // convert to integer
        color = 0xffffff ^ color; // invert three bytes
        color = color.toString(16); // convert to hex
        color = ("000000" + color).slice(-6); // pad with leading zeros
        color = "#" + color; // prepend #
        return color;
    }
});
