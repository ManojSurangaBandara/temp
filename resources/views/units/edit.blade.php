@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Unit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item ">Master Data</li>
                        <li class="breadcrumb-item ">Unit Management</li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div>
            </div>
    </section>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">Update Unit</h3>
                    {{-- <div class="card-tools">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                    </div> --}}
                </div>

                <form role="form" action="{{ route('units.update',$unit->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="form-group row">
                            <label for="regiment_id" class="col-sm-2 col-form-label">Regiment</label>
                            <div class="col-sm-6">
                                <select class="form-control @error('regiment_id') is-invalid @enderror"
                                    name="regiment_id" value="{{ old('regiment_id') }}" id="regiment_id" required>
                                    @foreach ($regiments as $item)
                                    <option value="{{ $item->id }}" {{$unit->regiment_id == $item->id ?
                                        'selected':''}}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @error('regiment_id')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control @error('name')
                                is-invalid @enderror" name="name" value="{{ $unit->name }}" id="name"
                                    autocomplete="off">
                                <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i
                                class="fa fa-arrow-circle-left"></i> Back</a>
                        <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
            </div>

            </form>

        </div>
    </div>
</div>
</div>
@endsection
