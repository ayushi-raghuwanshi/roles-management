@foreach($messages as $message)
    <div class="{{ ($message->from == Auth::id()) ? 'outgoing_msg' : 'incoming_msg' }}">
        <div class="incoming_msg_img"> <img src="https://eu.ui-avatars.com/api/?name={{$message->user->name}}&background=random&rounded=true"
                alt="sunil"> </div>
        <div class="{{ ($message->from == Auth::id()) ? 'sent_msg':'received_msg'}}">
            <div class="{{ ($message->from == Auth::id()) ? '':'received_withd_msg'}}">
                <p>{{ $message->message }}</p>
                <span class="time_date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</span>
            </div>
        </div>
    </div>
@endforeach
{{-- <div class="d-none">
    {!! $messages->links('pagination::bootstrap-5')!!}
</div> --}}



