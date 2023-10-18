<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LeadTest extends TestCase
{
    public function test_set_database_config ():void
    {
        Artisan::call('migrate:reset');
        Artisan::call('migrate');
        Artisan::call('db:seed');

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_show (): void
    {
        $response = $this->get('/api/show/1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'lead' => [
                'id', 'name', 'email', 'phone', 'score', 'created_at', 'updated_at'
            ]
        ]);
    }

    public function test_lead_get_show_non_exixting ():void
    {
        $this->get('/api/show/100')
             ->assertStatus(400)
             ->assertJsonStructure([
                'status',
                'error'
            ]);
    }

    public function test_lead_store_ok ():void
    {
        $this->post('/api/store', [
            'name' => 'hola',
            'email' => 'hola@yata.com',
            'phone' => '11111111',
        ])
        ->assertStatus(200)
        ->assertJsonStructure([
            'status', 'Message'
        ])
        ->assertJsonFragment(['status' => true])
        ->assertJsonFragment(['Message' => 'Lead created successfully']);
    }

    public function test_lead_store_failure ():void
    {
        $this->json('POST', '/api/store', [
            'name' => 'hola',
            'email' => 'hola@yata.com',
            'phone' => '11111111',
        ])
        ->assertStatus(422)
        ->assertJsonStructure([
            'status', 
            'errores'
        ])
        ->assertJsonFragment(['status' => 'Los datos proporcionados no son válidos']);
    }

    public function test_lead_update_ok ():void
    {
        $this->json('PUT', '/api/update/1', [
            'name' => 'hola',
            'email' => 'hola2@yata.com',
            'phone' => '11111111',
        ])
        ->assertStatus(200)
        ->assertJsonFragment(['status' => true])
        ->assertJsonFragment(['Message' => 'Lead updated successfully']);
    }

    public function test_lead_update_failure ():void
    {
        $this->json('PUT', '/api/update/100', [
            'name' => 'hola',
            'email' => 'hola2@yata.com',
            'phone' => '11111111',
        ])
        ->assertStatus(400)
        ->assertJsonStructure([
            'status', 
            'error'
        ])
        ->assertJsonFragment(['error' => 'Error modelo no encontrado']);
    }

    public function test_lead_destroy_ok ():void
    {
        $this->json('DELETE', '/api/delete/1')
        ->assertStatus(200)
        ->assertJsonFragment(['status' => true])
        ->assertJsonFragment(['Message' => 'Lead deleted successfully']);
    }

    public function test_lead_destroy_failure ():void
    {
        $this->json('DELETE', '/api/delete/100')
        ->assertStatus(400)
        ->assertJsonStructure([
            'status', 
            'error'
        ])
        ->assertJsonFragment(['error' => 'Error modelo no encontrado']);
    }
}
