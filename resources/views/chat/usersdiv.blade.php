    @forelse($users->subusers as $user)
    <div class="chat_list user" id="{{ $user->id }}">
        <div class="chat_people">
            <div class="chat_img"> <img src="https://eu.ui-avatars.com/api/?name={{$user->name}}&background=random&rounded=true"
                    alt="{{$user->name}}"> </div>
            <div class="chat_ib">
                <h5 style="color:#f3e8e8">{{$user->name}}
                    @if($user->messages_count)
                    <span class="badge bg-secondary text-light pending">{{$user->messages_count}}</span>
                    @endif
                </h5>
                <p>{{ $user->email }}</p>
            </div>
        </div>
    </div>
    @empty
        <h5>No Users Assigned!</h5>
    @endforelse
    {{-- <div class="d-none">
        {!! $users->subusers->links('pagination::bootstrap-5')!!}
    </div> --}}

