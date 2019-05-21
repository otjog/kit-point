@if($products->lastPage() > 1)
    <!-- Указываем сколько показывать кнопок по умолчанию ( от 1 до 5 ) -->
    <?php $startPage = 1; $endPage = 5;?>
    <!-- Не показываем стрелки движения влево, если мы на первой странице -->
    <div class="row">
        <!-- Pagination Starts -->
        <div class="col-sm-6 pagination-block">
            <ul class="pagination rounded-0">
                @if($products->currentPage() != 1)
                    <li class="page-item"><a class="page-link rounded-0" href="{{$products->appends($parameters)->url(1)}}"><i class="fa fa-angle-double-left"></i></a></li>
                    <li class="page-item"><a class="page-link rounded-0" href="{{$products->appends($parameters)->previousPageUrl()}}"><i class="fa fa-angle-left"></i></a></li>
                @else
                    <li class="page-item disabled"><span class="page-link"><i class="fa fa-angle-double-left"></i></span></li>
                    <li class="page-item disabled"><span class="page-link"><i class="fa fa-angle-left"></i></span></li>
                @endif
            <!-- Когда мы показываем лишь часть кнопок, при нажатии на последнюю видимую, кнопки смещаются на одну позицию
                т.е были показаны страницы от 1 до 5, принажатии на 5 будут показаны от 2 до 6, и т.д до последней -->
                @if($products->currentPage() <= $products->lastPage() && $products->currentPage() >= $endPage)
                    <?php
                    $shift = $products->currentPage() - $endPage + 1;
                    $startPage  = $startPage + $shift;
                    $endPage    = $endPage + $shift;
                    ?>
                @endif
            <!-- Выводим в цикле кнопки, текущая страница не имеет ссылки на саму себя -->
                @for($i = $startPage; $i <= $endPage && $i <= $products->lastPage(); $i++)
                    @if($products->currentPage() != $i)
                        <li class="page-item"><a class="page-link rounded-0" href="{{$products->appends($parameters)->url($i)}}">{{$i}}</a></li>
                    @else
                        <li class="page-item active"><span class="page-link">{{$i}}</span></li>
                    @endif
                @endfor
            <!-- Не показываем стрелки движения вправо, если мы на последеней странице -->
                @if($products->currentPage() != $products->lastPage())
                    <li class="page-item"><a class="page-link rounded-0" href="{{$products->appends($parameters)->nextPageUrl()}}"><i class="fa fa-angle-right"></i></a></li>
                    <li class="page-item"><a class="page-link rounded-0" href="{{$products->appends($parameters)->url($products->lastPage())}}"><i class="fa fa-angle-double-right"></i></a></li>
                @else
                    <li class="page-item disabled"><span class="page-link"><i class="fa fa-angle-right"></i></span></li>
                    <li class="page-item disabled"><span class="page-link"><i class="fa fa-angle-double-right"></i></span></li>
                @endif
            </ul>
        </div>
        <!-- Pagination Ends -->
    </div>
@endif