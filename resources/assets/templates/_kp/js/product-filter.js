(function() {

    let filters = document.getElementsByClassName( 'filter-action' );

    for( let i = 0; i < filters.length; i++ ) {
        if(filters[i].className.indexOf('filter-action-select') >= 0){
            filters[ i ].addEventListener('change', function(e){
                prepareRequest(e);
            });
        }else{
            filters[ i ].addEventListener('click', function(e){
                prepareRequest(e);
            });
        }
    }
})() ;

import Ajax from './ajax';

function prepareRequest(e){
    e = e || event;
    let target = getTarget(e.target);
    let oldValues = getOldValuesFromQueryString();
    let values = getValuesForQueryString(target, oldValues);
    let queryString = getNewQueryString(oldValues, values);

    if(queryString === false){
        showErrorMsg(target);
    }else{
        sendAjaxRequest(queryString, target);
    }
}

function getTarget(target){
    if(target.form === undefined || target.form === null){
        return {0 : target, 'length' : 1};
    }
    return target.form;
}

function getOldValuesFromQueryString(){
    var pattern = /([a-z0-9_]+)=([\w\%]+)/g;
    var oldParameters = {};
    var result;
    var countObjectKeys = 0;
    while ((result = pattern.exec(window.location.search)) !== null) {
        oldParameters[result[1]] = result[2].split('%7C').map(function callback(currentValue) {
            return decodeURIComponent(currentValue);
        });
        countObjectKeys++;
    }
    oldParameters['length'] = countObjectKeys;
    return oldParameters;
}

function getValuesForQueryString(target, oldValues){
    let values = {};

    for(let i = 0; i < target.length ;i++){
        if(target[i].tagName !== 'BUTTON'){

            let filterName = target[i].dataset.filterName;
            let filterType = target[i].dataset.filterType;

            let filterValue = '';

            if(filterType !== 'multiselect'){
                filterValue = target[i].dataset.filterValue || target[i].value;
            }
            let defaultValue = target[i].dataset.filterDefaultValue || '';

            if (!(filterName in values))
                values[filterName] = [];

            switch (filterType) {
                case 'checkbox':
                case 'radio':   if(!target[i].checked){break;}
                case 'input':   if(filterValue === defaultValue){break;}
                case 'slider':  //todo не отправлять дефолтные значения на сервер
                case 'select':
                case 'hidden':
                case 'switch':  values[filterName].push(filterValue);
                    break;
                case 'multiselect':
                    let options = target[i];

                    for (let i = 0; i<options.length; i++) {
                        if (options[i].selected) {
                            values[filterName].push(options[i].value);
                        }
                    }
                    break;
                case 'delete':  for(let y = 0; y < oldValues[filterName].length; y++){

                    if(oldValues[filterName][y] === filterValue){
                        if(target[i].dataset.filterParentType === 'slider-range'){
                            oldValues[filterName][y] = target[i].dataset.filterDefaultValue
                        }else{
                            oldValues[filterName].splice(y, 1);
                        }
                        return oldValues;
                    }
                }
                    break;
            }
        }
    }
    return values;
}

function getNewQueryString(oldValues, values){
    //todo если page=1 не добавлять в querystring
    for(var valueName in values) {
        if (values[valueName].length < 1) {
            if (oldValues[valueName] !== undefined) {
                delete oldValues[valueName];
                oldValues['length']--;
            }
        }else {
            if(oldValues['page'] !== undefined && valueName !== 'view' && valueName !== 'sort'){
                /**
                 * Если мы переходим на страницу 10, а потом в фильтре сужаем круг поиска,
                 * то увидим пустую страницу, т.к. новые результаты не доходят до 10 страницы.
                 * Поэтому при кажлм изменении фильтра мы сбрасываем (удаляем параметр page),
                 * кроме случаев когда мы изменяем сортировку или вид отображения товаров.
                 * */
                delete oldValues['page'];//todo изменить этот код, когда будет пагинация через Ajax
                oldValues['length']--;
            }
            if(oldValues[valueName] === undefined){
                oldValues['length']++;
            }
            oldValues[valueName] = values[valueName];
        }
    }

    var queryString = '';
    var i = 0;
    if(oldValues['length'] > 0){
        for(var valueName in oldValues){
            if(valueName !== 'length'){
                if(i !== 0) queryString += '&';

                queryString += valueName + '=';

                for(var y = 0; y < oldValues[valueName].length; y++){
                    if(y !== 0 ) queryString += '%7C';/* кодированный знак | разделяющий параметры*/
                    queryString += encodeURIComponent(oldValues[valueName][y]);
                }
                i++;
            }
        }
    }

    if(queryString === window.location.search)
        return false;
    return queryString;
}

function changeElementsBodyAfterRequest(target){
    var tagName = target.tagName || target[0].tagName;
    switch (tagName) {
        case 'A':   if(target[0].dataset.filterName === 'view'){
            switchClassActive(target[0]);
            break;
        }else{
            setDefaultValueForm(target);
            /*break внутри условия, так что для других A выполнится функция для FORM*/
        }
        case 'FORM': clearFilterTags(); break;
    }
}

function setDefaultValueForm(target){
    var filterName = target[0].dataset.filterName;
    var filterValue = target[0].dataset.filterValue || target[i].value;
    var filterType = target[0].dataset.filterType;
    //todo подобное определение переменных есть в другой функции
    var filter = document.getElementsByClassName('filter-' + filterName);
    var inputs = filter[0].getElementsByTagName('input');
    for(var i = 0; i < inputs.length; i++){
        var inputsFilterValue = inputs[i].dataset.filterValue || inputs[i].value;
        if(inputsFilterValue === filterValue){
            switch (inputs[i].type){
                case 'checkbox' : inputs[i].checked = false;
                    break;
                case 'text' : inputs[i].value = inputs[i].dataset.filterDefaultValue || '';
                //todo описать для остальных полей
                //todo ползунок слайдера не меняет позицию
            }
        }
    }
}

