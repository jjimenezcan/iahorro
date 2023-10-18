<?php
// app/Http/Controllers/LeadController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreLead;
use App\Models\Lead;
use App\Models\Client;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    private $leadScoringService;

    public function __construct()
    {
        $this->leadScoringService = new LeadScoringService();
    }

    public function store(StoreLeadRequest $Request)
    {
        $lead = new Lead();
        $lead->name = $Request->name;
        $lead->email = $Request->email;
        $lead->phone = $Request->phone;
        $lead->save();
        
        //Lead::created($Request->all());

        $client = new Client();
        $client->lead_id = $lead->id;
        
        if (!$client->save()){
            return response()->json([ "Message" => "Error when save model client"]);
        }

        // Interact with external lead scoring system
        $leadScoringService = new LeadScoringService();
        $score = $leadScoringService->getLeadScore($lead);
        $lead->score = $score;
        $lead->save();

        return response()->json([
            'status' => true,
            'Message' => 'Lead created successfully'
        ], 200);
    }

    public function show(Lead $lead)
    {
        return response()->json([
            'status' => true,
            'lead' => $lead
        ], 200);
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        // Send lead to scoring system
        $score = $this->leadScoringService->getLeadScore($lead);
        $lead->update($request->all() + ['score' => $score]);
        return response()->json([
            'status' => true,
            'Message' => 'Lead updated successfully'
        ], 200);
    }

    public function destroy(Lead $lead)
    {        
        $lead->delete();
        return response()->json([
            'status' => true,
            'Message' => 'Lead deleted successfully'
        ], 200);
    }
}
