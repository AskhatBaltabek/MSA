<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Notification[]|Collection|Response
     */
    public function index()
    {
        return Notification::all();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return void
     */
    public function show($id)
    {
        return Notification::findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        /**
         * Когда создается запись - отправляется email. смотреть NotificationObserver
         */
        $notification = Notification::create($request->all());

        SendNotificationJob::dispatch($notification)->onQueue('notification');
        Log::info('Dispatched order ' . $notification->id);

        return response($notification, Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $notification = Notification::findOrFail($id);

        $notification->update($request->all());

        return response($notification, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        Notification::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
