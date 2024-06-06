<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getEvent()
    {
        $user = auth()->user();

        $calendarEvents = $user->calendar_events;

        $result = [
            'status' => 'success',
            'data' => $calendarEvents,
            'status_code' => JsonResponse::HTTP_OK,
            'message' => 'Events retrieved successfully!',
        ];

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createNewEvent(Request $request)
    {
        $rules = array(
            'event_type_id' => 'required|integer|exists:event_types,id',
            'title' => 'required|string|max:255',
            'duration' => [
                'required',
                'string',
                'regex:/^(?:[01]\d|2[0-3]):[0-5]\d$/',
                function ($attribute, $value, $fail) {
                    list($hours, $minutes) = explode(':', $value);
                    if ($hours > 23 || $minutes > 59) {
                        $fail('The '.$attribute.' format is invalid.');
                    }
                },
            ],
            'mondatory' => 'required|boolean',
            'happy' => 'required|integer|between:-10,10',
            'meaning' => 'required|integer|between:-10,10',
            'date' => 'required|date',
        );
        $requestData = $request->all();
        $validator= Validator::make($requestData,$rules);

        if (isset($validator) && $validator->fails()) {
            return new JsonResponse([
                'status' => 'error',
                'data' => [],
                'status_code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = auth()->user();

        $calendarEvent = new CalendarEvent();
        $calendarEvent->user_id = $user->id;
        $calendarEvent->event_type_id = $request->event_type_id;
        $calendarEvent->title = $request->title;
        $calendarEvent->description = $request->description;
        $calendarEvent->duration = $request->duration;
        $calendarEvent->mondatory = $request->mondatory;
        $calendarEvent->happy = $request->happy;
        $calendarEvent->meaning = $request->meaning;
        $calendarEvent->date = $request->date;
        $calendarEvent->save();

        $result = [
            'status' => 'success',
            'data' => $calendarEvent,
            'status_code' => JsonResponse::HTTP_OK,
            'message' => 'Event created successfully!',
        ];

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalendarEvent $calendarEvent)
    {
        //
    }
}
