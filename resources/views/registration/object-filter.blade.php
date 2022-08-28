@foreach($user->accommodations as $item)
<div class="table-row">
    <div class="image-td">
        <figure>
            <img src="/images/143808571.png" alt="">
        </figure>
    </div>
    <div class="name-td">
        <span class="mobile-name">Name</span>
        <span>{{$item->title}}</span>
    </div>
    <div class="type-td">
        <span class="mobile-name">Type</span>
        <div>
            @if($item->accommodationable_type == 'App\Models\Hotel')
            <i>
                <img src="/images/Icon-hotel.png" alt="">
            </i>
            <span>{{ $item->hotel()->type->name}}</span>
            @else
            <i>
                <img src="/images/Icon-hotel.png" alt="">
            </i>
            <span>{{ $item->appartment()->type->name}}</span>
            @endif
        </div>

    </div>
    <div class="date-td">
        <span class="mobile-name">Date</span>
        <span>{{date('Y-m-d',strtotime($item->created_at))}}</span>
    </div>
    <div class="action-td">
        <span class="mobile-name">Action</span>

        @if($item->accommodationable_type == 'App\Models\Hotel')
        @if($item->hotel()->type->type == 'Hotel')
        <a href="{{route('hotels.show',$item->hotel())}}" class="btn btn-blue">change</a>
        @else
        <a href="{{route('youth-hotels.edit',$item->hotel())}}" class="btn btn-blue">change</a>
        @endif
        @endif

        @if($item->accommodationable_type == 'App\Models\Appartment')
        @if($item->appartment()->type->type == 'Appartment')
        <a href="{{route('appartments.edit',$item->appartment())}}" class="btn btn-blue">change</a>
        @else
        <a href="{{route('villas.edit',$item->appartment())}}" class="btn btn-blue">change</a>
        @endif
        @endif

    </div>
</div>
@endforeach
