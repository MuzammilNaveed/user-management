$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    

    //for insert user record
    $("#addRecord").submit(function(e) {
        e.preventDefault();

        let form_data = new FormData(this);
        let status = 0;

        $("#status").is(":checked") ? (status = 1) : (status = 0);
        form_data.append("status", status);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            url: create_users,
            data: form_data,
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(data) {
                $("#save").hide();
                $("#process").show();
            },
            success: function(data) {
                console.log(data, "a");

                if ((data.status == 200) & (data.success == true)) {

                    $("#addRecord")[0].reset();
                    $("addRecordModal").modal("hide");
                    getAllUsers();

                }
                
            },
            complete: function(data) {
                $("#save").show();
                $("#process").hide();
            },
            error: function(e) {
                console.log(e);
                $("#save").show();
                $("#process").hide();
            }
        });
    });

    //for insert user record
    $("#editRecord").submit(function(e) {
        e.preventDefault();

        let form_data = new FormData(this);
        let status = 0;

        $("#editstatus").is(":checked") ? (status = 1) : (status = 0);
        form_data.append("status", status);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            url: update_user,
            data: form_data,
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(data) {
                $("#upsave").hide();
                $("#upprocess").show();
            },
            success: function(data) {

                if ((data.status == 200) & (data.success == true)) {

                    $("#editRecord")[0].reset();
                    $("#updateModal").modal("hide");
                    getAllUsers();
                    notyf.success(data.message);

                }else{
                    notyf.error(data.message);
                }
                
            },
            complete: function(data) {
                $("#upsave").show();
                $("#upprocess").hide();
            },
            error: function(e) {
                console.log(e);
                $("#upsave").show();
                $("#upprocess").hide();
            }
        });
    });

    getAllUsers();
});

function getAllUsers() {
    $.ajax({
        type: "GET",
        url: get_all_users,
        dataType: "json",
        beforeSend: function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "users");
            $("#counts").text(data.length);

            $("#user_table")
                .DataTable()
                .destroy();
            $.fn.dataTable.ext.errMode = "none";
            var tbl = $("#user_table").DataTable({
                data: data,
                pageLength: 25,
                bInfo: true,
                paging: true,
                columns: [
                    {
                        data: null,
                        defaultContent: ""
                    },
                    {
                        render: function(data, type, full, meta) {
                            let img = `<img src="/users/`+ full.profile_pic + `" style="width:80px;height:50px" class="img-fluid rounded">`;

                            return full.profile_pic != null ? img : '<span class="text-danger small">No image</span>' ;
                        }
                    },
                     {
                        render: function(data, type, full, meta) {
                            return full.created_at != null ? moment(full.created_at).format("DD-MM-YYYY") : '<span class="text-danger small">Not Provided</span>';
                        }
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "role_id"
                    },
                    {
                        render: function(data, type, full, meta) {
                            let active = `<span class="badge text-white bg-success">Active</span>`;
                            let deactive = `<span class="badge text-white bg-danger">De-Active</span>`;
                            return full.status == 1 ? active : deactive;
                        }
                    },
                    {
                        render: function(data, type, full, meta) {
                            let fb = full.facebook != null ? full.facebook : ' ';
                            let insta = full.instagram != null ? full.instagram : ' ';
                            let link = full.linkedin != null ? full.linkedin : ' ';
                            let twt = full.twitter != null ? full.twitter : ' ';
                            let add = full.address != null ? full.address : ' ';
                            let ph = full.phone != null ? full.phone : ' ';
                            let img = full.profile_pic != null ? full.profile_pic : ' ';
                            return (
                                `
                                <div class="d-flex justify-content-center">
                                    <button data-toggle="tooltip" data-placement="top" title="Reset IP" onclick="resetIpAddress(`+ full.id + `)" type="button" class="btn btn-success ml-2 mr-2 card_shadow round">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                    <button  data-toggle="tooltip" data-placement="top" title="Edit User" onclick="viewRecord(`+full.id +`,'` +full.role_id +`','` +full.name +`','` + full.email +`','` + full.status +`','` + ph +`',
                                        '` + add +`','` + fb +`','` + twt +`','` + insta +`','` + link +`','` + img +`')" type="button" class="btn btn-primary card_shadow round">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button  data-toggle="tooltip" data-placement="top" title="Delete User" onclick="deleteRecord(`+ full.id + `)" type="button" class="btn btn-danger ml-2 card_shadow round">
                                        <i class="fas fa-trash"></i>
                                    </button>
                            
                        </div>`
                            );
                        }
                    }
                ]
            });

            tbl.on("order.dt search.dt", function() {
                tbl.column(0, {
                    search: "applied",
                    order: "applied"
                })
                    .nodes()
                    .each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
            }).draw();
        },
        complete: function(data) {
            $(".loader_container").hide();
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(e) {
            console.log(e);
        }
    });
}

function viewRecord(id,role_id,name,email,status, phone,address, facebook,twitter,instagram,linkedin,profile) {
    $("#updateModal").modal("show");

    $("#id").val(id);

    $("#username").text(name);
    $("#name").val(name);
    $("#email").val(email);
    $("#phone").val(phone);
    $("#address").val(address);

    $("#facebook").val(facebook);
    $("#instagram").val(twitter);
    $("#twitter").val(instagram);
    $("#linkedin").val(linkedin);
    $("#role_id").val(role_id).trigger('change');

    status == 1 ? $("input[name='editstatus']").prop("checked",true) : $("input[name='editstatus']").prop("checked",false);
    
    $("#profile_pic").html(`<div class="form-group">
        <input type="file" class="form-control dropify" data-default-file="`+image_path +'/'+ profile+`" name="edit_profile_pic" data-allowed-file-extensions="png jpg jpeg">
    </div>`);
  $('.dropify').dropify();
}

function deleteRecord() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.isConfirmed) {
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
    });
}


function resetIpAddress(id) {

    Swal.fire({
        title: "Are you sure?",
        text: "You won't reset this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, reset it!"
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: rest_user_ip,
                data: {id:id},
                dataType: "JSON",
                beforeSend: function(data) {
                },
                success: function(data) {
                    console.log(data, "a");
                    if ((data.status == 200) & (data.success == true)) {
                        
                        notyf.success(data.message);
                        getAllUsers();
    
                    }else{
                        notyf.error(data.message);
                    }
                },
                complete: function(data) {
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    });

}