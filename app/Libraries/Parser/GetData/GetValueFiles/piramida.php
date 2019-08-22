<?php

switch($clearTableName){

    case 'categories' :
        $searched = $searched->prev();
        break;
    case 'products' :
        if($columnName === 'scu') {
            return str_replace([' ', 'Артикул:'], '', trim($searched->text()));
        }
        if($columnName === 'description') {
            return $searched->html();
        }
        break;
    case 'product_has_price' :
        if($columnName === 'value'){
            return (int)str_replace([' ', 'руб.'], '', trim($searched->text()));
        }
        break;
    case 'product_has_parameter' :
        if($columnName === 'value'){
            $values = [];
            $ths = $searched->find('th');
            $tds = $searched->find('td');

            foreach ($ths as $key=>$th) {

                $title = trim($th->nodeValue);

                if($title === 'Аналоги' && $explodedTableName[1] === 'brand'){
                    $values = explode(', ', $tds->elements[$key]->nodeValue);
                }

                if($title === 'Тип теплообменника' && $explodedTableName[1] === 'type_exchanger'){
                    $values = explode(', ', $tds->elements[$key]->nodeValue);
                }

                if($title === 'Объем, л' && $explodedTableName[1] === 'volume'){
                    $values = explode(', ', $tds->elements[$key]->nodeValue);
                }
            }
            return $values;
        }
        break;
    case 'images' :
        if($columnName === 'src'){
            $images = [];
            foreach($searched as $image){
                $pq_image = pq($image);
                $image = $this->host . $pq_image->attr('data-href');
                $images[] = str_ireplace('.jpg', '_small10.jpg', $image);
            }
            return $images;
        }
        break;
}

return trim($searched->text());