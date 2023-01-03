@extends('layouts.app')

@section('template_title')
    {{ $game->name ?? 'Show Game' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Game</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('games.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>User Id:</strong>
                            {{ $game->user_id }}
                        </div>
                        <div class="form-group">
                            <strong>Opponent Id:</strong>
                            {{ $game->opponent_id }}
                        </div>
                        <div class="form-group">
                            <strong>Word:</strong>
                            {{ $game->word }}
                        </div>
                        <div class="form-group">
                            <strong>Word 1:</strong>
                            {{ $game->word_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Word 2:</strong>
                            {{ $game->word_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Word 3:</strong>
                            {{ $game->word_3 }}
                        </div>
                        <div class="form-group">
                            <strong>Word 4:</strong>
                            {{ $game->word_4 }}
                        </div>
                        <div class="form-group">
                            <strong>Word 5:</strong>
                            {{ $game->word_5 }}
                        </div>
                        <div class="form-group">
                            <strong>Word 6:</strong>
                            {{ $game->word_6 }}
                        </div>
                        <div class="form-group">
                            <strong>Seen:</strong>
                            {{ $game->seen }}
                        </div>
                        <div class="form-group">
                            <strong>Winner Id:</strong>
                            {{ $game->winner_id }}
                        </div>
                        <div class="form-group">
                            <strong>Degree:</strong>
                            {{ $game->degree }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
