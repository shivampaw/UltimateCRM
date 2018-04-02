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
        @php $invoices = $project->invoices; @endphp
        @include("layouts.invoices.index")
    @else
        <p>No Invoices Yet</p>
    @endif
    @if(Auth::user()->isAdmin())
        <a href="/clients/{{ $client->id }}/invoices/create?project_id={{ $project->id }}">Create Project Invoice</a>
    @endif