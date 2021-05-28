$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    // for add record 
    $("#addLecture").submit(function(e) {
        e.preventDefault();
        
        var form_data = new FormData(this);
        var action = $(this).attr('action');
        var method = $(this).attr('method');
        
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
                        $("#addLectureModal").modal('hide');
                        getAllLectures();
                    } else {
                        notyf.error(data.message);
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
    });

    // for update record 
    $("#updateLecture").submit(function(e) {
        e.preventDefault();
        
        var form_data = new FormData(this);
        var action = $(this).attr('action');
        var method = $(this).attr('method');

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
                    $("#updateLectureModal").modal('hide');
                    getAllLectures();
                } else {
                    notyf.error(data.message);
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    });


    getAllLectures();


});


function getAllLectures() {

    $.ajax({
        type: "GET",
        url: get_lecture,
        beforeSend:function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "a");

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
                    "data" : "title",
                },
                {
                    "data" : "instructor",
                },
                {
                    "data" : "video_url",
                },
                {
                    "data" : "course_id",
                },
                {
                    "data" : "description",
                },
                {
                    "render": function (data, type, full, meta) {
                        return ` <div class="d-flex justify-content-center">
                            <button onclick="viewRecord(`+ full.id +`, '`+full.title+`','`+full.instructor+`','`+full.video_url+`','`+full.course_id+`','`+full.description+`')" type="button" class="btn btn-primary card_shadow round" title="Edit"><i class="material-icons" style="font-size:15px">edit</i> Edit</button>
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


function viewRecord(id,title,instructor,video_url, course_id,description) {

    $("#updateModal").modal('show');
    $("#id").val(id)
    $("#title").val(title)
    $("#course_id").val(course_id).trigger('change');
    $("#Instructor").val(instructor).trigger('change');
    $("#url").val(video_url);
    $("#description").val(description);

    $("#updateLectureModal").modal('show');
}