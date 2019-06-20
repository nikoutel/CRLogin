
/**
 *
 * This is a TEMPORARY SCRIPT. Its just a quick install solution.
 * A new, more dynamic and configurable application is on its way.
 * 
 * 
 * @package CRLogin
 * @subpackage install
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013-2019 Nikos Koutelidis
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link https://github.com/nikoutel/CRLogin 
 * 
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * 
 */

$(document).ready(function() {

    $('#jsEnabledMsg').html('Javascript is enabled');
    $('#jsEnabled').html('OK');
    $('#jsEnabled').attr('class', 'greenb');
    $('#choosedb').change(function() {
        if ($(this).val() === 'sqlite3') {
            $('#choosedbmsg').html('sqlite is not recommended');
        } else {
            $('#choosedbmsg').html('');
        }
    });
    $("#create").click(function() {
        var filename = $("#filename").val();
        var inform = $("#inform").val();
        $.post(
                "install_request.php?action=create",
                {filename: filename, inform: inform},
        function(data) {
            if (data === 'ok')
                location.reload();
            else
                $("#creates").html(data);

        }
        )
        return false;
    });
    $("#next").click(function() {

        $('#nexts').load('install_form.php', {db: $('#choosedb').val(), lang: $('#lang').val()}, function() {
            $(".secheader").hide();
        });

        return false;
    });
    $("#forma").click(function() {
        $("#wait").html('waiting...');
        var rootUser = $("#rootuser").val();
        var rootPass = $("#rootpass").val();
        var host = $("#host").val();
        var port = $("#port").val();

        valerror = false;
        $("#rootusermsg").html('');
        if ($.trim($("#rootuser").val()) == '') {

            $("#rootusermsg").html('Should not be empty');
            $("#wait").html('');
            valerror = true;
        }
        $("#hostmsg").html('');
        if ($.trim($("#host").val()) == '') {
            $("#hostmsg").html('Should not be empty');
            $("#wait").html('');
            valerror = true;
        }
        $("#portmsg").html('');
        if ($.trim($("#port").val()) == '') {
            $("#portmsg").html('Should not be empty');
            $("#wait").html('');
            valerror = true;
        } else {
            if (!$.isNumeric($("#port").val())) {
                $("#portmsg").html('Not a port number');
                $("#wait").html('');
                valerror = true;
            }
        }
        $("#database_namemsg").html('');
        if ($.trim($("#database_name").val()) == '') {
            $("#database_namemsg").html('Should not be empty');
            $("#wait").html('');
            valerror = true;
        }
        $("#usermsg").html('');
        if ($.trim($("#user").val()) == '') {
            $("#usermsg").html('Should not be empty');
            $("#wait").html('');
            valerror = true;
        }
        $("#loginformmsg").html('');
        if ($.trim($("#loginform").val()) == '') {
            $("#loginformmsg").html('Should not be empty');
            $("#wait").html('');
            valerror = true;
        } else if (!isUrlValid($("#loginform").val())) {
            $("#loginformmsg").html('URL is not valid');
            $("#wait").html('');
            valerror = true;
        }
        $("#successredirectmsg").html('');
        if ($.trim($("#successredirect").val()) == '') {
            $("#successredirectmsg").html('Should not be empty');
            $("#wait").html('');
            valerror = true;
        } else if (!isUrlValid($("#successredirect").val())) {
            $("#successredirectmsg").html('URL is not valid');
            $("#wait").html('');
            valerror = true;
        }
        if (valerror)
            return false;
        var databaseName = $("#database_name").val();
        var user = $("#user").val();
        var userPass = $("#userpass").val();
        var inform = $("#inform").val();
        var loginform = $("#loginform").val();
        var successredirect = $("#successredirect").val();

        $.post(
                "install_request.php?action=form",
                {rootuser: rootUser,
                    rootpass: rootPass,
                    host: host,
                    port: port,
                    database_name: databaseName,
                    user: user,
                    userpass: userPass,
                    inform: inform,
                    loginform: loginform,
                    successredirect, successredirect
                },
        function(data) {
            $("#wait").html('');
            $("#errormsg").html('');
            $("#msg").html('');
            var arr = data.split('<br />');


            $.each(arr, function(index, value) {


                if (value.indexOf("error") !== -1) {
                    $("#errormsg").append(value);
                    $("#msg").append('<br />');


                }
                else {
                    $("#msg").append(value);
                    $("#msg").append('<br />');

                }
            });
            $('#returnlink').load('install_form_mysql.php #returnlink');
        }

        );
        return false;
    });
    $('#refresh').click(function() {
        location.reload();
        return false;
    });
});

function isUrlValid(url) {
    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)*(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}