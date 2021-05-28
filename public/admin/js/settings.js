$(document).ready(function() {

    // change password call
    $("#changePasswordForm").submit(function(event) {
        event.preventDefault();

        let action = $(this).attr('action');
        let method = $(this).attr('method');

        let password = $("#password").val();
        let confirm_password = $("#confirm_password").val();

        if( $.trim(password) != $.trim(confirm_password) ) {
            alert("not matched");
        }else{
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: action,
                type: method,
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                },
                error: function(e) {
                    console.log(e)
                }
    
            });
        }

    });


    // change password call
    $("#settingForm").submit(function(event) {
        event.preventDefault();

        let action = $(this).attr('action');
        let method = $(this).attr('method');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: action,
            type: method,
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
                $("#sysBtn").hide();
                $("#sys_process").show();
            },  
            success: function(data) {
                console.log(data);
                if ((data.status == 200) & (data.success == true)) {
                    notyf.success(data.message);
                }else{
                    notyf.error(data.message);
                }
            },
            complete:function(data) {
                $("#sysBtn").show();
                $("#sys_process").hide();
            },
            error: function(e) {
                console.log(e);
                $("#sysBtn").show();
                $("#sys_process").hide();
            }

        });

    });


});