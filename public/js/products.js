$(document).ready(function() {
  let locations = {};

  let product_table = $("#product-table").DataTable({
      responsive: true,
      ajax: {
          url: "/getProducts"
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
              data: "category"
          },
          {
              data: "buy_price"
          },
          {
              data: "sell_price"
          },
          {
              data: "updated"
          },
          {
              data: "stock_cur"
          },
          {
              data: ""
          }
      ],
      columnDefs: [
          {
              targets: 2,
              orderable: false,
              render: function(category) {
                  return `
                        <div style="background:`+category.color+`; color:`+invertColor(category.color)+`;border-radius:5px;text-align:center">`+category.name+`</div>
                    `;
              }
          },
          {
              targets: -1,
              orderable: false,
              render: function() {
                  return `
              <a href="javascript:;" class="edit-product"><i class="mdi mdi-lead-pencil"></i></a>&nbsp;&nbsp;
              <a href="javascript:;" class="delete-product"><i class="mdi mdi-delete"></i></a>
              `;
              }
          }
      ],
      order: [[0, "asc"]]
  });

  $("#product-table tbody").on("click", ".edit-product", function() {
      let selectedData = product_table.row($(this).closest("tr")).data();

      $("#product-modal").modal("show");
      $("#product-modal #edit-id").val(selectedData.id);
      $("#product-modal #product_name").val(selectedData.name);
      $("#product-modal #buy_price").val(selectedData.buy_price);
      $("#product-modal #sell_price").val(selectedData.sell_price);
      $("#product-modal #category").val(selectedData.category.id);
      
      $("#product-modal .modal-title").text("Edit Product");
      $("#product-modal .btn-product").text("Edit");
  });

  $("#product-table tbody").on("click", ".delete-product", function() {
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
                  url: "/products/destroy",
                  type: "delete",
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  data: {
                      id: product_table.row($(this).closest("tr")).data().id,
                  },
                  dataType: "json",
                  success: function(data) {
                      if (data.status == "1") {
                          swal(
                              "Deleted!",
                              "Data has been deleted.",
                              "success"
                          );
                          product_table.ajax.reload();

                          loadSubjectSelection();
                      } else {
                          swal(
                              "Warning!",
                              "Can't delete this product. First delete all products that related with this product.",
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

  $("#product-modal").on("hide.bs.modal", function() {
      $("#product-modal #edit-id").val("0");
      $("#product-modal #product_name").val("");
      $("#product-modal #buy_price").val("");
      $("#product-modal #sell_price").val("");
      $("#product-modal #category").val("");

      $("#product-modal .modal-title").text("Add Product");
      $("#product-modal .btn-product").text("Add");

      $("#product-modal")
          .find(".alert")
          .remove();
  });

  $(".form-product").on("submit", function(e) {
      e.preventDefault();

      let id = $("#edit-id").val(),
          url = "/products",
          method = "post";
      if (id > 0) {
          url = "/products/" + id;
          method = "put";
      }

      $.ajax({
          url: url,
          type: method,
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {
              name: $("#product_name").val(),
              category_id: $("#category").val(),
              buy_price: $("#buy_price").val(),
              sell_price: $("#sell_price").val(),
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
      link.href = '/products/export';
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
          url: "/products/import",
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
              product_table.ajax.reload();
              $("#import-modal").modal("hide");
            } else if (data.status == 0) {
                  let msg = "Something went wrong.";
                  if(data.error == 0) {
                      msg = "Header is wrong.";
                  } else if(data.error == 1) {
                      msg = "Category Name is wrong at row#"+data.row+".";
                  } else if(data.error == 2) {
                      msg = "Product Name is wrong at row#"+data.row+".";
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
    console.log(data, '------');
      if (data.status == 1) {
          product_table.ajax.reload();
          $("#product-modal").modal("hide");
      } else {
          showMessage(
              $("#product-modal")
                  .find("form")
                  .find(".modal-body"),
              "warning",
              "Product name is already existed!"
          );
      }
  }
  
  function invertColor(hexTripletColor) {
    var color = hexTripletColor;
    color = color.substring(1); // remove #
    color = parseInt(color, 16); // convert to integer
    color = 0xFFFFFF ^ color; // invert three bytes
    color = color.toString(16); // convert to hex
    color = ("000000" + color).slice(-6); // pad with leading zeros
    color = "#" + color; // prepend #
    return color;
    }
});
