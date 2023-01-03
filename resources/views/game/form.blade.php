<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('user_id') }}
            {{ Form::text('user_id', $game->user_id, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : ''), 'placeholder' => 'User Id']) }}
            {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('opponent_id') }}
            {{ Form::text('opponent_id', $game->opponent_id, ['class' => 'form-control' . ($errors->has('opponent_id') ? ' is-invalid' : ''), 'placeholder' => 'Opponent Id']) }}
            {!! $errors->first('opponent_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('word') }}
            {{ Form::text('word', $game->word, ['class' => 'form-control' . ($errors->has('word') ? ' is-invalid' : ''), 'placeholder' => 'Word']) }}
            {!! $errors->first('word', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('word_1') }}
            {{ Form::text('word_1', $game->word_1, ['class' => 'form-control' . ($errors->has('word_1') ? ' is-invalid' : ''), 'placeholder' => 'Word 1']) }}
            {!! $errors->first('word_1', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('word_2') }}
            {{ Form::text('word_2', $game->word_2, ['class' => 'form-control' . ($errors->has('word_2') ? ' is-invalid' : ''), 'placeholder' => 'Word 2']) }}
            {!! $errors->first('word_2', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('word_3') }}
            {{ Form::text('word_3', $game->word_3, ['class' => 'form-control' . ($errors->has('word_3') ? ' is-invalid' : ''), 'placeholder' => 'Word 3']) }}
            {!! $errors->first('word_3', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('word_4') }}
            {{ Form::text('word_4', $game->word_4, ['class' => 'form-control' . ($errors->has('word_4') ? ' is-invalid' : ''), 'placeholder' => 'Word 4']) }}
            {!! $errors->first('word_4', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('word_5') }}
            {{ Form::text('word_5', $game->word_5, ['class' => 'form-control' . ($errors->has('word_5') ? ' is-invalid' : ''), 'placeholder' => 'Word 5']) }}
            {!! $errors->first('word_5', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('word_6') }}
            {{ Form::text('word_6', $game->word_6, ['class' => 'form-control' . ($errors->has('word_6') ? ' is-invalid' : ''), 'placeholder' => 'Word 6']) }}
            {!! $errors->first('word_6', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('seen') }}
            {{ Form::text('seen', $game->seen, ['class' => 'form-control' . ($errors->has('seen') ? ' is-invalid' : ''), 'placeholder' => 'Seen']) }}
            {!! $errors->first('seen', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('winner_id') }}
            {{ Form::text('winner_id', $game->winner_id, ['class' => 'form-control' . ($errors->has('winner_id') ? ' is-invalid' : ''), 'placeholder' => 'Winner Id']) }}
            {!! $errors->first('winner_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('degree') }}
            {{ Form::text('degree', $game->degree, ['class' => 'form-control' . ($errors->has('degree') ? ' is-invalid' : ''), 'placeholder' => 'Degree']) }}
            {!! $errors->first('degree', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>