{{-- Точка входа для загрузки Сервисов доставки с помощью ViewComposer--}}
@include($global_data['project_data']['template_name'] . '.modules.shipment.components.' . $template['component'] . '.' . $template['resource'], ['deliveryTemplates' => $deliveryTemplates])

