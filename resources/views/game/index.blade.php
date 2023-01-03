@extends('layouts.app')

@section('template_title')
    Game
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Game') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('games.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>User Id</th>
										<th>Opponent Id</th>
										<th>Word</th>
										<th>Word 1</th>
										<th>Word 2</th>
										<th>Word 3</th>
										<th>Word 4</th>
										<th>Word 5</th>
										<th>Word 6</th>
										<th>Seen</th>
										<th>Winner Id</th>
										<th>Degree</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($games as $game)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $game->user_id }}</td>
											<td>{{ $game->opponent_id }}</td>
											<td>{{ $game->word }}</td>
											<td>{{ $game->word_1 }}</td>
											<td>{{ $game->word_2 }}</td>
											<td>{{ $game->word_3 }}</td>
											<td>{{ $game->word_4 }}</td>
											<td>{{ $game->word_5 }}</td>
											<td>{{ $game->word_6 }}</td>
											<td>{{ $game->seen }}</td>
											<td>{{ $game->winner_id }}</td>
											<td>{{ $game->degree }}</td>

                                            <td>
                                                <form action="{{ route('games.destroy',$game->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('games.show',$game->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('games.edit',$game->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $games->links() !!}
            </div>
        </div>
    </div>
@endsection
