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
    case 'images' :
        if($columnName === 'src'){
            $images = [];
            foreach($searched as $image){
                $pq_image = pq($image);
                $images[] = $this->host . $pq_image->attr('href');
            }
            return $images;
        }
        break;
}

return trim($searched->text());