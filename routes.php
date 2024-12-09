<?php

declare(strict_types=1);

use Controller\RouteController;
use Controller\PersonController;
use Controller\PageController;

(new RouteController())
    ->add('GET', '/', [PageController::class, 'homeController'])
    ->add('GET', '/form/add', [PageController::class, 'formAddDataController'])
    ->add('GET', '/form/view', [PageController::class, 'formViewDataController'])
    ->add('GET', '/form/edit', [PageController::class, 'formEditDataController'])

    ->add('POST', '/api/person/add', [PersonController::class, 'addPerson'])
    ->add('POST', '/api/person/update', [PersonController::class, 'updatePerson'])
    ->run();