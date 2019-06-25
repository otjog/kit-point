@include('_kp.modules.' . $module['module'] . '.' . $module['template'] . '.index',
    [
        'filters' => $modules[$module['resource']]['filters'],
        'routeData' => $modules[$module['resource']]['routeData']
    ])