function switchClassActive(target){
    //работает только для 2 элементов
    target.className +=' active';

    var sibling = target.nextElementSibling || target.previousElementSibling;
    sibling.className = sibling.className.replace('active', '');
}

function clearFilterTags() {
    //document.getElementsByClassName('filter-tags')[0].innerHTML = '';
}

function showErrorMsg(target){
    //todo описать вывод сообщения об ошибке пользователю, если он ничего не ввел в поисковой запрос
    console.log(target);
}

function sendAjaxRequest(queryString, target) {

    history.pushState('', '', '?' + queryString);

    queryString += '&module=product_filter&response=view&view=list';

    let requestName = 'product_filter';

    let ajaxReq = new Ajax("GET", queryString, '', requestName);

    ajaxReq.req.onloadstart = function(){
        //
    };

    ajaxReq.req.ontimeout = function() {
        //
    };

    ajaxReq.req.onreadystatechange = function() {

        if (ajaxReq.req.readyState !== 4) return;

        let responseText = String(ajaxReq.req.responseText);

        let productsList = document.getElementById('product-list');

        changeElementsBodyAfterRequest(target);

        productsList.innerHTML = responseText;

        (function() {
            let filters = document.getElementsByClassName( 'filter-action-delete' );
            /*Вешаем события на динамически появившиеся иконки удаления параметров фильтра*/
            for( let i = 0; i < filters.length; i++ ) {
                filters[ i ].addEventListener('click', function(e){
                    prepareRequest(e);
                });
            }
        })();

    };

    ajaxReq.sendRequest();

}

/*****************************************************
    Product Filter
*****************************************************/

var sliders = $('.filter-slider');
for(var i = 0; i < sliders.length; i++){
    var values = getValues(sliders[i]);

    getSliderShow(sliders[i]).slider({
        range: true,
        min: values.range[0],
        max: values.range[1],
        values: [values.value[0], values.value[1]],
        slide: function(e, ui) {
            changeInputValue([ui.handleIndex], [ui.value], $(ui.handle.parentNode).closest('.filter-slider')[0]);
        }
    });
}

$('input[data-filter-type=slider]').on('change', function(e){
    console.log(1);
    e = e || event;
    var slider = $(e.target).closest('.filter-slider')[0];
    var values = getValues(slider);
    if($.isNumeric(Number(e.target.value))){
        if(values.value[0] > values.value[1]){
            if(values.value[0] > values.range[1]){
                values.value[0] = values.range[1];
                values.value[1] = values.range[1];
                changeInputValue([0,1], [values.range[1], values.range[1]], slider);
            }else if(values.value[1] < values.range[0]){
                values.value[1] = values.value[0];
                changeInputValue([1], [values.value[0]], slider);
            }else{
                values.value[1] = values.value[0];
                changeInputValue([1], [values.value[0]], slider);
            }
        }else if(values.value[0] < values.range[0]){
            values.value[0] = values.range[0];
            changeInputValue([0], [values.range[0]], slider);
        }else if(values.value[1] > values.range[1]){
            values.value[1] = values.range[1];
            changeInputValue([1], [values.range[1]], slider);
        }
    }else{
        var index = e.target.dataset.filterSliderInputIndex;
        values.value[index] = values.range[index];
        changeInputValue([index], [values.range[index]], slider);
    }
    changeSliderValue(values.value, slider);
});

function getValues(slider){
    var inputs = getInputs(slider);
    var inputsValue = {'value':[], 'range':[]};
    for(var i = 0; i < inputs.length ;i++){
        inputsValue.value[i] = Number(inputs[i].value);
        if(inputs.length === 1) break;
        //todo проверить работоспособность break
    }
    inputsValue.range[0] = Number(inputs[0].min);
    inputsValue.range[1] = Number(inputs[0].max);

    return inputsValue;
}

function getInputs(slider){
    return $(slider).find('input[data-filter-type=slider]');
}

function getSliderShow(slider){
    return $(slider).find('.slider-show');
}

function changeInputValue(index, values, slider){
    var inputs = getInputs(slider);
    for(var i = 0; i < index.length; i++){
        inputs[index[i]].value = values[i];
    }
}

function changeSliderValue(values, slider){
    getSliderShow(slider).slider("values", values);
}

/*Очистка фильтра. Для каждого типа фильтра */
$('.filter-clear').on('click', function(e){
    let filter = e.target.closest('.filter');
    let inputs = $(filter).find('[data-filter-type]');

    for(let i = 0; i < inputs.length; i++){

        switch(inputs[i].type){
            case 'checkbox' :
                if(inputs[i].checked === true){
                    inputs[i].checked = false;
                }
                break;

            case 'text' :
                if(inputs[i].dataset.filterType === 'slider'){
                    let values = [];
                    values[0] = inputs[i].min;
                    values[1] = inputs[i].max;
                    changeInputValue([0, 1], values, filter);
                    changeSliderValue(values, filter);
                }else{
                    inputs[i].value = '';
                }
                break;
            case 'select':
            case 'select-multiple':
                let options = inputs[i];
                for(let i = 0; i < options.length; i++){
                    if(options[i].selected === true){
                        options[i].selected = false;
                    }
                }
                break;
        }

    }
});
