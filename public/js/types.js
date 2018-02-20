$(document).ready(function() {
    let locations = {};

    let type_table = $("#type-table").DataTable({
        responsive: true,
        ajax: {
            url: "/getTypes"
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
                data: "icon"
            },
            {
                data: ""
            }
        ],
        columnDefs: [
            {
                targets: -2,
                orderable: false,
                render: function(icon) {
                    return `
                      <span class="`+icon.name+`" style="color:`+icon.color+`"></span>
                    `;
                }
            },
            {
                targets: -1,
                orderable: false,
                render: function() {
                    return `
                      <a href="javascript:;" class="edit-type"><i class="mdi mdi-lead-pencil"></i></a>&nbsp;&nbsp;
                      <a href="javascript:;" class="delete-type"><i class="mdi mdi-delete"></i></a>
                    `;
                }
            }
        ],
        order: [[0, "asc"]]
    });

    $("#type-table tbody").on("click", ".edit-type", function() {
        let selectedData = type_table.row($(this).closest("tr")).data();

        $("#type-modal").modal("show");
        $("#type-modal #type-id").val(selectedData.id);
        $("#type-modal #type_name").val(selectedData.name);
        $("#type-modal #icon").val(selectedData.icon.name);
        $("#type-modal #color").val(selectedData.icon.color);
        $("#type-modal #colorLabel").text(selectedData.icon.color);

        $("#type-modal .modal-title").text("Edit Type");
        $("#type-modal .btn-type").text("Edit");
    });

    $("#type-table tbody").on("click", ".delete-type", function() {
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
                    url: "/types/destroy",
                    type: "delete",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: type_table.row($(this).closest("tr")).data().id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == "1") {
                            swal(
                                "Deleted!",
                                "Data has been deleted.",
                                "success"
                            );
                            type_table.ajax.reload();

                            loadSubjectSelection();
                        } else {
                            swal(
                                "Warning!",
                                "Can't delete this type. First delete all products that related with this type.",
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

    $("#type-modal").on("hide.bs.modal", function() {
        $("#type-modal #type-id").val("0");
        $("#type-modal #type_name").val("");
        $("#type-modal #icon").val("");
        $("#type-modal #color").val("#000000");
        $("#type-modal #colorLabel").text("#000000");

        $("#type-modal .modal-title").text("Add Type");
        $("#type-modal .btn-type").text("Add");

        $("#type-modal")
            .find(".alert")
            .remove();
    });

    $(".form-type").on("submit", function(e) {
        e.preventDefault();

        let id = $("#type-id").val(),
            url = "/types",
            method = "post";
        if (id > 0) {
            url = "/types/" + id;
            method = "put";
        }

        $.ajax({
            url: url,
            type: method,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                name: $("#type_name").val(),
                icon: $("#icon").val(),
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
            type_table.ajax.reload();
            $("#type-modal").modal("hide");
        } else {
            showMessage(
                $("#type-modal")
                    .find("form")
                    .find(".modal-body"),
                "warning",
                "Type name is already existed!"
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
