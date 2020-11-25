@extends('adminlte::page')

@section('title', 'Perfis do Plano {$plan->name}')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Perfis</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('plans.profiles', $plan->id) }}">Planos</a></li>
    </ol>
    <h1>Perfis do Plano {{$plan->name}} <a href="{{ route('profiles.plans.available', $plan->id) }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> Adicionar Novo Perfil</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="50">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profiles as $profile)
                        <tr>
                            <td>
                                {{ $profile->name }}
                            </td>
                            <td>
                                <a href="{{ route('profiles.plans.detach', [$plan->id, $profile->id]) }}" class="btn btn-danger">Desvincular</a>
                            </td>
                        </tr>
                    @endforeach
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