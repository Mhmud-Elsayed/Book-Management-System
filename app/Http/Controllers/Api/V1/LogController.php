<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;

/**
 * @OA\Tag(
 *     name="Logs",
 *     description="API Endpoints for  Logs Management"
 * )
 */

class LogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/logs",
     *     operationId="getAllLogs",
     *     tags={"Logs"},
     *     summary="Get all system logs",
     *     description="Retrieve all system logs with latest first ordering",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logs retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="count", type="integer", example=150),
     *                 @OA\Property(property="logs", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="user_id", type="integer", nullable=true, example=1),
     *                         @OA\Property(property="endpoint", type="string", example="/api/v1/login"),
     *                         @OA\Property(property="method", type="string", example="POST"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
     *                         @OA\Property(property="user", type="object", nullable=true,
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="John Doe"),
     *                             @OA\Property(property="email", type="string", example="john@example.com")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No logs found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No logs found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred while retrieving logs"),
     *             @OA\Property(property="error", type="string", example="Error details here")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {

            $logs = Log::latest()->get();
            if ($logs->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No logs found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message'=> 'logs retrieved succesfully',
                'data' => [
                    'count' => $logs->count(),
                    'logs' => $logs],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving logs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/user-logs/{userId}",
     *     operationId="getUserLogs",
     *     tags={"Logs"},
     *     summary="Get logs for a specific user",
     *     description="Retrieve all logs for a specific user ID with latest first ordering",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User logs retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="count", type="integer", example=25),
     *                 @OA\Property(property="logs", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="user_id", type="integer", example=1),
     *                         @OA\Property(property="endpoint", type="string", example="/api/v1/login"),
     *                         @OA\Property(property="method", type="string", example="POST"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found or no logs",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found or No logs found for this user")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid user ID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred while retrieving user logs"),
     *             @OA\Property(property="error", type="string", example="Error details here")
     *         )
     *     )
     * )
     */
    public function userLogs($userId)
    {
        try {
            if (! is_numeric($userId) || $userId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid user ID',
                ], 422);
            }
            $user = User::find($userId);
            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }
            $logs = Log::where('user_id', $userId)->latest()->get();
            if ($logs->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No logs found for this user',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'count' => $logs->count()],
                    'logs' => $logs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving user logs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
