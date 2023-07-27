<div class="msg_history scrolling-pagination" style="background-image: url({{url('assets/img/chat_img.jpg')}})">
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
</div>
<div class="type_msg">
    <div class="input_msg_write" style="background-color: white;">
        <input type="text" class="write_msg" placeholder="Type a message" />
    </div>
</div>

