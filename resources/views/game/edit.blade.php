@extends('layouts.app')

@section('template_title')
    Update Game
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Game</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('games.update', $game->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('game.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
