<!-- Search Starts -->
<div class="col-xl-3 col-md-4 col-sm-12">
    <div id="search">
        <form action="{{ route( 'search' ) }}" role="form" method="get" name="search">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Введите поисковый запрос">
                <span class="input-group-btn">
                    <button class="btn" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>
<!-- Search Ends -->