<!-- Search -->
<div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
    <div class="header_search">
        <div class="header_search_content">
            <div class="header_search_form_container">
                <form action="{{route('search')}}" class="header_search_form clearfix">
                    <input type="search" name="search" required="required" class="header_search_input" placeholder="Умный поиск">
                    <button type="submit" class="header_search_button trans_300" value="Submit"><img src="{{asset('storage/_kp/images/search.png')}}" alt=""></button>
                </form>
            </div>
        </div>
    </div>
</div>