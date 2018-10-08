<div class="modal fade" id="change-city-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Адрес доставки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" role="form" action="{{route('GetGeo')}}">
                <div class="modal-body">
                    <p>Укажите населенный пункт, чтобы увидеть варианты доставки</p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        <input
                                type="text"
                                class="form-control"
                                id="address"
                                name="address"
                                data-suggestion="ADDRESS"
                                data-event-update-delivery="click"
                                placeholder="308011 г.Белгород ул.Садовая д.118"
                                required="">

                        <input type="hidden" id="address_json" name="address_json">
                        {{csrf_field()}}
                        <div class="invalid-feedback">
                            Пожалуйста, укажите корректный адрес
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary update-delivery" data-dismiss="modal">Изменить</button>
                </div>
            </form>
        </div>
    </div>
</div>