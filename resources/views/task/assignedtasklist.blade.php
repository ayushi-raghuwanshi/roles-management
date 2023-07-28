@extends('layouts.main')
@section('custom_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endsection
@section('section')
    <div class="row">
        <div class="card">
            <div class="row mb-2">
                <div class="col-3 col-md-3 mt-2">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="col-3 col-md-3 mt-2">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body mt-2">
                <div id='full_calendar_events'></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateTaskModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update/Delete Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-12">
                        <ul class="list-group">
                            <li class="list-group-item"><b>Description:</b> <p id="task_description"></p></li>
                            <li class="list-group-item" id="task_priority"></li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-12">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">----Select Status----</option>
                            <option value="Pending">Pending</option>
                            <option value="Inprogress">Inprogress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <input type="hidden" name="task_id" id="task_id">
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="update_task">Update</button>
              <button type="button" class="btn btn-danger" id="delete_task">Delete</button>
            </div>
          </div>
        </div>
      </div>
@endsection
@push('custom_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#full_calendar_events').fullCalendar({
                editable: true,
                editable: true,
                events: SITEURL + "/assignedTask",
                displayEventTime: true,
                eventRender: function(event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                // select: function(event_start, event_end, allDay) {
                //     var event_name = prompt('Event Name:');
                //     if (event_name) {
                //         var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
                //         var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                //         $.ajax({
                //             url: SITEURL + "/calendar-crud-ajax",
                //             data: {
                //                 event_name: event_name,
                //                 event_start: event_start,
                //                 event_end: event_end,
                //                 type: 'create'
                //             },
                //             type: "POST",
                //             success: function(data) {
                //                 displayMessage("Event created.");
                //                 calendar.fullCalendar('renderEvent', {
                //                     id: data.id,
                //                     title: event_name,
                //                     start: event_start,
                //                     end: event_end,
                //                     allDay: allDay
                //                 }, true);
                //                 calendar.fullCalendar('unselect');
                //             }
                //         });
                //     }
                // },
                eventDrop: function(event, delta) {
                    var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                    var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                    $.ajax({
                        url: SITEURL + '/updateTask',
                        data: {
                            start_date: event_start,
                            end_date: event_end,
                            id: event.id,
                            name:event.title,
                        },
                        type: "POST",
                        success: function(response) {
                            displayMessage("Task Updated Successfully");
                        }
                    });
                },
                eventClick: function(event) {
                    $('#updateTaskModal .modal-title').html(event.title);
                    $('#task_description').html(event.description);
                    $('#status').val(event.status);
                    $('#task_id').val(event.id);
                    $('#task_priority').html('<span class="badge bg-info text-dark"><i class="bi bi-info-circle me-1"></i>'+event.priority+'</span>');
                    $('#updateTaskModal').modal("show");
                }
            });
        });

        $("#update_task").click(function(){
            let status = $("#status").val();
            let task_id = $('#task_id').val();
            $.ajax({
                type: 'POST',
                url: "{{route('updateTaskStatus')}}",
                data: {status:status,id:task_id,_token:'{{csrf_token()}}'},
                success: function(data){
                    $('#updateTaskModal').modal("hide");
                    displayMessage("Task Updated Successfully!");
                    $('#full_calendar_events').fullCalendar('removeEvents');
                    $('#full_calendar_events').fullCalendar('refetchEvents',data, true);
                    $('#status').text(data.status);
                },
                error:function(xhr,status,error){

                }
            });
        });

        $("#delete_task").click(function(){
            swal({
                title: "Are you sure you want to Delete this Task?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ['No', 'Yes']
            })
            .then((willDelete) => {
                if (willDelete) {
                    let task_id = $('#task_id').val();
                    $.ajax({
                        type: 'POST',
                        url: "{{route('deleteTask')}}",
                        data: {id:task_id,_token:'{{csrf_token()}}'},
                        success: function(data){
                            $('#updateTaskModal').modal("hide");
                            displayMessage("Task Deleted Successfully!");
                            $('#full_calendar_events').fullCalendar('removeEvents', task_id);
                        },
                        error:function(xhr,status,error){

                        }
                    });
                } else {
                    $('#updateTaskModal').modal("hide");
                }
            });
        });

        function displayMessage(message) {
            toastr.success(message, 'Task');
        }

        $('#start_date').on('change', function() {
            $('#full_calendar_events').fullCalendar('option', 'validRange', {
                start: this.value,
                end: $('#end_date').val()
            });
        });

        $('#end_date').on('change', function() {
            $('#full_calendar_events').fullCalendar('option', 'validRange', {
                start: $('#start_date').val(),
                end: this.value
            });
        });
    </script>
@endpush
