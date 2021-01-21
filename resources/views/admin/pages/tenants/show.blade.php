@extends('adminlte::page')

@section('title', 'Detalhes da Empresa')

@section('content_header')
    <h1>Detalhes da Empresa: {{$tenant->name}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <img src="{{ url("storage/{$tenant->logo}") }}" alt="{{$tenant->logo}}" style="max-width: 50px;">
                </li>
                <li>
                    <strong>Plano: </strong> {{$tenant->plan->name}}
                </li>
                <li>
                    <strong>Nome: </strong> {{$tenant->name}}
                </li>
                <li>
                    <strong>URL: </strong> {{$tenant->url}}
                </li>
                <li>
                    <strong>Email: </strong> {{$tenant->email}}
                </li>
                <li>
                    <strong>CNPJ: </strong> {{$tenant->cnpj}}
                </li>
                <li>
                    <strong>Ativo: </strong> {{$tenant->active}}
                </li>
            </ul>

            <hr>
            <h3>Assinatura</h3>
            <ul>
                <li>
                    <strong>Data Assinatura: </strong> {{$tenant->subscription}}
                </li>
                <li>
                    <strong>Data Expira: </strong> {{$tenant->expires_at}}
                </li>
                <li>
                    <strong>Identificador: </strong> {{$tenant->subscription_id}}
                </li>
                <li>
                    <strong>Ativo: </strong> {{$tenant->subscription_active ? 'Sim' : 'Não'}}
                </li>
                <li>
                    <strong>Cancelou ?: </strong> {{$tenant->subscription_suspended ? 'Sim' : 'Não'}}
                </li>
            </ul>
            @include('admin.includes.alerts')
        </div>
    </div>
@endsection