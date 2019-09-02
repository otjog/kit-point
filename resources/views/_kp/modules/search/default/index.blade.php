{{-- Search --}}
<div class="col-lg-6 col-10 order-2 text-lg-left text-right">
    <div class="header_search my-3 my-md-0">
        <div class="header_search_content">
            <div class="header_search_form_container">
                <form action="{{route('search')}}" class="header_search_form clearfix">
                    <input type="search" name="search" required="required" class="header_search_input pl-2 pl-lg-5" placeholder="Искать на {{$global_data['info']['company_name']}}">
                    <button type="submit" class="header_search_button trans_300" value="Submit"><img src="{{asset('storage/_kp/images/search.png')}}" alt=""></button>
                </form>
            </div>
        </div>
    </div>
</div>