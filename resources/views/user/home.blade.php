@extends('layouts.app')

@section('content')

<div class="container">
            
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

            <span style="direction: rtl;">بياناتي</span>
             <div class="card-header">
             <h5>الموظف:</h5>
             <span style="direction: rtl;">{{auth()->user()->name}}</span>
             <h5>الإدارة:</h5>
             <span style="direction: rtl;">{{auth()->user()->Administration}}</span>
             <br></br>
             <h5>:الرقم الوظيفي</h5>
             <span style="direction: rtl;">{{auth()->user()->amana_id}}</span>

                   </div>


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                  
                  @if(Auth::user()->passedLimit())
                        <h3>You have passed the limit for today</h3>
                  @endif
                    @if(!auth()->user()->isCheckedIn() && !Auth::user()->passedLimit())
                    <form method="POST" action="{{ route('store') }}">
                        @csrf
                        <button type="submit" class="btn btn-success">حضور</button>
                      
                      </form>
                      @endif
                        @if(auth()->user()->isCheckedIn() && !Auth::user()->passedLimit())
                      <form method="POST" action="{{ route('update')}}" >
                        @csrf
                        @method('PUT')
                        <button type="submit"  class="btn btn-success">إنصراف</button>
                      
                      </form>
                      @endif



                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
