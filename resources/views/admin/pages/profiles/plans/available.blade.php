@extends('adminlte::page')

@section('title', 'Planos disponíveis para o Perfil {$profile->name}')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('profiles.index') }}">Perfis</a></li>
    </ol>
    <h1>Planos disponíveis para o Perfil {{$profile->name}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="header">
           <form action="{{ route('plans.profiles.available', $profile->id) }}" method="POST" class="form form-inline">
               @csrf
                <input type="text" name="filter" id="filter" placeholder="Nome ou descrição" class="form-control" value={{ $filters['filter'] ?? '' }}>
                <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i> Filtrar</button>
           </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                   <form action="{{ route('plans.profiles.attach', $profile->id) }}" method="POST">
                       @csrf

                       @foreach ($plans as $plan)
                            <tr>
                                <td>
                                    <input type="checkbox" name="plans[]" value="{{$plan->id}}">
                                </td>
                                <td>
                                    {{ $plan->name }}
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="500">
                                @include('admin.includes.alerts')
                                <button type="submit" class="btn btn-success">Vincular</button>
                            </td>
                        </tr>
                   </form>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $plans->appends($filters)->links() !!}
            @else
                {!! $plans->links() !!}
            @endif
        </div>
    </div>
@stop