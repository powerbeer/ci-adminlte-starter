$(document).ready(function () {


    $.copyForm = function (copyId, copyToId) {
        $("#" + copyToId).val($("#" + copyId).val());
    }

    $.addSelectOption = function (id_select, optionValue, optionText) {
        $('#' + id_select).append('<option value="' + optionValue + '"  >' + optionText + '</option>');
    }


    $.messageAlert = function (alert_lib, message_type, vtitle, messsage, url_redirect) {
        if (alert_lib == 'swal') {
            console.log("url_redirect==" + url_redirect);
            if (typeof (url_redirect) != "undefined") {
                swal({
                    icon: message_type,
                    title: vtitle,
                    text: messsage
                }, function () {
                    window.location = url_redirect;
                });
            } else {
                swal({
                    icon: message_type,
                    title: vtitle,
                    text: messsage
                });
            }
        } else if (alert_lib == 'swal_html') {
            // console.log("show swal html!!");
            swal({
                icon: message_type,
                title: vtitle,
                content: {
                    element: 'div',
                    innerHTML: messsage
                }
            }
            );
        } else if (alert_lib == 'swal_not_click') {
            // console.log("show swal_not_click");
            swal({
                title: messsage,
                showCancelButton: false,
                showConfirmButton: false
            });
        } else if (alert_lib == 'message_alert') {
            // console.log("show message alert");
            $("#id_message_alert").html(messsage);
        } else {
            console.log("else show toard### ");
            toastr.info(messsage);
        }
    }

    $.confirmDeleteMessage = function (url) {

        swal({
            title: "กรุณายืนยันการลบข้อมูลนี้?",
            text: "คุณต้องการลบข้อมูลนี้จริงใช้หรือไม่",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function (willDelete) {
            if (willDelete) {
                swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Your imaginary file is safe!");
            }
        });

    }



 $.clear_modal_backdrop = function () {
        $('.modal-backdrop').remove();
    }
});

function openURLModal(vurl){
      $('#id_modal').load(url, function () {
        console.log("load url success!!!!");
    });

}


function loadHtml(id_, html) {
    $("#" + id_).load(html);
}

function createModalDiv() {
    //console.log("########createModalDiv########");
    $(".main").prepend("<div id=\"id_modal\"></div>");

}

function loadURLModalJS(url) {
    // console.log("########loadURLModal ########" + url);
    $('#id_modal').load(url, function () {
        console.log("load url success!!!!");
    });
}


function loadTable(url, id_table) {

    $('#' + id_table).load(url, function () {

    });
}

function gotoURL(v_main_url, v_sub_url) {
    window.document.location.href = v_main_url + v_sub_url;
}

function gotoURLPage(v_url) {
    window.document.location.href = v_url;
}


function ResizeImage(id_resize) {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        var filesToUploads = document.getElementById(id_resize).files;
        var file = filesToUploads[0];
        if (file) {

            var reader = new FileReader();
            // Set the image once loaded into file reader
            reader.onload = function (e) {

                var img = document.createElement("img");
                img.src = e.target.result;

                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);

                var MAX_WIDTH = 400;
                var MAX_HEIGHT = 400;
                var width = img.width;
                var height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, width, height);

                dataurl = canvas.toDataURL(file.type);
                document.getElementById(id_resize).src = dataurl;
            }
            reader.readAsDataURL(file);

        }

    } else {
        alert('The File APIs are not fully supported in this browser.');
    }

}

