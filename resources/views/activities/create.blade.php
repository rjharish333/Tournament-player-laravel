@extends('layout.mainlayout')
@section('content')
<style type="text/css">
  
  body {
    margin-top:40px;
}
.stepwizard-step p {
    margin-top: 10px;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
</style> 
<div class="page-wrapper">
      <div class="content container-fluid">
      
        <!-- Page Header -->
          <div class="page-header">
            <div class="row">
              <div class="col">
                <h3 class="page-title"><i class="{{$icon}}" style="color: #518c68"></i> Add Activity</h3></h3>
              </div>
            </div>
          </div>
          <!-- /Page Header -->
          
          <div class="row">
            
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-body">
                  @if(session()->has('success'))
                      <div class="alert alert-success alert-dismissible fade show">
                          {{ session()->get('success') }}
                      </div>
                  @endif

                  @if(session()->has('error'))
                      <div class="alert alert-danger alert-dismissible fade show">
                          {{ session()->get('error') }}
                      </div>
                  @endif

                  <div class="container"></div>,<div class="container">
  
                  <div class="stepwizard col-md-offset-3">
                      <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step">
                          <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                          <p>Date & Time</p>
                        </div>
                        <div class="stepwizard-step">
                          <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                          <p>Place, Signup & Reminders</p>
                        </div>
                        <div class="stepwizard-step">
                          <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                          <p>Task & Extra Info</p>
                        </div>
                      </div>
                    </div>
                    
                    <form role="form" action="{{route('activity.store')}}" method="post">
                      @csrf
                      <div class="row setup-content" id="step-1">
                        <div class="col-md-12">
                            <h5 class="mt-3 mb-4"> Title & activity type </h5>
                            <div class="row">
                              <div class="form-group col-6">
                                <label for="">Title</label>
                                <input type="text" name="title" value="{{$data->title??''}}" class="form-control" placeholder="Activity Title" required>
                                @error('title')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                              </div>

                             <div class="form-group col-6">
                                <label for="">Activity Type</label>
                                <select name="activity_type" id="activity_type" class="form-control" required>
                                  <option value="">Select Type</option>
                                @foreach($activity_types as $value)
                                  <option value="{{$value->id }}" >{{ucfirst($value->name)}}</option>
                                 @endforeach
                                </select>
                                @error('activity_type')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                              </div>
                            </div>
                              <h5 class="mt-3 mb-4"> Date and time </h5>
                              <div class="row">
                                <div class="form-group col-4">
                                  <label for="">Date</label>
                                  <input type="date" name="start_date" value="{{$data->start_date??''}}" class="form-control" required>
                                  @error('start_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>

                                <div class="form-group col-4">
                                  <label for="">Start Time</label>
                                  <input type="time" name="start_time" value="{{$data->start_time??''}}" class="form-control" required>
                                  @error('start_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>

                                <div class="form-group col-4">
                                  <label for="">End Time</label>
                                  <input type="time" name="end_time" value="{{$data->end_time??''}}" class="form-control" required>
                                  @error('end_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>

                               <div class="row">
                                <div class="form-group col-12 mt-4">
                                  <div class="form-check form-check-inline">
                                    <input name="activity_end_another_date" class="form-check-input" type="checkbox" id="activity_end_another_date" value="1">
                                    <label class="form-check-label" for="activity_end_another_date">Does the activity end on another day?</label>
                                  </div>
                                </div>

                                <div class="form-group col-6" id="activity_end_date" style="display: none;">
                                  <label for="">End Date</label>
                                  <input type="date" name="end_date" value="{{$data->end_date??''}}" class="form-control">
                                  @error('end_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>

                              <div class="row" >
                                <div class="form-group col-12 mt-4">
                                  <div class="form-check form-check-inline">
                                    <input name="repeat_activity" class="form-check-input" type="checkbox" id="repeat_activity" value="1">
                                    <label class="form-check-label" for="repeat_activity">Repeat activity?</label>
                                  </div>
                                </div>
                                <div class="form-group row col-12" id="activity_week_group" style="display: none;">
                                  <div class="form-group col-6">
                                    <label for="">How often should the activity be repeated</label>
                                    <select name="activity_repeated" id="activity_repeated" class="form-control">
                                      <option value="Every week">Every week</option>
                                      <option value="Every other week">Every other week</option>
                                    </select>
                                    @error('activity_repeated')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>

                                  <div class="form-group col-6" id="repeat_weekly_up_to">
                                    <label for="">Repeat weekly up to and including</label>
                                    <input type="date" name="repeat_weekly_up_to" value="{{$data->repeat_weekly_up_to??''}}" class="form-control">
                                    @error('repeat_weekly_up_to')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>
                              </div>

                              <div class="row" id="comments" style="display: none;">
                             <div class="form-group col-12">
                                <textarea placeholder="Comments" name="comments" value="{{$data->comments??''}}" class="form-control" ></textarea>
                                @error('comments')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                              </div>
                            </div>

                              <div class="row">
                                <div class="form-group col-12">

                                  <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
                                </div>
                              </div>
                        </div>
                      </div>
                      <div class="row setup-content" id="step-2">
                        <div class="col-12">
                          <div class="col-md-12">
                           <h5 class="mt-3 mb-4">Place</h5>
                           <div class="row">
                                <div class="form-group col-4">
                                  <label for="">Place</label>
                                  <input type="text" maxlength="100" name="place" value="{{$data->place??''}}" class="form-control" >
                                  @error('place')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>

                                <div class="form-group col-4">
                                  <label for="">Meeting Place</label>
                                  <input type="text" maxlength="100" name="meeting_place" value="{{$data->meeting_place??''}}" class="form-control" >
                                  @error('meeting_place')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>

                                <div class="form-group col-4">
                                  <label for="">Meeting Time</label>
                                  <input type="time" name="meeting_time" value="{{$data->meeting_time??''}}" class="form-control" >
                                  @error('meeting_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>

                              <h5 class="mt-3 mb-4">Registration options</h5>
                           <div class="row">
                                <div class="form-group col-4">
                                <label for="">Selection Type</label>
                                <select name="selection_type" id="selection_type" class="form-control">
                                  <option value="">Select Type</option>
                                @foreach($selection_types as $value)
                                  <option value="{{$value->id }}" >{{ucfirst($value->name)}}</option>
                                 @endforeach
                                </select>
                                @error('selection_type')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                              </div>

                                <div class="form-group col-4">
                                  <label for="">Max number of participants</label>
                                  <input type="number" name="max_participants" value="{{$data->max_participants??''}}" class="form-control" >
                                  @error('max_participants')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-12 mt-4">
                                  <div class="form-check form-check-inline">
                                    <input name="coach_included_to_max_participants" class="form-check-input" type="checkbox" id="coach_included_to_max_participants" value="1">
                                    <label class="form-check-label" for="coach_included_to_max_participants">Attending coaches are not included in the max. number of participants</label>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                   <div class="form-group col-6">
                                    <label for="">Choose registration deadline date</label>
                                    <input type="date" name="register_end_date" value="{{$data->register_end_date??''}}" class="form-control" >
                                    @error('register_end_date')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>

                                  <div class="form-group col-6">
                                    <label for="">Choose registration deadline time</label>
                                    <input type="time" name="register_end_time" value="{{$data->register_end_time??''}}" class="form-control" >
                                    @error('register_end_time')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>

                              <div class="row">
                                <div class="form-group col-12 mt-4">
                                  <div class="form-check form-check-inline">
                                    <input name="is_register_start_date" class="form-check-input" type="checkbox" id="is_register_start_date" value="1">
                                    <label class="form-check-label" for="is_register_start_date">Registration start date </label>
                                  </div>
                                </div>
                              </div>

                              <div class="row" id="register_start" style="display: none;">
                                   <div class="form-group col-6">
                                    <label for="">Registration start date</label>
                                    <input type="date" name="register_start_date" value="{{$data->register_start_date??''}}" class="form-control" >
                                    @error('register_start_date')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>

                                  <div class="form-group col-6">
                                    <label for="">Registration start time</label>
                                    <input type="time" name="register_start_time" value="{{$data->register_start_time??''}}" class="form-control" >
                                    @error('register_start_time')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>

                              <div class="row">
                                <div class="form-group col-12 mt-4">
                                  <div class="form-check form-check-inline">
                                    <input name="waiting_list" class="form-check-input" type="checkbox" id="waiting_list" value="1">
                                    <label class="form-check-label" for="waiting_list">Waiting list</label>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-12 mt-6">
                                  <div class="form-check form-check-inline">
                                    <input name="hide_unsubscribe_btn" class="form-check-input" type="checkbox" id="hide_unsubscribe_btn" value="1">
                                    <label class="form-check-label" for="hide_unsubscribe_btn">Hide the unsubscribe/unattending button from attendees </label>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-12 mt-6">
                                  <div class="form-check form-check-inline">
                                    <input name="hide_register_status" class="form-check-input" type="checkbox" id="hide_register_status" value="1">
                                    <label class="form-check-label" for="hide_register_status">Hide registration status from players </label>
                                  </div>
                                </div>
                              </div>

                            <h5 class="mt-3 mb-4">Reminders</h5>
                            <div class="row">
                                <div class="form-group col-6">
                                  <label for="">Reminder 5 days before the activity</label>
                                  <select name="reminder_5_days_before_activity" id="reminder_5_days_before_activity" class="form-control">
                                    <option value="No Reminder">No reminder</option>
                                    <option value="Send to all">Send to all</option>
                                    <option value="send to attendees, assistants and coaches">send to attendees, assistants and coaches</option>
                                    <option value="Send to undecided">Send to undecided</option>
                                    <option value="Send to attending">Send to attending</option>
                                  </select>
                                  @error('reminder_5_days_before_activity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>

                                <div class="form-group col-6">
                                  <label for="">Reminder 2 days before the activity</label>
                                  <select name="reminder_2_days_before_activity" id="reminder_2_days_before_activity" class="form-control">
                                    <option value="No Reminder">No reminder</option>
                                    <option value="Send to all">Send to all</option>
                                    <option value="send to attendees, assistants and coaches">send to attendees, assistants and coaches</option>
                                    <option value="Send to undecided">Send to undecided</option>
                                    <option value="Send to attending">Send to attending</option>
                                  </select>
                                  @error('reminder_2_days_before_activity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>

                             <div class="row">
                                <div class="form-group col-12">   
                                  <button class="btn btn-primary prevBtn btn-lg pull-left" type="button">Previous</button>
                                  <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="row setup-content" id="step-3">
                        <div class="col-12">
                            <h5 class="mt-3 mb-4">Tasks</h5>

                            <div class="row">
                              <div class="form-group col-12 mt-6">
                                <div class="form-check form-check-inline">
                                  <input name="with_volunteer_tasks" class="form-check-input" type="checkbox" id="with_volunteer_tasks" value="1">
                                  <label class="form-check-label" for="with_volunteer_tasks">With volunteer tasks </label>
                                </div>
                              </div>
                            </div>

                            <div class="row" id="volunteer_tasks" style="display: none;">
                                 <div class="form-group col-4">
                                  <label for="">volunteer task 1</label>
                                  <input type="text" placeholder="Enter Task" name="volunteer_task1" value="{{$data->volunteer_task1??''}}" class="form-control">
                                  @error('volunteer_task1')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>

                                <div class="form-group col-4">
                                  <label for="">volunteer task 2</label>
                                  <input type="text" placeholder="Enter Task" name="volunteer_task2" value="{{$data->volunteer_task2??''}}" class="form-control">
                                  @error('volunteer_task2')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>

                                <div class="form-group col-4">
                                  <label for="">volunteer task 3</label>
                                  <input type="text" placeholder="Enter Task" name="volunteer_task3" value="{{$data->volunteer_task3??''}}" class="form-control">
                                  @error('volunteer_task3')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>

                              </div>


                            <h5 class="mt-3 mb-4">Driving</h5>
                            <div class="row">
                              <div class="form-group col-12 mt-6">
                                <div class="form-check form-check-inline">
                                  <input name="is_with_driving" class="form-check-input" type="checkbox" id="is_with_driving" value="1">
                                  <label class="form-check-label" for="is_with_driving">With Driving </label>
                                </div>
                              </div>
                            </div>

                            <div class="row" id="with_driving" style="display: none;">
                             <div class="form-group col-12">
                                <textarea type="text" name="with_driving" value="{{$data->with_driving??''}}" class="form-control" ></textarea>
                                @error('with_driving')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                              </div>
                            </div>

                            <h5 class="mt-3 mb-4">Extra</h5>
                            <div class="row">
                              <div class="form-group col-12 mt-6">
                                <div class="form-check form-check-inline">
                                  <input name="extra_file" class="form-check-input" type="file" id="extra_file" value="1">
                                </div>
                              </div>
                            </div>

                            <h5 class="mt-3 mb-4">After creating the activity</h5>
                            <div class="row" id="send_notification">
                              <div class="form-group col-12 mt-6">
                                <div class="form-check form-check-inline">
                                  <input name="send_notification" class="form-check-input" type="checkbox" id="send_notification" value="1">
                                  <label class="form-check-label" for="send_notification">Send notification </label>
                                </div>
                              </div>
                            </div>

                            <div class="row" id="send_email">
                              <div class="form-group col-12 mt-6">
                                <div class="form-check form-check-inline">
                                  <input name="send_email" class="form-check-input" type="checkbox" id="send_email" value="1">
                                  <label class="form-check-label" for="send_email">Send email </label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="form-group col-12">     
                                <button class="btn btn-primary prevBtn btn-lg pull-left" type="button">Previous</button>
                                <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
                              </div>
                            </div>
                        </div>
                      </div>
                    </form>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        </div>      
      </div>
      <!-- /Main Wrapper -->
  </div>
@endsection 
@section('scripts')
<script type="text/javascript">

$(document).ready(function () {
   var form = $("form");
  $("form").validate({
      rules: {
        activity_type: {
          required: true
        },
      }
    });

  $('#activity_end_another_date').click(function() {
       var value = $("input[name='activity_end_another_date']:checked").val();
            if(value === '1'){
                $('#activity_end_date').show();
            }else{
              $('#activity_end_date').hide();
            }
    });

  $('#repeat_activity').click(function() {
       var value = $("input[name='repeat_activity']:checked").val();
            if(value === '1'){
                $('#activity_week_group').show();
            }else{
              $('#activity_week_group').hide();
            }
    });

   $('#is_register_start_date').click(function() {
       var value = $("input[name='is_register_start_date']:checked").val();
            if(value === '1'){
                $('#register_start').show();
            }else{
              $('#register_start').hide();
            }
    });

   $('#is_with_driving').click(function() {
       var value = $("input[name='is_with_driving']:checked").val();
            if(value === '1'){
                $('#with_driving').show();
            }else{
              $('#with_driving').hide();
            }
    });

   $('#with_volunteer_tasks').click(function() {
       var value = $("input[name='with_volunteer_tasks']:checked").val();
            if(value === '1'){
                $('#volunteer_tasks').show();
            }else{
              $('#volunteer_tasks').hide();
            }
    });


  // step form js
  var navListItems = $('div.setup-panel div a'),
          allWells = $('.setup-content'),
          allNextBtn = $('.nextBtn'),
        allPrevBtn = $('.prevBtn');

  allWells.hide();

  navListItems.click(function (e) {

     if (form.valid() === true) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

      if (!$item.hasClass('disabled')) {
          navListItems.removeClass('btn-primary').addClass('btn-default');
          $item.addClass('btn-primary');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
      }
    }
  });
  
  allPrevBtn.click(function(){
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

          prevStepWizard.removeAttr('disabled').trigger('click');
  });

  allNextBtn.click(function(){
     if (form.valid() !== true) {
        return false
     }
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;

      // $(".form-group").removeClass("has-error");
      // for(var i=0; i<curInputs.length; i++){
      //     if (!curInputs[i].validity.valid){
      //         isValid = false;
      //         $(curInputs[i]).closest(".form-group").addClass("has-error");
      //     }
      // }

      if (isValid)
          nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.btn-primary').trigger('click');
});
</script>
@endsection