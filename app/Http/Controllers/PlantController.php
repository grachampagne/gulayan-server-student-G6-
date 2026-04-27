<?php

namespace App\Http\Controllers;

use App\Models\PlantModel;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PlantController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      $perPage = request('per_page', 10);
      
      $plants = PlantModel::paginate($perPage);

      return response()->json([
        'message' => 'Plants retrieved successfully',
        'success' => true,
        'data' => $plants->items(),
        'pagination' => [
          'current_page' => $plants->currentPage(),
          'per_page' => $plants->perPage(),
          'total' => $plants->total(),
          'last_page' => $plants->lastPage(),
          'from' => $plants->firstItem(),
          'to' => $plants->lastItem(),
        ],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Error retrieving plants',
        'success' => false,
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'variety' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'date_planted' => 'nullable|date',
        'seedling_count' => 'nullable|integer|min:0',
        'batch_name' => 'nullable|string|max:255',
        'starting_fund' => 'nullable|numeric|min:0',
        'seedling_source' => 'nullable|string',
      ]);

      $plant = PlantModel::create($validated);

      return response()->json([
        'message' => 'Plant record created successfully',
        'success' => true,
        'data' => $plant,
      ], 201);
    } catch (ValidationException $e) {
      return response()->json([
        'message' => 'Validation error',
        'success' => false,
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Error creating plant record',
        'success' => false,
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(PlantModel $plantController)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, PlantModel $plant)
  {
    try {
      $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'variety' => 'sometimes|string|max:255',
        'notes' => 'nullable|string',
        'date_planted' => 'nullable|date',
        'seedling_count' => 'nullable|integer|min:0',
        'batch_name' => 'nullable|string|max:255',
        'starting_fund' => 'nullable|numeric|min:0',
        'seedling_source' => 'nullable|string',
      ]);

      $plant->update($validated);

      return response()->json([
        'message' => 'Plant record updated successfully',
        'success' => true,
        'data' => $plant,
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'message' => 'Validation error',
        'success' => false,
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Error updating plant record',
        'success' => false,
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PlantModel $plant)
  {
    try {
      $plant->delete();

      return response()->json([
        'message' => 'Plant record deleted successfully',
        'success' => true,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Error deleting plant record',
        'success' => false,
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}
