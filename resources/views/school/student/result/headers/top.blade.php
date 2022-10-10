<div class="flex-row">
    <div class="img-left logo-image">
        @php $imgUrl = $std->passport ? asset("/files/logo/".$school->school_logo) :'' @endphp
        <img src="{{$imgUrl}}" alt="" class="img img-responsive">
    </div>
    <div class="text-content">
        <h3 class="text-success h4">{{strtoupper(getSchoolName())}}</h3>
        <small>{{$school->school_moto}}</small>
        <p>{{$school->school_address}}</p>
        <span>{{$school->school_contact}}</span>
        <p>{{$school->school_email}}</p>
    </div>
    <div class="img-left logo-image">
        @php $imgUrl = asset("/files/edulite/svg/coat_of_arms_of_nigeria.svg") ?? '' @endphp
        <img src="{{$imgUrl}}" alt="" class="img img-responsive">
    </div>
</div>