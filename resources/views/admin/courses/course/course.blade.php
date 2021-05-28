@extends('admin.layout.master')
@section('page_title','Add Courses')
@section('container')
<style>

.form-group-default.form-group-default-select2 .select2-container .select2-selection--single {
    padding-top:12px;
    height:48px;
}
</style>
<div class="row mt-2">
  <div class="container-fluid">
    <div class="bg-white">
      <div class="card card-transparent">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">Courses List</div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group">
                <button class="btn btn-primary" id="btn-add-new-user" data-toggle="modal" data-target="#addCourseModal"><i class="material-icons">add</i> Add Course</button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100 text-center" id="showRecord">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Thumbnail</th>
                  <th>Course Title</th>
                  <th>Course Type</th>
                  <th>Course Duration</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="loader_container" style="display:none">
          <div class="loader"></div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- add modal -->
<div class="modal fade stick-up" id="addCourseModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Add</span> <span class="text-primary font-weight-bold">Course</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2">
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form id="addCourse" method="POST" action="{{url('save_course')}}" enctype="multipart/form-data">

              <div class="form-group form-group-default" id="menu-title">
                  <label class="text-muted">Title</label>
                  <input type="text" name="title" class="form-control input-sm" placeholder="Course Title">
              </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="dropdowns">
                        <div class="form-group form-group-default form-group-default-select2">
                        <label class="text-muted" style="z-index:9999">Course Type </label>
                        <select class="full-width select2-hidden-accessible input-sm" id="type" name="type" data-placeholder="Select Course Type" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                            <option value="">Select</option>
                            <option value="video">Video</option>
                            <option value="theory">Theory</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label class="text-muted">Hours</label>
                                <input type="number" id="hours" min="0" max="12" class="form-control input-sm" placeholder="00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label class="text-muted">Minutes</label>
                                <input type="number" id="mins" min="0" max="60"  class="form-control input-sm" placeholder="00">
                            </div>
                        </div>
                        <span class="text-danger small" id="hours_error"></span>
                    </div>
                    
                </div>
            </div>

            <div class="col-md-6 pl-0">
              <div class="form-group">
                <input type="file" class="form-control dropify" name="thumbnail" data-allowed-file-extensions="png jpg jpeg">
              </div>
            </div>

              <div class="form-group mt-3">
                <button type="submit" class="btn btn-success btn-lg text-white">Save</button>
                <button class="btn btn-danger btn-lg text-white" data-dismiss="modal"> Close</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- edit modal -->
<div class="modal fade stick-up" id="editCourseModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Edit </span> <span class="text-primary font-weight-bold">Course</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2">
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form id="updateCourse" method="POST" action="{{url('update_course')}}" enctype="multipart/form-data">
              <input type="hidden" id="id">
              <div class="form-group form-group-default" id="menu-title">
                  <label class="text-muted">Title</label>
                  <input type="text" name="title" id="up_title" class="form-control input-sm" placeholder="Course Title">
              </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="dropdowns">
                        <div class="form-group form-group-default form-group-default-select2">
                        <label class="text-muted" style="z-index:9999">Course Type </label>
                        <select class="full-width select2-hidden-accessible input-sm" id="up_type" name="type" data-placeholder="Select Course Type" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                            <option value="">Select</option>
                            <option value="video">Video</option>
                            <option value="theory">Theory</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label class="text-muted">Hours</label>
                                <input type="number" id="up_hours" min="0" max="12" class="form-control input-sm" placeholder="00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label class="text-muted">Minutes</label>
                                <input type="number" id="up_mins" min="0" max="60"  class="form-control input-sm" placeholder="00">
                            </div>
                        </div>
                        <span class="text-danger small" id="up_hours_error"></span>
                    </div>
                    
                </div>
            </div>

            <div class="col-md-6 pl-0" id="thumbnail">
            </div>

              <div class="form-group mt-3">
                <button type="submit" class="btn btn-success btn-lg text-white">Save</button>
                <button class="btn btn-danger btn-lg text-white" data-dismiss="modal"> Close</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




@endsection
@section('scripts')
<script src="{{asset('admin/js/courses.js')}}"></script>
<script>
    var get_courses = "{{url('get_courses')}}";
    let image_path = "{{asset('course_img')}}";
    
   $('.dropify').dropify({
    messages: {
      'default': 'Course Thumbail',
      'replace': 'Drag and drop or click to replace',
      'remove': 'Remove',
      'error': 'Ooops, something wrong happended.'
    }
  });

</script>
@show