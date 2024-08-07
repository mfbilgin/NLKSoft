@php use App\Models\User; @endphp
@extends('layouts.admin')
@section('title',__('titles.titles.users'))
@section('admin-content')
    @php($users = (new User)->getAllUsers())
    <div class="container text-center">
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">{{__('titles.user.first_name')}}</th>
                    <th scope="col">{{__('titles.user.last_name')}}</th>
                    <th scope="col">{{__('titles.user.email')}}</th>
                    <th scope="col">{{__('titles.user.role')}}</th>
                    <th scope="col">#</th>
                    <th scope="col">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    @if(auth()->user()->id != $user->id)
                        <tr>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <form
                                        action="{{ route('user.change-role', ['id' => $user->id,'newRole' => 'user'])  }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning">
                                            <i class="bi bi-arrow-down-circle"></i> {{__('titles.user.downgrade')}}
                                        </button>
                                    </form>
                                @else
                                    <form
                                        action="{{ route('user.change-role', ['id' => $user->id,'newRole' => 'admin']) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning">
                                            <i class="bi bi-arrow-up-circle"></i> {{__('titles.user.upgrade')}}
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash3"></i> {{__('titles.general.delete')}}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
