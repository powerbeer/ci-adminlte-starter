$(document).ready(function () {

    toJsonObject = function (id_form) {
        var formdata = $("#" + id_form).serializeArray();
        //console.log(formdata);

        var data = {};
        $(formdata).each(function (index, obj) {
            data[obj.name] = obj.value;
        });


        return data;
    }

    $._httpGet = function (url) {

        return $.ajax({
            type: "GET",
            async: false,
            url: url,
            dataType: "json"
        });

    }

    _httpPost = function (url, id_form) {

        var data = toJsonObject(id_form);
        return $.ajax({
            type: "POST",
            url: url,
            data: JSON.stringify(data),
            dataType: "json"
        });

    }


    $._httpSync = function (url, data_json) {

        var data = JSON.parse(data_json);
        var token_key = '';
        var v_token_key = JSON.parse(localStorage.getItem('PbLocalDB.AUTH'));
        if (v_token_key === null) {
            token_key = 'notoken';
        } else {
            token_key = v_token_key['token_key'];
        }
        // console.log(v_token_key);
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'token-key': token_key
            },
            data: JSON.stringify(data),
            dataType: "json"
        });

    }

    _httpPostJson = function (url, data_json) {

        var v_token_key = JSON.parse(localStorage.getItem('PbLocalDB.AUTH'));
        var token_key = 'token';
        //   console.log(v_token_key);
        // if ( v_token_key === null) {
        /*
         if (typeof v_token_key === 'undefined') {
         
         } else {
         if(v_token_key!=''){
         token_key = v_token_key['token_key'];
         }
         }
         
         headers: {
         'token-key': token_key
         },
         */
        var data = JSON.parse(data_json);
        return $.ajax({
            type: "POST",
            url: url,
            data: JSON.stringify(data),
            dataType: "json"
        });

    }

    _httPostMultipleForm = function (v_url_post, id_form) {
        var form = $('#' + id_form)[0];

        // Create an FormData object 
        var data = new FormData(form);


        return $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: v_url_post,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000
        });
    }

    $.httpPost = function (url, id_form, message_type) {
        _httpPost(url, id_form).done(function (res) {
            //console.log(res);
            if (res.message_status == 'error') {
                $.messageAlert(message_type, 'error', 'พบข้อผิดพลาด', res.message);
            } else {

                //console.log(  res);
                if (typeof res.url_redirect === 'undefined') {
                    //  console.log('test!!!!');
                    //toastr.info(res.message);
                    $.messageAlert(message_type, 'success', '', res.message);

                    var v_modal_id = res.modal_id;
                    // console.log('v_modal_id ==='.v_modal_id);
                    if (v_modal_id !== '') {
                        $("#" + v_modal_id).modal('hide');
                        // $('#'+v_modal_id).modal( 'dispose');
                    }

                    if (typeof res.style === 'undefined') {
                        if (res.style === 'popup') {
                            window.opener.location.href = res.url_redirect;
                            setInterval(function () {
                                window.close();
                            }, 3000);
                        }
                    }

                } else {
                    // console.log('redirect !!!!');
                    window.location.href = res.url_redirect;
                }
            }
        });
    }


    $.JSloadTable = function (url, id_table) {
        // $('#'+id_table).loading({ message: 'กำลังโหลด...'});
        $('#' + id_table).load(url, function () {
            //$('#'+id_table).loading('stop');
        });
    }


});
