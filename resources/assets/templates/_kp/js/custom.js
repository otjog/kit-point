//Quantity Button
let quantity = {
    'buttons': {
        'increment' : document.getElementsByClassName('quantity_inc'),
        'decrement' : document.getElementsByClassName('quantity_dec'),
        'delete'    : document.getElementsByClassName('quantity_del'),
        'update'    : document.getElementsByClassName('quantity_upd')
    },
    'inputs'    : document.getElementsByClassName('quantity_input'),
    'form'      : document.getElementById('basket_form')
};

for(let buttonsType in quantity.buttons){

    if(quantity.buttons.hasOwnProperty(buttonsType)){

        for( let buttonIndex = 0; buttonIndex < quantity.buttons[buttonsType].length; buttonIndex++){

            switch(buttonsType){
                case 'increment':
                case 'decrement':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        e = e || event;
                        changeQuantity(e, buttonIndex)
                    });
                    break;
                case 'delete':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        quantity.inputs[buttonIndex].value = 0;
                        quantity.form.submit();
                    });
                    break;
                case 'update':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        //любая кнопка обновляет все товары
                        quantity.form.submit();
                    });
                    break;
            }

        }

    }

}

function changeQuantity(e, buttonIndex){

    let target = e.target;

    if(target.tagName === 'I'){
        target = target.parentElement;

    }

    if (target.classList.contains('quantity_inc')) {
        ++quantity.inputs[buttonIndex].value;
    } else if(target.classList.contains('quantity_dec')){

        let minValue = target.dataset.quantityMinValue;

        if(quantity.inputs[buttonIndex].value > minValue)
            --quantity.inputs[buttonIndex].value;
    }
}
//END Quantity Button

//FancyBox

let fancyOptions = {
    openEffect	: 'none',
    closeEffect	: 'none',
    padding : 0,
    loop: true,
    buttons: [
        //"zoom",
        //"share",
        //"slideShow",
        //"fullScreen",
        //"download",
        "thumbs",
        "close"
    ],
};

$(".fancybox").fancybox(fancyOptions);
//создает галерею по клику на главном изображении
$(".image_selected a").click(function() {

    let imageLinks = $("div.single_product ul.image_list a.fancybox");

    if(imageLinks.length === 0){
        imageLinks = $("div.single_product div.image_selected a");
    }

    let arrImgHref = [];

    for(let i = 0; i < imageLinks.length; i++){
        arrImgHref[i] = { 'src' : $(imageLinks[i]).attr('href') }
    }

    $.fancybox.open(arrImgHref, fancyOptions);

    return false;

});

//обрежем высоту галереи по высоте основного изображения. !!!Временное решение
let mainImg     = $("div.single_product div.image_selected");
let listThumb   = $("div.single_product ul.image_list");
let mainImgOutHeight    = mainImg.outerHeight();
let listThumbOutHeight  = listThumb.outerHeight();

if(listThumbOutHeight > mainImgOutHeight){
    let listThumbHeight = listThumb.height();
    let diff = listThumbOutHeight - mainImgOutHeight;
    listThumb.height(listThumbHeight - diff).css('overflow', 'hidden');
}
//END FancyBox


//Tabs
let tabs = document.getElementById('tabs');

if(tabs !== null && tabs !== undefined){
    let activeTab       = tabs.getElementsByClassName('active');
    let content         = document.getElementById('tab-data');
    let contentDatas    = content.getElementsByClassName('tab-data');

    if(activeTab[0].nodeName === 'A'){

        let tabIndex = activeTab[0].dataset.tabindex;

        if(tabIndex !== undefined && tabIndex !== null) {
            toogelDisplayStyle(content, contentDatas, activeTab[0].dataset.tabindex);
        }

    }



    tabs.addEventListener('click', function (e) {

        e = e || event;

        if(e.target.nodeName === 'A'){
            //узнаем наименование вкладки
            let tabIndex = e.target.dataset.tabindex;

            if(tabIndex !== undefined && tabIndex !== null){
                //включаем у вкладки класс active
                activeTab[0].classList.toggle('active');

                e.target.classList.toggle('active');

                toogelDisplayStyle(content, contentDatas, tabIndex)
            }

        }

    });
}

function toogelDisplayStyle(content, contentDatas, tabIndex){
    for(let i = 0; i < contentDatas.length; i++){
        contentDatas[ i ].style.display = 'none';
    }

    content.getElementsByClassName('data-' + tabIndex)[0].style.display = 'block';
}
//END Tabs

/* DaData ************/
import DaData from './dadata';
let forms = document.forms;

for(let f = 0; f < forms.length; f++){

    for(let inp = 0; inp < forms[f].elements.length; inp++){

        for(let i in forms[f].elements[inp].dataset){

            if(i === 'suggestion'){

                let type = forms[f].elements[inp].dataset[i];

                let id = forms[f].elements[inp].id;

                if(id !== ''){

                    let formSuggest = new DaData(id, type);

                    formSuggest.suggestions();

                }

            }

        }

    }

}
//END DaData

/**
 * Получаем объект Доставки
 * И сразу выполняем расчет доставки и получение пунктов выдачи
 */
import Shipment from './shipment';
let shipment = new Shipment();
shipment.getOffers();
shipment.getPoints();
/*******/
