@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Subir Nueva Imagen</div>

                    <div class="card-body">
                        <form action="{{ route('image.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
    
                            <div class="form-group row">
                                <label for="image" class="col-md-3 col-form-label text-md-right">Imagen</label>
                                <div class="col-md-7">
                                    <input type="file" name="image" id="image" class="form-control {{$errors->has('image') ? 'is-invalid' : ''}}" required/>

                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                        
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
                                <div class="col-md-7">
                                    <textarea type="text" name="description" id="description" class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}" required></textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                        
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-3">
                                    <input type="submit" class="btn btn-primary" value="Subir Imagen">
                                </div>
                            </div>
    
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection