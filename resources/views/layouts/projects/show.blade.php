<h2>Project Details</h2>

<p>
@if($project->accepted)
    <div class="text-success">Project Accepted on {{ $project->accepted_at->toFormattedDateString() }}</div>
@else
    <div class="text-danger">Project Not Accepted Yet</div>
    @endif
    </p>
    <p>Below you can see the PDF containing the project details.</p>
    <object data="{{ Storage::url($project->pdf_path) }}" style="width: 100%; height: 600px;" type="application/pdf">
        <embed src="{{ Storage::url($project->pdf_path) }}" style="width: 100%; height: 600px;"
               type="application/pdf"></embed>
    </object>
    <hr/>

    <h2>Project Invoices </h2>
    @if($project->invoices->count() > 0)
        <p>Below you can see all invoices related to this project.</p>
        @php
            $invoices = $project->invoices;
        @endphp
        @include("layouts.invoices.index")
    @else
        <p>No Invoices Yet</p>
    @endif
    @if(Auth::user()->isAdmin())
        <a href="/clients/{{ $client->id }}/invoices/create?project_id={{ $project->id }}">Create Project Invoice</a>
    @endif
    <hr>
    <h2>Project Chat</h2>
    <div id="project_chat">
        <div class="chat-body">
            @forelse($project->chats as $chat)
                <div class="chat-message">
                    <div class="chat-message-meta">On <strong>{{ $chat->created_at->toFormattedDateString() }}</strong>,
                        <strong>{{ $chat->user->name }}</strong> said:
                    </div>
                    <div class="chat-message-body">
                        <p>{{ $chat->message }}</p>
                        @if(!empty($chat->attachment))
                            <hr>
                            <span>
                                <a href="{{ Storage::url($chat->attachment) }}" target="_blank">Click to View
                                    Attachment</a>
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="chat-message">
                    <div class="chat-message-body text-center">
                        <strong>No Messages Yet</strong>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="chat-input">
            <form action="/projects/{{ $project->id }}/chats" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col-md-9 mb-3">
                        <input type="text" placeholder="Message (Enter to Send)" class="form-control" name="message"
                               title="name" required>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment">
                            <label class="custom-file-label" for="attachment">Choose file...</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@section('footer')
    <script>
        $("#attachment").change(function (e) {
            var path = this.value;
            $('.custom-file-label').text(path.substring(12, path.length));
        });
    </script>
@endsection