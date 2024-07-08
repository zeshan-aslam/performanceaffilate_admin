@extends('layouts.masterClone')

@section('title', 'Merchant')

@section('content')
<style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    
                        <div class="alert alert-danger">
                           
                            <p>Are you sure you want to remove this Merchant record?</p>
                            <p>
                                
                                <a href="{{route('Merchant.removeMerchant',$id)}}" class="btn btn-danger ml-2">Yes</a>
                                <a href="{{route('Merchant.index',$id)}}" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                   
                </div>
            </div>        
        </div>
    </div>

@endsection