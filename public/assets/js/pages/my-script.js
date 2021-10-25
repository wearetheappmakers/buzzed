$(document).ready(function () {

    $("#selectall").on('click', function () { // bulk checked
        var status = this.checked;
        $(".allcheckbox").each(function () {
            $(this).prop("checked", status);
        });
    });

    $(document).on("click", ".delete-record", function () {
        if (confirm("Are you sure ?")) {
            var parent = $(this);
            parent.addClass('disabled');
            parent.html('<i class="fa fa-spinner fa-spin"></i>');
            var ids = [];
            ids.push($(this).data('id'));
            DeleteMultiple(ids);
        }
        return false;
    });

    function DeleteMultiple(ids) {
        console.log(ids);
        return false;
        var table = $('#model_name').val();
        var newurl = '';
        var folder_name = $('#folder_name').val();
        if (folder_name == '') {
            newurl = 'model_name=' + table + '&id=' + ids;
        } else {
            newurl = 'model_name=' + table + '&id=' + ids + '&folder_name=' + folder_name;
        }

        $.ajax({
            type: 'GET',
            url: $('#delete_url').val(),
            data: newurl,
            dataType: 'json',
            success: function (data) {
                if (data.status == 'Success') {
                    $(ids).each(function () {
                        $('#row-' + this).remove();
                    });
                    notify(data.message, "success");
                } else {
                    notify(data.message, "success");
                    $('.delete-record').removeClass('disabled');
                    $('.delete-record').html('<i style="color: white;" class="la la-trash"></i >');
                }
                $("#multi-action").removeClass('disabled');
            }
        });
    }

    function ChangeMultiple(ids, field, params) {

        var table = $('#table_name').val();
        $(ids).each(function () {
            $('#' + field + '-' + this).addClass('disabled');
            $('#' + field + '-' + this).html('<i class="fa fa-spinner fa-spin"></i>');
        });
        $.ajax({
            type: 'GET',
            url: $('#status_url').val(),
            data: 'id=' + ids + '&table_name=' + table + '&field=' + field + '&param=' + params,
            dataType: 'json',
            error: function (data) {
                notify("Something went wrong", "danger");
            },
            success: function (data) {
                $(ids).each(function () {

                    if (params == '1') {
                        if (field == 'on_home') {
                            htmlsuc = '<i class="fa fa-home green"></i>';
                        } else {
                            htmlsuc = '<i class="fa fa-check-square-o"></i>';
                        }

                        $('#' + field + '-' + this).attr('href', field + '-1');
                        $('#' + field + '-' + this).html(htmlsuc);
                    } else {
                        if (field == 'on_home') {
                            htmlsuc = '<i class="fa fa-home black"></i>';
                        } else {
                            htmlsuc = '<i class="fa fa-square-o"></i>';
                        }
                        $('#' + field + '-' + this).attr('href', field + '-0');
                        $('#' + field + '-' + this).html(htmlsuc);
                    }
                    $('#' + field + '-' + this).removeClass('disabled');
                    $("#multi-action i").addClass('hide');
                    $("#multi-action").removeClass('disabled');
                });
            }
        });
    }
});