import Ajax from './ajax';
import Shipment from './shipment';

export default function DaData(id, type){
    let token = "23933ff36c0c7e63248d1782df14d07badb394a0";
    let button = document.getElementsByClassName('update-geo');
    let requestName = 'geo';
    let headers = {};
    let qsParams = {
        module : requestName,
        response : 'json', //view or json
        address_json : ''
    };
    let queryString = '';

    this.suggestions = function(){
        $("#"+ id).suggestions({
            token: token,
            type: type,
            count: 5,
            onSelect: function(suggestion) {
                $("#" + id + "_json").val(JSON.stringify(suggestion.data));

                if(type === 'ADDRESS'){

                    let input = document.getElementById(id);

                    let eventToUpdate = input.dataset.eventToUpdate;

                    qsParams.address_json = JSON.stringify(suggestion.data);

                    queryString = setQueryStirng(qsParams);

                    switch(eventToUpdate){

                        case 'click' :

                            button[0].addEventListener('click', sendRequest, false);

                            break;

                        default : sendRequest();
                    }

                }

            }

        });
    };

    function sendRequest () {

        let ajaxReq = new Ajax("POST", queryString, headers, requestName);

        //todo проверить, если объекта нет, делать submit формы
        ajaxReq.req.onreadystatechange = function() {

            if (ajaxReq.req.readyState !== 4) return;

            let json = JSON.parse(ajaxReq.req.responseText);

            changeHtml(json);

            updateShipmentInfo();

        };

        ajaxReq.sendRequest();
    }

    function changeHtml(json){
        let geoLocationLinks = document.getElementsByClassName('geo-location-link');

        for(let i = 0; i < geoLocationLinks.length; i++){

            let linkElements = geoLocationLinks[i].getElementsByTagName('span');

            for(let y = 0; y < linkElements.length; y++){

                if(json.hasOwnProperty(linkElements[y].className)){
                    linkElements[y].innerHTML = json[linkElements[y].className];
                }
            }

        }
    }

    function updateShipmentInfo(){
        let shipment = new Shipment();

        shipment.getOffers();

        shipment.getPoints();
    }

    function setQueryStirng(parameters, queryString = ''){

        for(let parameter in parameters){

            if(queryString !== ''){
                queryString += '&';
            }

            if(parameters[parameter] !== ''){
                queryString += parameter;
                queryString += '=';
                queryString += parameters[parameter];
            }else{
                console.log("Нет данных у параметра " + parameter)
            }

        }

        return queryString;
    }
}