<!doctype html>
<html lang="en">

<head>
    <title>@yield('title', 'Student')</title>
    {{-- meta --}}
    @include('StudentDashboard.layouts.meta')
    {{-- links --}}
    @include('StudentDashboard.layouts.links')
</head>

<body>
    {{--  Header --}}
    @include('StudentDashboard.layouts.header')
    <div class="container">
        <div class="userprofilemain">
            {{-- sidebar --}}
            @include('StudentDashboard.layouts.sidebar')
