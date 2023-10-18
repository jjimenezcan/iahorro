Pongo aquí las consideraciones de por qué he tomado las decisiones.

Ya que se indica que es una API REST, no tiene sentido el código con views, 
ya que debe funcionar todo el sistema como una api, por tanto hay una petición y una respuesta asociada, 
no hay interacción con el usuario y por tanto no tienen sentido las vitas.

De cara a los modelos aunque los he respetado creo que el modelo cliente no tiene sentido, o bien 
existe cliente con todos los datos, o bien existe lead con todos los datos, a pesar de esto he respetado
las especificaciones y he dejado los dos modelos.

De cara al controlador, ya que es un API Rest, he eliminado el servicio edit, 
ya que su funcionamiento es idéntico al de update por tanto innecesario.

No he incluido la validación con SANCTUM ya que dependiendo del destino de la api puede no ser conveniente, 
pero sería sencillo añadirlo al middleware.

Los ficheros que he tocado o añadido son:
App\Exceptions\Handler.php
App\Controllers\LeadController.php
App\Request\StoreLeadRequest.php
App\Request\UpdateLeadRequest.php
App\Models\Client.php
App\Models\Lead.php
App\Services\LeadScoringService.php
database\factories\ClientFactory.php
database\factories\LeadFactory.php
database\migrations\*created_leads_table.php
database\migrations\|*created_clients_table.php
database\|seeders\DatabaseSeeder.php
routes\api.php
tests\Feature\LeadTest.php

Todos los ficheros han sido creados con artisan, menos los que trae por defecto el framework. 

A la hora de implementar la prueba, se podría haber planteado con DDD o TDDD, pero como no se ha mencionado nada
no lo puesto en práctica.