<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreEvetnTypeRequest;

class EventTypeController extends Controller
{
    
    /**
     * getEventTypes
     *
     * @return JsonResponse
     */
    public function getEventTypes(): JsonResponse
    {
        $user = auth()->user();

        $eventTypes = $user->event_types;

        $result = [
            'status' => 'success',
            'data' => $eventTypes,
            'status_code' => JsonResponse::HTTP_OK,
            'message' => 'Event types retrieved successfully!',
        ];

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }
    
    /**
     * createNewEventType
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function createNewEventType(Request $request): JsonResponse
    {

        $rules = array(
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
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

        $existingColor = $user->event_types()->where('color', $requestData['color'])->exists();

        if ($existingColor) {
            return new JsonResponse([
                'status' => 'error',
                'data' => [],
                'status_code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Color already exists!',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $eventType = EventType::create([
                'user_id' => $user->id,
                'name' => $requestData['name'],
                'color' => $requestData['color'],
            ]);
    
            $result = [
                'status' => 'success',
                'data' => $eventType,
                'status_code' => JsonResponse::HTTP_OK,
                'message' => 'Event type created successfully!',
            ];
    
            return new JsonResponse($result, JsonResponse::HTTP_OK);
        }
    }

    /**
     * updateEventType
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */

    public function updateEventType(Request $request): JsonResponse
    {
        $rules = array(
            'id' => 'required|integer|exists:event_types,id',
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
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

        $eventType = $user->event_types()->find($requestData['id']);

        if (!$eventType) {
            return new JsonResponse([
                'status' => 'error',
                'data' => [],
                'status_code' => JsonResponse::HTTP_NOT_FOUND,
                'message' => 'Event type not found!',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $eventType->update([
            'name' => $requestData['name'],
            'color' => $requestData['color'],
        ]);

        $result = [
            'status' => 'success',
            'data' => $eventType,
            'status_code' => JsonResponse::HTTP_OK,
            'message' => 'Event type updated successfully!',
        ];

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     * deleteEventType
     *
     * @param  mixed $id
     * @return JsonResponse
     */

    public function deleteEventType(Request $request, $id): JsonResponse
    {

        $user = auth()->user();

        $eventType = $user->event_types()->find($id);

        if (!$eventType) {
            return new JsonResponse([
                'status' => 'error',
                'data' => [],
                'status_code' => JsonResponse::HTTP_NOT_FOUND,
                'message' => 'Event type not found!',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $eventType->delete();

        $result = [
            'status' => 'success',
            'data' => [],
            'status_code' => JsonResponse::HTTP_OK,
            'message' => 'Event type deleted successfully!',
        ];

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }



    
}
