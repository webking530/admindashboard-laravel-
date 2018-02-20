$(document).ready(function() {
    let locations = {};

    let category_table = $("#category-table").DataTable({
        responsive: true,
        ajax: {
            url: "/getCategories"
        },
        lengthMenu: [[50 ,100, 250, 500, 1000, -1], [50 ,100, 250, 500, 1000, "All"]],
        columns: [
            {
                data: "no"
            },
            {
                data: "name"
            },
            {
                data: "color"
            },
            {
                data: "product_cnt"
            },
            {
                data: "stock_all"
            },
            {
                data: "stock_cur"
            },
            {
                data: "updated"
            },
            {
                data: ""
            }
        ],
        columnDefs: [
            {
                targets: 2,
                orderable: false,
                render: function(color) {
                    return (
                        `
                        <div 
                          style="display: flex;
                            justify-content: left;
                            align-items: center;"
                        >
                          <div style="background:` +
                        color +
                        `;border-radius:5px;text-align:center;width:20px;display: inline-block;">&nbsp;</div>&nbsp;<span>` +
                        color +
                        `</span>
                        </div>
                    `
                    );
                }
            },
            {
                targets: -1,
                orderable: false,
                render: function() {
                    return `
                      <a href="javascript:;" class="edit-category"><i class="mdi mdi-lead-pencil"></i></a>&nbsp;&nbsp;
                      <a href="javascript:;" class="delete-category"><i class="mdi mdi-delete"></i></a>
                    `;
                }
            }
        ],
        order: [[0, "asc"]]
    });

    $("#category-table tbody").on("click", ".edit-category", function() {
        let selectedData = category_table.row($(this).closest("tr")).data();

        $("#category-modal").modal("show");
        $("#category-modal #edit-id").val(selectedData.id);
        $("#category-modal #name").val(selectedData.name);
        $("#category-modal #color").val(selectedData.color);
        $("#category-modal #colorLabel").text(selectedData.color);

        $("#category-modal .modal-title").text("Edit Category");
        $("#category-modal .btn-category").text("Edit");
    });

    $("#category-table tbody").on("click", ".delete-category", function() {
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
                    url: "/categories/destroy",
                    type: "delete",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: category_table.row($(this).closest("tr")).data().id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == "1") {
                            swal(
                                "Deleted!",
                                "Data has been deleted.",
                                "success"
                            );
                            category_table.ajax.reload();
                        } else {
                            swal(
                                "Warning!",
                                "Can't delete this category. First delete all products that related with this category.",
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

    $("#category-modal").on("hide.bs.modal", function() {
        $("#category-modal #edit-id").val("0");
        $("#category-modal #edit-id").val("");
        $("#category-modal #name").val("");
        $("#category-modal #color").val("#000000");
        $("#category-modal #colorLabel").text("#000000");

        $("#category-modal .modal-title").text("Add Category");
        $("#category-modal .btn-category").text("Add");

        $("#category-modal")
            .find(".alert")
            .remove();
    });

    $(".form-category").on("submit", function(e) {
        e.preventDefault();

        let id = $("#edit-id").val(),
            url = "/categories",
            method = "post";
        if (id > 0) {
            url = "/categories/" + id;
            method = "put";
        }

        $.ajax({
            url: url,
            type: method,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                name: $("#name").val(),
                color: $("#color").val()
            },
            dataType: "json",
            success: function(data) {
                processResult(data);
            }
        });
    });

    $('.dropify').dropify();

    $("#btn-export").on("click", function() {
        let link = document.createElement("a");
        link.href = '/categories/export';
        link.click();
    });

    $("#import-modal").on("hide.bs.modal", function() {
        $("#import-modal .dropify-clear")[0].click();

        $("#import-modal")
            .find(".alert")
            .remove();
    });

    $(".form-import").on("submit", function(e) {
        e.preventDefault();

        var fd = new FormData();
        fd.append("file", $("#file")[0].files[0]);
        
        $.ajax({
            url: "/categories/import",
            type: "post",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: fd,
            dataType: "json",
            async: false,
            processData: false,
            contentType: false,
            success: function(data) {
              if(data.status == 1) {
                showMessage(
                    $("form.form-import")
                        .find("div.modal-body"),
                    "success",
                    "Successfully imported."
                );
                category_table.ajax.reload();
                $("#import-modal").modal("hide");
              } else if (data.status == 0) {
                    let msg = "Something went wrong.";
                    if(data.error == 0) {
                        msg = "Header is wrong.";
                    } else if(data.error == 1) {
                        msg = "Category Name is wrong at row#"+data.row+".";
                    }
                    showMessage(
                        $("form.form-import")
                            .find("div.modal-body"),
                        "warning",
                        msg
                    );
              }
            }
        });
    });

    function processResult(data) {
        console.log(data, "------");
        if (data.status == 1) {
            category_table.ajax.reload();
            $("#category-modal").modal("hide");
        } else {
            showMessage(
                $("#category-modal")
                    .find("form")
                    .find(".modal-body"),
                "warning",
                "Category name is already existed!"
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
