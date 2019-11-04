import Ajax from './ajax';

export default function ShopBasket()
{
    let formClass   = 'shop-buy-form';
    let moduleClass = 'shop-module-basket';
    let totalClass = 'shop-basket-total';
    let buttonGroupClass = 'shop-basket-button-group';
    let ajaxHeaders = {};
    let qsParams = {};

    this.initAjaxSubmitAllForms = function ()
    {
        initAjaxSubmitAllForms();
    };

    function onRouteController(form)
    {
        let path = form.getAttribute('action');
        let qsParams = {};
        /* Получим данные всех input формы, добавим свои данные для аякс и отправим их. */
        let formInputs = form.getElementsByTagName('input');

        //todo сделать проверку на input class btn
        for (let i = 0; i < formInputs.length; i++) {
            if (formInputs[i].hasAttribute('name') !== false)
                qsParams[formInputs[i].name] = formInputs[i].value;
        }

        let queryString = getQueryStringFromObject(qsParams, '');

        let ajaxName    = 'shop-basket-add_product';

        let ajaxMethod = 'POST';

        sendRequest(ajaxName, ajaxMethod, queryString, path, function(response){
            /*Перегружаем модуль корзины вверху страницы*/
            let htmlReload = document.getElementsByClassName(moduleClass)[0];
            if(htmlReload !== undefined && htmlReload !== null)
                updateHtml('module', htmlReload, function(htmlReload){});

            /*Перегружаем total_block на странице корзины*/
            htmlReload = document.getElementsByClassName(totalClass)[0];
            if(htmlReload !== undefined && htmlReload !== null)
                updateHtml('total-block', htmlReload, function(htmlReload){});

            /*Перегружаем блок с кнопками*/
            htmlReload = form.closest('.' + buttonGroupClass);
            if(htmlReload !== undefined && htmlReload !== null) {
                updateHtml('buy-button', htmlReload, function (htmlReload) {
                    let forms = htmlReload.getElementsByClassName(formClass);
                    initAjaxSubmitListForms(forms);
                });
            }
        });

    }

    function updateHtml(name, htmlReload, func)
    {
        let ajaxName    = 'shop-basket-update_html_' + name;

        let ajaxMethod = 'GET';

        let queryString = getQueryStringFromObject(qsParams, '');

        let path = htmlReload.getAttribute('data-route');

        sendRequest(ajaxName, ajaxMethod, queryString, path, function(response){
            htmlReload.innerHTML = String(response);
            func(htmlReload);
        });

    }

    function sendRequest(ajaxName, ajaxMethod, queryString, path, func)
    {
        let ajaxReq = new Ajax(ajaxMethod, queryString, ajaxHeaders, ajaxName, path);

        //todo проверить, если объекта нет, делать submit формы
        ajaxReq.req.onreadystatechange = function()
        {
            if (ajaxReq.req.readyState !== 4) return;

            func(ajaxReq.req.responseText);
        };

        ajaxReq.sendRequest();

    }

    function getQueryStringFromObject(object, queryString)
    {
        for (let parameter in object) {
            if(object.hasOwnProperty(parameter)){

                if (queryString !== '')
                    queryString += '&';

                queryString += parameter + '=' + object[parameter];

            }
        }

        return queryString;
    }

    function initAjaxSubmitAllForms()
    {
        let forms = document.getElementsByClassName(formClass);

        if (forms !== null && forms !== undefined) {

            for (let i = 0; i < forms.length; i++) {
                initAjaxSubmitOneForm(forms[i])
            }
        }
    }

    function initAjaxSubmitListForms(forms)
    {
        if (forms !== null && forms !== undefined) {

            for (let i = 0; i < forms.length; i++) {
                initAjaxSubmitOneForm(forms[i])
            }
        }
    }

    function initAjaxSubmitOneForm(form)
    {
        /**
         * Перехватываем отправку формы и отменяем её.
         */
        form.addEventListener('submit', function(event)
        {
            event.preventDefault();

            onRouteController(form);

        });

        let textInputs = form.querySelectorAll('input[type=text]');

        for (let i = 0; i < textInputs.length; i++) {
            textInputs[i].addEventListener('blur', function (event) {

                onRouteController(form);
            })
        }
    }
}