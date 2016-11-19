<h2>Project Details</h2>
<p>Below you can see the PDF containing the project details.</p>
<iframe src="http://docs.google.com/gview?url={{ url('/') }}{{ $project->pdf_path }}&embedded=true" style="width:100%; height:600px;" frameborder="0"></iframe>

<hr />

@if($project->invoices()->count() > 0)
	<h2>Project Invoices</h2>
	<p>Below you can see all invoices related to this project.</p>
	@php $invoices = $project->invoices; @endphp
	@include("layouts.invoices.index")
@endif