@include('admin.includes.alerts')
<div class="form-group">
    <label>Nome: *</label>
    <input type="text" name="name" class="form-control" placeholder="Nome:" value="{{ $tenant->name ?? old('name') }}">
</div>
<div class="form-group">
    <label>Logo:</label>
    <input type="file" name="logo" class="form-control">
</div>
<div class="form-group">
    <label>Email: *</label>
    <input type="email" name="email" class="form-control" placeholder="Email:" value="{{ $tenant->email ?? old('email') }}">
</div>
<div class="form-group">
    <label>CNPJ: *</label>
    <input type="text" name="cnpj" class="form-control" placeholder="CNPJ:" value="{{ $tenant->cnpj ?? old('cnpj') }}">
</div>
<div class="form-group">
    <label>Ativo ?</label>
    <select name="active" class="form-control">
        <option value="Y" @if(isset($tenant) && $tenant->active == 'Y') ? selected @endif>Sim</option>
        <option value="N" @if(isset($tenant) && $tenant->active == 'N') ? selected @endif>Não</option>
    </select>
</div>
<hr>
<h3>Assinatura</h3>
<div class="form-group">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>