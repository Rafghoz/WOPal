<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\RatingModel;
use App\Models\WopalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    protected $ratingModel;

    // Gunakan dependency injection untuk memasukkan model ke dalam controller
    public function __construct(RatingModel $ratingModel)
    {
        $this->ratingModel = $ratingModel;
    }

    public function getDataRating($packageId)
    {
        try {
            $ratings = RatingModel::with('user')
                ->where('id_package', $packageId)
                ->orderBy('created_at', 'desc')
                ->get();

            // $ratingCounts = [];
            // foreach ($ratings as $rating) {
            //     if (!isset($ratingCounts[$rating->rating])) {
            //         $ratingCounts[$rating->rating] = 0;
            //     }
            //     $ratingCounts[$rating->rating]++;
            // }

            // // Get initial rating for the current user
            // $initialRating = null;
            // if (auth()->check()) {
            //     $userId = auth()->id();
            //     $userRating = RatingModel::where('id_package', $packageId)
            //         ->where('id_user', $userId)
            //         ->first();
                
            //     if ($userRating) {
            //         $initialRating = $userRating->rating;
            //     }
            // }

            return response()->json([
                'ratings' => $ratings,
                // 'ratingCounts' => $ratingCounts,
                // 'initialRating' => $initialRating
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load ratings',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    

    public function getRatings($packageId)
    {
        try {
            $ratings = RatingModel::where('id_package', $packageId)->with('user')->get();
    
            if ($ratings->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No ratings found for this package.',
                    'data' => []
                ]);
            }
    
            return response()->json([
                'success' => true,
                'data' => $ratings
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch ratings.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function createRating(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string', // Konsisten dengan nama di model dan migration
            'id_package' => 'required|integer|exists:tb_packages,id',
        ], [
            'rating.required' => 'Rating harus disertakan.',
            'rating.min' => 'Rating tidak boleh kurang dari 1.',
            'rating.max' => 'Rating tidak boleh lebih dari 5.',
            'komentar.required' => 'Komentar harus disertakan.',
            'komentar.string' => 'Komentar harus berupa teks.',
            'id_package.required' => 'ID paket harus disertakan.',
            'id_package.exists' => 'ID paket tidak valid.',
        ]);

        try {
            // Simpan rating baru ke database
            $rating = new RatingModel();
            $rating->rating = $validatedData['rating'];
            $rating->komentar = $validatedData['komentar'];
            $rating->id_package = $validatedData['id_package'];
            $rating->id_user = Auth::user()->id;
            $rating->save();

            return response()->json([
                'code' => 200,
                'message' => 'Rating submitted successfully!',
                'data' => $rating,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit rating. ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
