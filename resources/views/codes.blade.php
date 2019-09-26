@extends('shared.master')

@section('title', 'Onix codelist ' . $codelist->number . ' - ' . $codelist->description)

@section('content')
<h1>List {{ $codelist->number }}: {{ $codelist->description }}</h1>
<em>Last updated in issue {{ $codelist->codes->max('last_issue_modified_at') }}</em>

<table class="table table-condensed table-hover">
  <thead>
    <tr>
      <th>Value</th>
      <th>Description</th>
      <th>Notes</th>
      <th>Issue number</th>
      <th>Modified in Issue</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($codelist->codes as $code)
    <tr>
      <td>{{ $code->value }}</td>
      <td>{{ $code->translate()->description }}</td>
      <td>{{ $code->translate()->notes }}</td>
      <td>{{ $code->issue_number }}</td>
      <td>{{ $code->last_issue_modified_at }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<a href="{{ URL::previous() }}">Back to Codelists</a>
@endsection
