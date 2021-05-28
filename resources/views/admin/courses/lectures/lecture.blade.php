@extends('admin.layout.master')
@section('page_title','Add Lectures')
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
          <div class="card-title font-weight-bolder">Lectures List</div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group">
                <button class="btn btn-primary" id="btn-add-new-user" data-toggle="modal" data-target="#addLectureModal"><i class="material-icons">add</i> Add Lecture</button>
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
                  <th>Title</th>
                  <th>Instructor</th>
                  <th>Video URL</th>
                  <th>Course</th>
                  <th>Description</th>
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
<div class="modal fade stick-up" id="addLectureModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Add</span> <span class="text-primary font-weight-bold">Lecture</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2">
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form id="addLecture" method="POST" action="{{url('save_lecture')}}" enctype="multipart/form-data">

                <div class="form-group form-group-default">
                    <label class="text-muted">Title</label>
                    <input type="text" name="title" class="form-control input-sm" placeholder="Lecture Title">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="dropdowns">
                            <div class="form-group form-group-default form-group-default-select2">
                            <label class="text-muted" style="z-index:9999">Course</label>
                            <select class="full-width select2-hidden-accessible input-sm" name="course_id" data-placeholder="Select Course" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                                <option value="">Select</option>
                                    @foreach($courses as $course) 
                                    <option value="{{$course->id}}">{{$course->title}}</option>
                                    @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdowns">
                            <div class="form-group form-group-default form-group-default-select2">
                            <label class="text-muted" style="z-index:9999">Instructor</label>
                            <select class="full-width select2-hidden-accessible input-sm" name="instructor" data-placeholder="Select Instructor" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                                <option value="">Select</option>
                                <option value="ali">Ali </option>
                                <option value="rehan">Rehan</option>
                            </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-default">
                    <label class="text-muted">URL</label>
                    <input type="text" name="video_url" class="form-control input-sm" placeholder="Video URL">
                </div>

                <div class="form-group form-group-default">
                    <label class="text-muted">Description</label>
                    <textarea name="description" cols="30" style="height:50px" rows="10" class="form-control input-sm" placeholder="Lecture Description"></textarea>
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


<!-- add modal -->
<div class="modal fade stick-up" id="updateLectureModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Update</span> <span class="text-primary font-weight-bold">Lecture</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2">
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form id="updateLecture" method="POST" action="{{url('update_lecture')}}" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="form-group form-group-default">
                    <label class="text-muted">Title</label>
                    <input type="text" name="title" id="title" class="form-control input-sm" placeholder="Lecture Title">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="dropdowns">
                            <div class="form-group form-group-default form-group-default-select2">
                            <label class="text-muted" style="z-index:9999">Course</label>
                            <select class="full-width select2-hidden-accessible input-sm" id="course_id" name="course_id" data-placeholder="Select Course" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                                <option value="">Select</option>
                                    @foreach($courses as $course) 
                                    <option value="{{$course->id}}">{{$course->title}}</option>
                                    @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdowns">
                            <div class="form-group form-group-default form-group-default-select2">
                            <label class="text-muted" style="z-index:9999">Instructor</label>
                            <select class="full-width select2-hidden-accessible input-sm" id="Instructor" name="instructor" data-placeholder="Select Instructor" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                                <option value="">Select</option>
                                <option value="ali">Ali </option>
                                <option value="rehan">Rehan</option>
                            </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-default">
                    <label class="text-muted">URL</label>
                    <input type="text" name="video_url" id="url" class="form-control input-sm" placeholder="Video URL">
                </div>

                <div class="form-group form-group-default">
                    <label class="text-muted">Description</label>
                    <textarea name="description" id="description" cols="30" style="height:50px" rows="10" class="form-control input-sm" placeholder="Lecture Description"></textarea>
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
<script src="{{asset('admin/js/lectures.js')}}"></script>
<script>
    var get_lecture = "{{url('get_lecture')}}";
    
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