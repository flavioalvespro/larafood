@extends('adminlte::page')

@section('title', 'Categorias disponíveis para o Produto {$product->title}')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('products.index') }}">Produtos</a></li>
    </ol>
    <h1>Categorias disponíveis para o Produto {{$product->title}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="header">
           <form action="{{ route('products.categories.available', $product->id) }}" method="POST" class="form form-inline">
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
                   <form action="{{ route('products.categories.attach', $product->id) }}" method="POST">
                       @csrf

                       @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <input type="checkbox" name="categories[]" value="{{$category->id}}">
                                </td>
                                <td>
                                    {{ $category->name }}
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
                {!! $categories->appends($filters)->links() !!}
            @else
                {!! $categories->links() !!}
            @endif
        </div>
    </div>
@stop