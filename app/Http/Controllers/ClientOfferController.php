<?php

namespace App\Http\Controllers;

use App\Models\ClientOffer;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($projectId, Request $request)
    {
        //
        if (!ClientOffer::where('project_id', $projectId)->exists()) {
            $clientOfferData = ClientOffer::create(
                [
                    'project_id' => $projectId,
                    'price' => $request->price,
                    'currency' => $request->currency,
                    'time' => $request->time,
                    'time_unit' => $request->time_unit
                ]
            );

            return response(['clientOfferData' => $clientOfferData], 200);
        }
        else{
             ClientOffer::where('project_id', $projectId)->update(
                [
                    'price' => $request->price,
                    'currency' => $request->currency,
                    'time' => $request->time,
                    'time_unit' => $request->time_unit,
                    'response'=>0
                ]
            );

            return response(['clientOfferData' => ClientOffer::where('project_id', $projectId)->first()], 200);
        }
    }




    public function response_to_offer($id,$response){
        ClientOffer::where("project_id", $id)->update(['response'=>$response]);
        $offer_data = ClientOffer::where("project_id", $id)->first();
        Project::where("id", $id)->update(
            [
                'status'=>'offer_accepted',
                'price'=>$offer_data->price." ".$offer_data->currency,
                'start_date'=>strtotime(date("Y-m-d H:s:i")),
                'end_date'=>$offer_data->time." ".$offer_data->time_unit
            ]
            );

        if($response == 1)
        return back()->with("success", "Proposed offer is accepted. Project price and deadline is set accordingly");
        if($response == -1)
        return back()->with("danger","Proposed offer is rejected. Admin is notified for making another offer");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientOffer  $clientOffer
     * @return \Illuminate\Http\Response
     */
    public function show(ClientOffer $clientOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientOffer  $clientOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientOffer $clientOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientOffer  $clientOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientOffer $clientOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientOffer  $clientOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientOffer $clientOffer)
    {
        //
    }
}
