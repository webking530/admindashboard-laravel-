let inStockTable = false, outStockTable = false, sizes=[];
function initTables() {
    $.ajax({
        url: "/getReports",
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            date: $("#date").val(),
            category: $("#category").val(),
            product: $("#product").val(),
            size: $("#size").val(),
        },
        dataType: "json",
        success: function(data) {
            let headerContent = `<tr><th width="5%">#</th><th>Category</th><th>Product</th>`, sizeFilter = ``;
            sizes = data.sizes;
            data.sizes.forEach((size, index) => {
                headerContent += "<th>"+size.name+"</th>";
                sizeFilter += `<div class="col-sm-6"><div class="form-group row">
                                    <label class="col-sm-6 text-right control-label col-form-label">`+size.name+`</label>
                                    <div class="col-sm-6">
                                        <input type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" size-id="`+size.id+`" size-name="`+ (3+index) +`" `+(size.visibility=="1"? "checked": "")+` />
                                    </div>
                                </div></div>`;
            });
            headerContent += "<th>Total Stock</th></tr>";

            let inStockContent = outStockContent = "";
            data.outStocks.forEach(stock => {
                outStockContent += "<tr>";
                stock.forEach(item => {
                    outStockContent += "<td>"+item+"</td>"
                });
                outStockContent += "</tr>";
            });
            data.inStocks.forEach(stock => {
                inStockContent += "<tr>";
                stock.forEach(item => {
                    inStockContent += "<td>"+item+"</td>"
                });
                inStockContent += "</tr>";
            });
            if (inStockTable) {
                inStockTable.clear().draw();
                inStockTable.destroy();
            }
            if (outStockTable) {
                outStockTable.clear().draw();
                outStockTable.destroy();
            }
            
            $("#in_stock_table_header").html(headerContent);
            $("#in_stock_table_body").html(inStockContent);
            $("#out_stock_table_header").html(headerContent);
            $("#out_stock_table_body").html(outStockContent);
            
            inStockTable = $("#in_stock_table").DataTable({lengthMenu: [[10, 50 ,100, 250, 500, 1000, -1], [10, 50 ,100, 250, 500, 1000, "All"]]});
            outStockTable = $("#out_stock_table").DataTable({lengthMenu: [[10, 50 ,100, 250, 500, 1000, -1], [10, 50 ,100, 250, 500, 1000, "All"]]});
            
            data.sizes.forEach((size, index) => {
                inStockTable.column(index+3).visible(size.visibility=="1"? true: false);
                outStockTable.column(index+3).visible(size.visibility=="1"? true: false);
            });

            $("#size_fields").html(sizeFilter);

            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });
            // $(".js-switch").change(function(e) {
            //     inStockTable.column($(this).attr("size-name")).visible($(this).is(":checked"));
            //     outStockTable.column($(this).attr("size-name")).visible($(this).is(":checked"));
            //     $("#in_stock_table").css('width', '100%');
            //     $("#out_stock_table").css('width', '100%');
            // })
            
            $("div.loading").css("display", "none");
        }
    });
}

function getFormattedDate(str_date = "") {
    let date = str_date==""? new Date(): new Date(str_date);
    let year = date.getFullYear();
    let month = (1 + date.getMonth()).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');
  
    return year + '-' + month + '-' + day;
}

$(document).ready(function() {
    
    initTables();

    $(".show-hidden").on("change", function() {
        if($(this).is(':checked')) {
            if ($(this).attr("id") == "check_in_stock") {
                $(".table-in-stock").css("display", "block");
            } else if ($(this).attr("id") == "check_out_stock") {
                $(".table-out-stock").css("display", "block");
            }
        } else {
            if ($(this).attr("id") == "check_in_stock") {
                $(".table-in-stock").css("display", "none");
            } else if ($(this).attr("id") == "check_out_stock") {
                $(".table-out-stock").css("display", "none");
            }
        }
    });

    $("#size-modal").on("hide.bs.modal", function() {
        let sizeFilter = "";
        sizes.forEach((size, index) => {
            sizeFilter += `<div class="col-sm-6"><div class="form-group row">
                                <label class="col-sm-6 text-right control-label col-form-label">`+size.name+`</label>
                                <div class="col-sm-6">
                                    <input type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" size-id="`+size.id+`" size-name="`+ (3+index) +`" `+(size.visibility=="1"? "checked": "")+` />
                                </div>
                            </div></div>`;
        });
        $("#size_fields").html(sizeFilter);

        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });
    });

    $("#btn-export-instock").on("click", function() {
        let link = document.createElement("a");
        link.href = '/reports/export/in/'+getFormattedDate($("#date").val());
        link.click();
        console.log('/reports/export/in/'+getFormattedDate($("#date").val()));
    });

    $("#btn-export-outstock").on("click", function() {
        let link = document.createElement("a");
        link.href = '/reports/export/out/'+getFormattedDate($("#date").val());
        link.click();
        console.log('/reports/export/out/'+getFormattedDate($("#date").val()));
    });

    $(".form-show-hide").on("submit", function(e) {
        e.preventDefault();

        sizes = [];
        $('.js-switch').each(function () {
            console.log($(this).attr("size-id"), $(this).is(":checked"));
            let name = $(this).closest(".form-group.row").find("label.control-label").text();
            sizes.push({id:$(this).attr("size-id"), name:name, visibility: $(this).is(":checked")? '1': '0'});
        });

        $.ajax({
            url: '/changeSizeVisibility',
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                sizes: JSON.stringify(sizes)
            },
            dataType: "json",
            success: function(response) {
                if(response.status == 1) {
                    $('.js-switch').each(function () {
                        inStockTable.column($(this).attr("size-name")).visible($(this).is(":checked"));
                        outStockTable.column($(this).attr("size-name")).visible($(this).is(":checked"));
                    });
                    $("#size-modal").modal("hide");
                }
            }
        });
    });

    $("input[type=text]").keypress(function(e) {
        if (e.which == 13) {
            initTables();
        }
    })
    $("#btn_search").on("click", function() {
        $("div.loading").css("display", "block");
        initTables();
    });
    $("#btn_clear").on("click", function() {
        $("input[type=text]").val("");
        $("input[type=date]").val(getFormattedDate());
        $("div.loading").css("display", "block");
        initTables();
    });
    
});
