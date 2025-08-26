$(document).ready(function () {
    "use strict";
    select2();
    datatable();
    ckediter();
    setInterval(() => {
        feather.replace();
    }, 1000);
});

$(document).on("click", ".customModal", function (e) {
    "use strict";
    e.preventDefault();
    var modalTitle = $(this).data("title");
    var modalUrl = $(this).data("url");
    var modalSize = $(this).data("size") == "" ? "md" : $(this).data("size");
    var originalText = $(this).html();
    var $button = $(this);

    // Show loader on button
    $button.html('<i class="ti ti-loader ti-spin"></i> Loading...');
    $button.prop('disabled', true);

    $("#customModal .modal-title").html(modalTitle);
    $("#customModal .modal-dialog").addClass("modal-" + modalSize);
    $("#customModal .body").html('<div class="text-center p-5"><i class="ti ti-loader ti-spin"></i></div>');

    $.ajax({
        url: modalUrl,
        success: function (result) {
            if (result.status == "error") {
                notifier.show(
                    "Error!",
                    result.messages,
                    "error",
                    errorImg,
                    4000
                );
            } else {
                $("#customModal .body").html(result);
                $("#customModal").modal("show");
                select2();
                ckediter();
            }
        },
        error: function (result) {
            $("#customModal .body").html('<div class="alert alert-danger">Failed to load content.</div>');
        },
        complete: function() {
            // Restore original button state
            $button.html(originalText);
            $button.prop('disabled', false);
        }
    });
});


$(document).on("click", ".customModal-2", function () {
    "use strict";
    var modalTitle = $(this).data("title");
    var modalUrl = $(this).data("url");
    var modalSize = $(this).data("size") == "" ? "md" : $(this).data("size");
    $("#customModal-2 .modal-title").html(modalTitle);
    $("#customModal-2 .modal-dialog").addClass("modal-" + modalSize);
    $.ajax({
        url: modalUrl,
        success: function (result) {
            if (result.status == "error") {
                notifier.show(
                    "Error!",
                    result.messages,
                    "error",
                    errorImg,
                    4000
                );
            } else {
                $("#customModal-2 .body").html(result);
                $("#customModal-2").modal("show");
                select2();
                ckediter();
                $("#customModal").modal("hide");
            }
        },
        error: function (result) {},
    });
});

// basic message
$(document).on("click", ".confirm_dialog", function (e) {
    "use strict";
    var title = $(this).attr("data-dialog-title");
    if (title == undefined) {
        var title = "Are you sure you want to delete this record ?";
    }
    var text = $(this).attr("data-dialog-text");
    if (text == undefined) {
        var text = "This record can not be restore after delete. Do you want to confirm?";
    }
    var dialogForm = $(this).closest("form");
    Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((data) => {
        if (data.isConfirmed) {
            dialogForm.submit();
        }
    });
});

// common
$(document).on("click", ".common_confirm_dialog", function (e) {
    "use strict";
    var dialogForm = $(this).closest("form");
    var actions = $(this).data("actions");
    Swal.fire({
        title: "Are you sure you want to delete " + actions + " ?",
        text:
            "This " +
            actions +
            " can not be restore after delete. Do you want to confirm?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((data) => {
        if (data.isConfirmed) {
            dialogForm.submit();
        }
    });
});

$(document).on("click", ".fc-day-grid-event", function (e) {
    "use strict";
    e.preventDefault();
    var event = $(this);
    var modalTitle = $(this).find(".fc-content .fc-title").html();
    var modalSize = "md";
    var modalUrl = $(this).attr("href");
    $("#customModal .modal-title").html(modalTitle);
    $("#customModal .modal-dialog").addClass("modal-" + modalSize);
    $.ajax({
        url: modalUrl,
        success: function (result) {
            $("#customModal .modal-body").html(result);
            $("#customModal").modal("show");
        },
        error: function (result) {},
    });
});

function toastrs(title, message, status) {
    "use strict";
    if (status == "success") {
        notifier.show("Success!", message, "success", successImg, 4000);
    } else {
        notifier.show("Success!", message, "success", errorImg, 4000);
    }
}

function convertArrayToJson(form) {
    "use strict";
    var data = $(form).serializeArray();
    var indexed_array = {};

    $.map(data, function (n, i) {
        indexed_array[n["name"]] = n["value"];
    });

    return indexed_array;
}

function select2() {
    "use strict";
    if ($(".basic-select").length > 0) {
        $(".basic-select").each(function () {
            var basic_select = new Choices(this, {
                searchEnabled: false,
                removeItemButton: false,
            });
        });
    }

    if ($(".hidesearch").length > 0) {
        $(".hidesearch").each(function () {
            var basic_select = new Choices(this, {
                searchEnabled: false,
                removeItemButton: true,
            });
        });
    }
}

function ckediter(editer_id = "") {
    if (editer_id == "") {
        editer_id = "#classic-editor";
    }
    if ($(editer_id).length > 0) {
        ClassicEditor.create(document.querySelector(editer_id), {
            // Add configuration options here
            // height: '300px', // Example height, adjust as needed
        })
            .then((editor) => {
                // Set the minimum height directly // editor.ui.view.editable.element.style.minHeight = '300px';
            })
            .catch((error) => {
                console.error(error);
            });
    }
}
function datatable() {
    "use strict";

    if ($(".basic-datatable").length > 0) {
        $(".basic-datatable").DataTable({
            scrollX: true,
            dom: "Bfrtip",
            buttons: ["copy", "csv", "excel", "print"],
        });
    }

    if ($(".advance-datatable").length > 0) {
        $(".advance-datatable").DataTable({
            scrollX: true,
            stateSave: false,
            fixedColumns: {
        leftColumns: 3
    },
            dom: '<"top"Bf>rt<"bottom"lip><"clear">',
         //   dom: "lBfrtip", // 'l' adds the page length dropdown
            pageLength: 15, // ✅ Show 30 entries per page by default
            lengthMenu: [
                [10, 25, 30, 50, 100, -1],
                [10, 25, 30, 50, 100, "All"]
            ], // ✅ dropdown options
            buttons: [
                {
                    extend: "excelHtml5",
                    exportOptions: {
                        columns: ":visible",
                    },
                    className: "btn btn-md btn-light"
                },
                {
                    extend: "pdfHtml5",
                    exportOptions: {
                        columns: ":visible",
                    },
                    className: "btn btn-md btn-light"
                },
                {
                    extend: "copyHtml5",
                    exportOptions: {
                        columns: ":visible",
                    },
                    className: "btn btn-md btn-light"
                },
                {
                    extend: "colvis",
                    className: "btn btn-md btn-light"
                },
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            responsive: true,
            order: [[0, "desc"]]
        });
    }
}
