@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"
                        style="display: flex;
                                                                                                                                                                                                                                                            justify-content: space-between;">
                        <div>
                            <h5>Todo List</h5>
                        </div>
                        <div>
                            {{ $dos->links() }}
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Task</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Creater</th>
                                    <th scope="col">Creater At</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Doer</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dos as $key => $item)
                                    <tr>
                                        <th scope="row">{{ (Request::get('page', 1) - 1) * 6 + $key + 1 }}</th>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ date('h A, d F', strtotime($item->deadline->setTimezone($item->getTimezone()))) }}
                                        </td>
                                        <td>{{ $item->CreatedBy->name }}</td>
                                        <td>{{ date('h A, d F', strtotime($item->created_at->setTimezone($item->getTimezone()))) }}
                                        </td>
                                        <td>{{ $item->completed_at? 'Completed at ' . date('h A, d F', strtotime($item->completed_at->setTimezone($item->getTimezone()))): 'Pending' }}
                                        </td>
                                        <td>{{ $item->CompletedBy->name ?? '---' }}</td>
                                        <td
                                            style="display: flex;
                                                                                            justify-content: space-around;">
                                            @if ($item->completed_at == null)
                                                <button type="button" class="btn-sm btn-success"
                                                    onclick="document.getElementById('update{{ $item->id }}').submit()"><i
                                                        class="fas fa-check"></i></button>
                                                <form action="{{ route('todo.update', $item->id) }}" method="post"
                                                    id="update{{ $item->id }}">@csrf
                                                    @method('patch')</form>

                                                @if ($item->created_by == auth()->user()->id)
                                                    <button type="button" class="btn-sm btn-danger"
                                                        onclick="document.getElementById('delete{{ $item->id }}').submit()"><i
                                                            class="fas fa-trash-alt"></i></button>

                                                    <form action="{{ route('todo.destroy', $item->id) }}" method="post"
                                                        id="delete{{ $item->id }}">@csrf
                                                        @method('delete')</form>
                                                @endif
                                            @else
                                                <p>Completed</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">

                        <form action="{{ route('todo.store') }}" method="post">
                            @csrf
                            @method('post')

                            <small>Add new task</small>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="title" placeholder="Title">
                                <input type="datetime-local" class="form-control" name="deadline"
                                    placeholder="Description">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Add</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
