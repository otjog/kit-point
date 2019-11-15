<?php

namespace App\Models\Shop\Price;

use Illuminate\Database\Eloquent\Model;
use XMLWriter;
use App\Facades\GlobalData;

class Pricelists extends Model
{
    public function getPriceList($products, $categories, $format)
    {
        switch ($format) {
            case 'yml' :
                return $this->getPriceListYML($products, $categories);
                break;
        }
    }

    protected function getPriceListYML($products, $categories)
    {
        $globalData = GlobalData::getParameters();

        $writer = new XMLWriter();
        // Выделение памяти под запись
        $writer->openMemory();
        // Создавать отступы
        $writer->setIndent = true;

        $writer->startDocument("1.0", "utf-8");

        $writer->startElement("yml_catalog");

            $this->getYmlAttributes($writer, ['date'=>date('Y-m-d h:i')]);

            $writer->startElement("shop");

                $this->getYmlElement($writer, 'name', $globalData['info']['app_name']);

                $this->getYmlElement($writer, 'company', 'ИП Новинкин О.В.');

                $this->getYmlElement($writer, 'url', $globalData['site_url']);

                $writer->startElement("currencies");
                    $currency = $globalData['components']['shop']['currency']['char_code'];
                    $this->getYmlElement($writer, 'currency', null, ['id'=>$currency, 'rate'=>'1']);
                $writer->endElement();

                $this->getCategoriesYML($writer, $categories);

                $this->getProductsYML($writer, $products);

            $writer->endElement();

            $writer->endElement();

        $writer->endDocument();
        // Получаем XML-строку
        return $writer->outputMemory();


    }

    protected function getCategoriesYML($writer, $categories)
    {
        $writer->startElement("categories");

        foreach ($categories as $category) {

            $writer->startElement("category");
                $this->getYmlAttributes($writer, ['id'=>$category->id]);

                if ($category->parent_id !== 0) {
                    $this->getYmlAttributes($writer, ['parentId'=>$category->parent_id]);
                }

                $writer->text($category->name);

            $writer->endElement();

        }

        $writer->endElement();
    }

    protected function getProductsYML($writer, $products)
    {
        $writer->startElement("offers");

        foreach ($products as $product) {

            $writer->startElement("offer");

                $this->getYmlAttributes($writer, ['id'=>$product->id]);

                $this->getYmlElement($writer, 'name', $product->name);

                $this->getYmlElement($writer, 'url', route('products.show', $product->id));

                $this->getYmlElement($writer, 'price', $product->price['value']);

                if ($product->price['sale'] > 0)
                    $this->getYmlElement($writer, 'oldprice', $product->price['value'] + $product->price['sale']);

                $this->getYmlElement($writer, 'currencyId', 'RUR');

                $this->getYmlElement($writer, 'categoryId', $product->category_id);

                if (count($product->images) > 0)
                    $imageSrc = $product->images[0]->src;
                else
                    $imageSrc = 'noimage';

                $this->getYmlElement($writer, 'picture', route('getImage',['product', 'l', $imageSrc, $product->id]));

                $this->getYmlElement($writer, 'delivery', true);

                $this->getYmlElement($writer, 'pickup', true);


            $writer->endElement();

        }

        $writer->endElement();
    }

    protected function getYmlElement($writer, $elName, $elText, $attrs = [])
    {
        $writer->startElement($elName);

            $this->getYmlAttributes($writer, $attrs);

            if ($elText !== null)
                $writer->text($elText);
        $writer->endElement();
    }

    protected function getYmlAttributes($writer, $attrs)
    {
        foreach ($attrs as $name => $value) {

            $writer->startAttribute($name);
                $writer->text($value);
            $writer->endAttribute();
        }
    }

}
