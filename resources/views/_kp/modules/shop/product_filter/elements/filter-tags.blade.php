<div class="row filter-tags">
    <div class="col-md-12 col-sm-12">
        <?php
        if(isset($old_parameters) && count($old_parameters) > 0){
            foreach($old_parameters as $alias=>$values){
                if($alias != 'page' && $alias != 'view' && $alias != 'sort'){
                    foreach($values as $key=>$value){
                        $content = '';
                        switch ($filters[$alias]['filter_type']) {
                            case 'checkbox':
                                if($alias === 'manufacturer'){
                                    $content = $filters[$alias]['values'][$value];
                                }else{
                                    $content = $filters[$alias]['name'] . ' : ' . $filters[$alias]['values'][$value];
                                }
                                break;
                            case 'input':
                                $content = $filters[$alias]['name'] . ' : ' . $value;
                                break;
                            case 'slider-range':
                                //todo Нужна здесь проверка на число? Или проверять перед записью в БД для slider-range
                                $defaultValue = '';
                                switch($key){
                                    case 0 :    $defaultValue = min($filters[$alias]['values']);
                                        if((int)$value !== (int)$defaultValue)
                                            $content = $filters[$alias]['name'] . ': от ' . $value . $filters[$alias]['measure'];
                                        break;
                                    case 1 :    $defaultValue = max($filters[$alias]['values']);
                                        if((int)$value !== (int)$defaultValue)
                                            $content = $filters[$alias]['name'] . ': до ' . $value . $filters[$alias]['measure'];
                                        break;
                                }
                                break;
                        }
        ?>
                        @if($content !== '')
                            <span class="label label-warning filter-action filter-action-delete" style="margin:5px; padding:5px;">
                                                    {{$content}}
                                <a
                                        data-filter-type="delete"
                                        data-filter-parent-type="{{$filters[$alias]['filter_type']}}"
                                        data-filter-name="{{$alias}}"
                                        @if(isset($defaultValue)) data-filter-default-value="{{$defaultValue}}" @endif
                                        data-filter-value="{{$value}}"
                                        class="fa fa-times">

                                </a>
                            </span>
                        @endif
        <?php
                    }
                }
            }
        }
        ?>
    </div>
</div>