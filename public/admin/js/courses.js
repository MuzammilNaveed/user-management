$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    // for add record 
    $("#addCourse").submit(function(e) {
        e.preventDefault();
        
        var form_data = new FormData(this);
        var action = $(this).attr('action');
        var method = $(this).attr('method');
        
        var hours = $("#hours").val();
        var mins = $("#mins").val();

        if(hours == '' || hours == 00) {
            $("#hours_error").html("please select the hours");
            $("#hours").parent().css('border','1px solid red');
        }else{
            form_data.append("duration", hours + ":" + mins);
            $("#hours_error").html("");
            $("#hours").parent().css('border','none');

            $.ajax({
                type: method,
                url:action,
                data: form_data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if ((data.status == 200) & (data.success == true)) {
                        notyf.success(data.message);
                        $("#addCourseModal").modal('hide');
                        $("#addCourse")[0].reset();
                        $('.dropify-clear').click();
                        $("#type").val("").trigger('change');
                    } else {
                        notyf.error(data.message);
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }


    
    });

    // for update record 
    $("#updateCourse").submit(function(e) {
        e.preventDefault();
        
        var form_data = new FormData(this);
        var action = $(this).attr('action');
        var method = $(this).attr('method');

        var id = $("#id").val();
        
        var hours = $("#up_hours").val();
        var mins = $("#up_mins").val();

        if(hours == '' || hours == 00) {
            $("#up_hours_error").html("please select the hours");
            $("#up_hours").parent().css('border','1px solid red');
        }else{
            form_data.append("duration", hours + ":" + mins);
            form_data.append("id",id);
            $("#up_hours_error").html("");
            $("#up_hours").parent().css('border','none');

            $.ajax({
                type: method,
                url:action,
                data: form_data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if ((data.status == 200) & (data.success == true)) {
                        notyf.success(data.message);
                        $("#editCourseModal").modal('hide');
                        getAllCourses();
                    } else {
                        notyf.error(data.message);
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }


    
    });


    getAllCourses();


});


function getAllCourses() {

    $.ajax({
        type: "GET",
        url: get_courses,
        beforeSend:function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "a");

            $("#counts").text(data.length);
            $('#showRecord').DataTable().destroy();
            $.fn.dataTable.ext.errMode = 'none';
            var tbl = $('#showRecord').DataTable({
                data: data,
                "pageLength":25,
                "bInfo": true,
                "paging": true,
                columns: [{
                    "data": null,
                    "defaultContent": ""
                },
                {
                    "render": function (data, type, full, meta) {
                        let img = `<img src="/course_img/`+ full.thumbnail + `" style="width:80px;height:50px" class="img-fluid rounded">`;
                        return full.thumbnail != null ? img : '<span class="text-danger small">No image</span>' ;
                    }
                },
                {
                    "data" : "title",
                },
                {
                    "data" : "type",
                },
                {
                    "data" : "duration",
                },
                {
                    "render": function (data, type, full, meta) {
                        return ` <div class="d-flex justify-content-center">
                            <button onclick="viewRecord(`+ full.id +`, '`+full.title+`','`+full.type+`','`+full.duration+`','`+full.thumbnail+`')" type="button" class="btn btn-primary card_shadow round" title="Edit"><i class="material-icons" style="font-size:15px">edit</i> Edit</button>
                            <button onclick="deleteRecord(`+full.id+`)" type="button" class="btn btn-danger ml-2 card_shadow round" title="Delete"><i class="material-icons" style="font-size:15px">delete</i> Delete</button>
                        </div>`
                    }
                },
                ],
            });

            tbl.on('order.dt search.dt', function () {
                tbl.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        },
        complete:function(data) {
            $(".loader_container").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });
}


function viewRecord(id,title,type,duration, pic) {

    var time = duration.split(':');
    $("#updateModal").modal('show');
    $("#id").val(id)
    $("#up_title").val(title)
    $("#up_type").val(type).trigger('change');
    $("#up_hours").val(time[0]);
    $("#up_mins").val(time[1]);



    $("#thumbnail").html(`<div class="form-group">
        <input type="file" class="form-control dropify" data-default-file="`+image_path +'/'+ pic+`" name="edit_profile_pic" data-allowed-file-extensions="png jpg jpeg">
    </div>`);
    $('.dropify').dropify();

    $("#editCourseModal").modal('show');
}