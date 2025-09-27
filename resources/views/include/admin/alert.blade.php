@if(Session::has('alert-success'))
<div class="shop-pagination pb-3">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div class="alert alert-primary" style="width:100%">
                {{Session::get('alert-success')}}
            </div>
        </div>
    </div>
</div>
        
    
    
@elseif(Session::has('alert-danger'))
<div class="shop-pagination pb-3">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div class="alert alert-danger" style="width:100%">
                {{Session::get('alert-danger')}}
            </div>
        </div>
    </div>
</div>

    
@elseif(Session::has('alert-warning'))
<div class="shop-pagination pb-3">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div class="alert alert-warning" style="width:100%">
                {{Session::get('alert-warning')}}
            </div>
        </div>
    </div>
</div>
@endif