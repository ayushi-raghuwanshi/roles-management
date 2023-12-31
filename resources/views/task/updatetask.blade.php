@extends('layouts.main')
@section('section')
    <div class="row">
        <form method="post" action="{{ route('updateTask') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Update Task</h5>
                    <div class="row">
                        <div class="col-6">
                            <label for="inputNanme4" class="form-label">Title</label>
                            <input type="text" class="form-control" id="inputNanme4" name="name" value="{{$task->name}}">
                            @error('name')
                                <span style="color:red">{{ $errors->first('name') }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="">----Select Priority----</option>
                                <option value="Low" {{$task->priority == 'Low' ? 'selected' : ''}}>Low</option>
                                <option value="Medium" {{$task->priority == 'Medium' ? 'selected' : ''}}>Medium</option>
                                <option value="High" {{$task->priority == 'High' ? 'selected' : ''}}>High</option>
                            </select>
                            @error('priority')
                                <span style="color:red">{{ $errors->first('priority') }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{$task->start_date}}">
                            @error('start_date')
                                <span style="color:red">{{ $errors->first('start_date') }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{$task->end_date ?? ''}}">
                            @error('end_date')
                                <span style="color:red">{{ $errors->first('end_date') }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mt-2 mb-5">
                            <label for="description" class="form-label">Description</label>
                            <!-- Quill Editor Default -->
                            <div class="quill-editor-default">{!! $task->description !!}</div>
                            <!-- End Quill Editor Default -->
                        </div>
                        <input type="hidden" id="quill_html" name="description" value="{{$task->description}}">
                        <div class="col-md-6 mt-5">
                            <label for="assigned_to" class="form-label">Assigned To</label>
                            <select class="form-select" id="assigned_to" name="assigned_to">
                                <option value="">----Select User----</option>
                                <option value="{{Auth::id()}}" {{$task->assigned_to == Auth::id() ? 'selected' : ''}}>{{Auth::user()->name}}</option>
                                @if(!empty($users))
                                    @foreach($users->subusers as $key=>$value)
                                        <option value="{{$value->id}}" {{$task->assigned_to == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('assigned_to')
                                <span style="color:red">{{ $errors->first('assigned_to') }}</span>
                            @enderror
                        </div>
                        <input type="hidden" name="id" value="{{$task->id}}">
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
@endsection
@push('custom_scripts')
<script>
    var quill = new Quill('.quill-editor-default');
    quill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("quill_html").value = quill.root.innerHTML;
    });
</script>
@endpush
