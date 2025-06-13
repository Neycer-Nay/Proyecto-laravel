@extends('layouts.main')
@section('titulo', 'Crear Nuevo Usuario')

@section('contenido')
<main id="main" class="main">
    <div class="container">
        <h1 class="text-center mb-4">Crear nuevo usuario</h1>
        
        <div class="d-flex justify-content-center">
            <form action="{{ route('usuarios.store') }}" method="POST" class="w-100" style="max-width: 600px;">
                @csrf

                <div class="form-group mb-3">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control w-100 custom-input @error('nombre') is-invalid @enderror" 
                        id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese el nombre">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control w-100 custom-input @error('email') is-invalid @enderror" 
                        id="email" name="email" value="{{ old('email') }}" required placeholder="Ingrese el email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="rol">Rol</label>
                    <select class="form-control w-100 @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                        <option value="Gerente" {{ old('rol') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                        <option value="Contabilidad" {{ old('rol') == 'Contabilidad' ? 'selected' : '' }}>Contabilidad</option>
                        <option value="Supervisor" {{ old('rol') == 'Supervisor' || !old('rol') ? 'selected' : '' }}>Supervisor</option>
                        <option value="Tecnico" {{ old('rol') == 'Tecnico' ? 'selected' : '' }}>Técnico</option>
                        <option value="Recepcionista" {{ old('rol') == 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                    </select>
                    @error('rol')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control w-100 custom-input @error('password') is-invalid @enderror" 
                        id="password" name="password" required placeholder="Ingrese la contraseña">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-4">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" class="form-control w-100 custom-input" id="password_confirmation" 
                        name="password_confirmation" required placeholder="Confirme la contraseña">
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</main>



@endsection