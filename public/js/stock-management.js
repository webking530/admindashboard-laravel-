let stock_table = false;
function initializeTable(start, end) {
  if (stock_table) {
    stock_table.clear().draw();
    stock_table.destroy();
  }

  stock_table = $("#stock-table").DataTable({
    responsive: true,
    ajax: {
        url: "/getStocks",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        data: {
          start: start,
          end: end
        }
    },
    lengthMenu: [[10, 50 ,100, 250, 500, 1000, -1], [10, 50 ,100, 250, 500, 1000, "All"]],
    columns: [
        {
            data: "no"
        },
        {
            data: "updated"
        },
        {
            data: "comment"
        },
        {
            data: "product"
        },
        {
            data: "category"
        },
        {
            data: ""
        }
    ],
    columnDefs: [
        {
            targets: 2,
            render: function(comment) {
                return `
                  <div>
                    <span class="`+comment.type+`" style="color:`+comment.color+`"></span>&nbsp;`+comment.comment+`
                  </div>
                `;
            }
        },
        {
            targets: 3,
            render: function(product) {
                return `
                  <div>
                    <div style="background:`+(product.addable=='1'? '#75cc75': '#ff4040')+`;display: inline-block;padding: 2px 10px;border-radius:5px;color:black;">`+product.quantity+`</div>
                    &nbsp;<span>`+product.name+`(`+product.size+`)</span>
                  </div>
                `;
            }
        },
        {
            targets: 4,
            render: function(category) {
                return `
                    <div style="background:`+category.color+`;display: inline-block;padding: 2px 10px;border-radius:5px;color:`+invertColor(category.color)+`">`+category.name+`</div>
                `;
            }
        },
        {
            targets: -1,
            orderable: false,
            render: function() {
                return `
                  <a href="javascript:;" class="delete-stock"><i class="mdi mdi-delete"></i></a>
                `;
            }
        }
    ],
    order: [[0, "asc"]]
    });
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

$(document).ready(function() {
    // Always Show Calendar on Ranges
    $('#daterange').daterangepicker({
        startDate: moment().subtract(29,'days'),
        endDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'All time': [-1, moment()],
        },
        alwaysShowCalendars: true,
    });

    let times = $("#daterange").val().split(" - ");
    initializeTable(times[0], times[1]);
  
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
      initializeTable(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
    });
  
    $("#stock-table tbody").on("click", ".delete-stock", function() {
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
                    url: "/stocks/destroy",
                    type: "delete",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: stock_table.row($(this).closest("tr")).data().id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 1) {
                            swal(
                                "Deleted!",
                                "Data has been deleted.",
                                "success"
                            );
                            stock_table.ajax.reload();
                        } else if (data.status == -1) {
                            swal(
                                "Warning!",
                                "Can't delete this stock because stock of " + data.product + ", " + data.size + " remains " + data.stock + ".",
                                "warning"
                            );
                        } else {
                            swal(
                                "Warning!",
                                "Can't delete this stock. First delete other items that related with this stock.",
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

    $("#category").on("change", function() {
      if ($(this).val() == "") {
          $("#product").val("");
          return;
      }

      setProduct($(this).val());
    });

    $("#stock-modal").on("hide.bs.modal", function() {
        $("#stock-modal #edit-id").val("0");
        $("#stock-modal #category").val("");
        $("#stock-modal #product").val("");
        $("#stock-modal #quantity").val("");
        $("#stock-modal #size").val("");
        $("#stock-modal #type").val("");
        $("#stock-modal #addable").val("");
        $("#stock-modal #comment").val("");

        $("#stock-modal .modal-title").text("Add Stock");
        $("#stock-modal .btn-stock").text("Add");

        $("#stock-modal")
            .find(".alert")
            .remove();
    });

    $(".form-stock").on("submit", function(e) {
        e.preventDefault();

        let id = $("#edit-id").val(),
            url = "/stocks",
            method = "post";
        if (id > 0) {
            url = "/stocks/" + id;
            method = "put";
        }

        $.ajax({
            url: url,
            type: method,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
              category_id: $("#category").val(),
              product_id: $("#product").val(),
              quantity: $("#quantity").val(),
              size_id: $("#size").val(),
              type_id: $("#type").val(),
              addable: $("#addable").val(),
              comment: $("#comment").val(),
            },
            dataType: "json",
            success: function(data) {
                processResult(data);
            }
        });
    });

    $('.dropify').dropify();

    $("#btn-export").on("click", function() {
        let times = $("#daterange").val().split(" - ");
        let link = document.createElement("a");
        link.href = '/stocks/export/'+getFormattedDate(times[0])+'/'+getFormattedDate(times[1]);
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
            url: "/stocks/import",
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
                stock_table.ajax.reload();
                $("#import-modal").modal("hide");
              } else if (data.status == 0) {
                    let msg = "Something went wrong.";
                    if(data.error == 0) {
                        msg = "Header is wrong.";
                    } else if(data.error == 1) {
                        msg = "Category Name is wrong at row#"+data.row+".";
                    } else if(data.error == 2) {
                        msg = "Product Name is wrong at row#"+data.row+".";
                    } else if(data.error == 3) {
                        msg = "Size Name is wrong at row#"+data.row+".";
                    } else if(data.error == 4) {
                        msg = "Type Name is wrong at row#"+data.row+".";
                    } else if(data.error == 5) {
                        msg = "Quantity is wrong at row#"+data.row+".";
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

    function setProduct(category_id) {
      
      $.ajax({
        url: "/getCategoryProducts/" + category_id,
        type: "get",
        dataType: "json",
        async: false,
        success: function(response) {
            $("#product").empty();
            $("#product").append(
                $("<option>", {
                    value: "",
                    text: "-Choose product-"
                })
            );
            $.each(response.data, function(i, data) {
                $("#product").append(
                    $("<option>", {
                        value: data.id,
                        text: data.name
                    })
                );
            });
        }
    });
    }

    function processResult(data) {
        if (data.status == 1) {
            stock_table.ajax.reload();
            $("#stock-modal").modal("hide");
        } else {
            showMessage(
                $("#stock-modal")
                    .find("form")
                    .find(".modal-body"),
                "warning",
                "You can't substract because stock remains #"+data.stock+"!"
            );
        }
    }
    
    function getFormattedDate(date_str) {
        let date = new Date(date_str);
        let year = date.getFullYear();
        let month = (1 + date.getMonth()).toString().padStart(2, '0');
        let day = date.getDate().toString().padStart(2, '0');
    
        return year + '-' + month + '-' + day;
    }
});
