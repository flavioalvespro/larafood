@extends('adminlte::page')

@section('title', 'Detalhes do Produto')

@section('content_header')
    <h1>Detalhes do Produto: {{$product->name}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <img src="{{ url("storage/{$product->image}") }}" alt="{{$product->title}}" style="max-width: 50px;">
                </li>
                <li>
                    <strong>Title: </strong> {{$product->title}}
                </li>
                <li>
                    <strong>Flag: </strong> {{$product->flag}}
                </li>
                <li>
                    <strong>Descrição: </strong> {{$product->description}}
                </li>
            </ul>

            @include('admin.includes.alerts')

            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Deletar o produto {{$product->title}}</button>
            </form>
        </div>
    </div>
@endsection