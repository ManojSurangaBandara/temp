@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div>
              </div>
        </section>
        <div class="row mt-2">

                {{-- <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 class="text-white">{{ $active_users_count }}</h3>
                            <p class="text-white">Active Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users">
                            </i>
                        </div>
                        <a class="small-box-footer" href="{{route('users.index')}}">
                            More info
                            <i class="fas fa-arrow-circle-right">

                            </i>
                        </a>
                    </div>
                </div> --}}

                @foreach ($forces as $item)
                    @if ($item->persons()->count() > 0)
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 class="text-white">{{ $item->persons()->count() }}</h3>
                                    <p class="text-white">{{ $item->name }} Personnels</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users">
                                    </i>
                                </div>
                                {{-- <a class="small-box-footer" href="{{route('persons.index')}}">
                                    More info
                                    <i class="fas fa-arrow-circle-right">

                                    </i>
                                </a> --}}
                            </div>
                        </div>                        
                    @endif                    
                @endforeach

                @foreach ($counts as $count)                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 class="text-white">{{ $count->count }}</h3>
                                <p class="text-white">{{ $count->force->name }} - {{ $count->ranaviru_type->name }} Personnels</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users">
                                </i>
                            </div>
                            {{-- <a class="small-box-footer" href="{{route('persons.index')}}">
                                More info
                                <i class="fas fa-arrow-circle-right">

                                </i>
                            </a> --}}
                        </div>
                    </div>
                @endforeach


        </div>
    </div>
@endsection
