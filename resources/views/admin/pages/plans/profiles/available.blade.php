@extends('adminlte::page')

@section('title', 'Perfis disponíveis para o Plano {$plan->name}')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('plans.index') }}">Planos</a></li>
    </ol>
    <h1>Perfis disponíveis para o Plano {{$plan->name}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="header">
           <form action="{{ route('profiles.plans.available', $plan->id) }}" method="POST" class="form form-inline">
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
                   <form action="{{ route('profiles.plans.attach', $plan->id) }}" method="POST">
                       @csrf

                       @foreach ($profiles as $profile)
                            <tr>
                                <td>
                                    <input type="checkbox" name="profiles[]" value="{{$profile->id}}">
                                </td>
                                <td>
                                    {{ $profile->name }}
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
                {!! $profiles->appends($filters)->links() !!}
            @else
                {!! $profiles->links() !!}
            @endif
        </div>
    </div>
@stop