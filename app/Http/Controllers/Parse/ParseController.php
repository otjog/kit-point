<?php

namespace App\Http\Controllers\Parse;

use App\Models\Shop\Category\Category;
use App\Models\Shop\Product\Product;
use App\Models\Site\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Parser\FromFolder;
use App\Libraries\Parser\FromSite;
use App\Libraries\Parser\FromXlsx;

class ParseController extends Controller
{

    private $parser;

    public function load(Request $request, Product $product, Category $category, Image $image, $from)
    {

        switch ($from) {
            case 'site' :
                $this->parser = new FromSite($request, $product, $category, $image);
                break;
            case 'xlsx' :
                $this->parser = new FromXlsx($request, $product, $category, $image);
                break;
            case 'folder' :
                $this->parser = new FromFolder($request, $product, $category, $image);
                break;
            default : return redirect('/');
        }

        $this->parser->parse();

    }
}
