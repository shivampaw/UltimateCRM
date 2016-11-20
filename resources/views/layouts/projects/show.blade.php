<h2>Project Details</h2>

<p>
	@if($project->accepted)
	    <div class="text-success">Project Accepted on {{ $project->accepted_at->toFormattedDateString() }}</div>
	@else
	    <div class="text-danger">Project Not Accepted Yet</div>
	    @if(Auth::user() && !Auth::user()->isAdmin())
			<strong><a href="/projects/{{ $project->id }}/accept">Accept Project</a></strong>
	    @endif
	@endif
	@if(Auth::user()->isAdmin())
		<div><strong>Project ID: {{ $project->id }}</strong></div>
	@endif
</p>
<p>Below you can see the PDF containing the project details.</p>
<object data="{{ url('/') }}{{ $project->pdf_path }}" style="width: 100%; height: 600px;" type="application/pdf">
    <embed src="{{ url('/') }}{{ $project->pdf_path }}" style="width: 100%; height: 600px;" type="application/pdf" />
</object>

<hr />

<h2>Project Invoices </h2>
@if($project->invoices()->count() > 0)
	<p>Below you can see all invoices related to this project.</p>
	@php $invoices = $project->invoices; @endphp
	@include("layouts.invoices.index")
@else
	<p>No Invoices Yet</p>
@endif