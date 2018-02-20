function init() {    
    $.ajax({
        url: '/colors',
        type: 'get',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json",
        success: function(res) {
            let colors = res.data, content = "";
            colors.forEach((color, index) => {
                content += `<div class="form-group row">
                                <label for="country" class="col-sm-4 text-right control-label col-form-label">`+color.name+` :</label>
                                <div class="col-sm-8">
                                    <input type="color" id="color`+index+`" name="color" value="`+color.color+`">&nbsp;&nbsp;&nbsp;
                                    <label id="label`+index+`">`+color.color+`</label>
                                </div>
                            </div>`;
            });

            $(".form-color").find(".modal-body").html(content);
            
            $("input[type=color]").on("change", function() {
                $("#label0").text($("#color0").val());
                $("#label1").text($("#color1").val());
                $("#label2").text($("#color2").val());
            });
        }
    });
}
$(document).ready(function() {
    init();

    let color_table = $("#color-table").DataTable({
        responsive: true,
        ajax: {
            url: "/colors"
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
                data: "color"
            }
        ],
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                render: function(color) {
                    return (
                        `
                        <div 
                          style="display: flex;
                            justify-content: left;
                            align-items: center;"
                        >
                          <div style="background:` + color + `;border-radius:5px;text-align:center;width:20px;display: inline-block;">&nbsp;</div>
                          &nbsp;<span>` + color + `</span>
                        </div>
                    `
                    );
                }
            }
        ],
        order: [[0, "asc"]]
    });

    $(".form-color").on("submit", function(e) {
        e.preventDefault();

        let colors = [
            {
                name: '0',
                color: $("#color0").val()
            },
            {
                name: '1',
                color: $("#color1").val()
            },
            {
                name: '2+',
                color: $("#color2").val()
            }
        ];

        $.ajax({
            url: '/colors',
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                colors: JSON.stringify(colors)
            },
            dataType: "json",
            success: function(data) {
                color_table.ajax.reload();
                $("#color-modal").modal("hide");
                init();
            }
        });
    });
});
