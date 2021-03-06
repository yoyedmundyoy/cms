@extends('layouts.admin')

@section('title', 'Edit Meetup')

@section('content')
    <div>
        <h2 class="float-left">Meetups | Edit</h2>
        <a class="btn btn-primary float-right" href="{{ route('dashboard.meetups') }}">Back</a>
        @if (Auth::user()->hasAllowedRole())
            <a class="btn btn-danger float-right" href="{{ route('dashboard.meetups.delete', ['id' => $data->id]) }}">Delete</a>
        @endif
    </div>

    <br><br>

    <hr />

    <form method="POST" action="{{ route('dashboard.meetups.edit', ['id' => $data->id]) }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">Meetup Title (<span class="red">*</span>)</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ $data->title }}" required>
        </div>
        <div class="form-group">
            <label for="event_start">Start Date and Time(<span class="red">*</span>)</label>
            <br>
            <span class="red">EXAMPLE: 2019-10-18, 06:00 PM/AM</span>
            <input type="datetime-local" class="form-control" id="event_start" name="event_start" value="{{ \Carbon\Carbon::parse($data->event_start)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label for="event_end">End Date (<span class="red">*</span>)</label>
            <br>
            <span class="red">EXAMPLE: 2019-10-18, 06:00 PM/AM</span>
            <input type="datetime-local" class="form-control" id="event_end" name="event_end" value="{{ \Carbon\Carbon::parse($data->event_end)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label for="location">Meetup Location (<span class="red">*</span>)</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" value="{{ $data->location }}">
        </div>


        <div class="form-group">
            <label for="description">Description (<span class="red">*</span>)</label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter Description" required rows="5">{{ $data->description }}</textarea>

        </div>

        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="checkbox" class="form-control float-right" id="isActive" name="isActive" value="True">Active Event?
            </label>
        </div>

        <br><br>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@stop
