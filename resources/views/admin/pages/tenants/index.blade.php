@extends('adminlte::page')

@section('title', 'Tenants')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tenants.index') }}">Empresas</a></li>
    </ol>
    <h1>Produtos <a href="{{ route('tenants.create') }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> Adicionar</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="header">
           <form action="{{ route('tenants.search') }}" method="POST" class="form form-inline">
               @csrf
                <input type="text" name="filter" id="filter" placeholder="Filtrar:" class="form-control" value={{ $filters['filter'] ?? '' }}>
                <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i> Filtrar</button>
           </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="100">Imagem</th>
                        <th>Nome</th>
                        <th width="190">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $tenant)
                        <tr>
                            <td>
                                <img src="{{ url("storage/{$tenant->logo}") }}" alt="{{$tenant->logo}}" style="max-width: 50px;">
                            </td>
                            <td>
                                {{ $tenant->name }}
                            </td>
                            <td>
                                <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-info">Editar</a>
                                <a href="{{ route('tenants.show', $tenant->id) }}" class="btn btn-warning">VER</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if(isset($filters))
                {!! $tenants->appends($filters)->links() !!}
            @else
                {!! $tenants->links() !!}
            @endif
        </div>
    </div>
@stop