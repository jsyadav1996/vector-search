<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $inputEmbedding = generateEmbedding($query);

        // For testing purposes, we can use the test_embeddings.json file
        // $json = Storage::disk('public')->get('test_embeddings.json');
        // $json = json_decode($json, true);
        // $inputEmbedding = $json[3]['embedding'];

        // Fetch all sub categories and calculate cosine similarity manually
        $subCategories = SubCategory::whereNotNull('embeddings')->with('category')->get();
        $results = [];

        foreach ($subCategories as $subCategory) {
            $storedEmbedding = json_decode($subCategory->embeddings, true);
            
            $similarity = cosineSimilarity($inputEmbedding, $storedEmbedding);
            
            $results[] = [
                'category' => $subCategory->category->name,
                'subCategory' => $subCategory->name,
                'score' => $similarity,
            ];
        }
        // Sort the results by score in descending order
        $sorted = array_values(Arr::sortDesc($results, function (array $value) {
            return $value['score'];
        }));
        $result = count($sorted) ? $sorted[0] : null;
        
        return view('search', compact('query', 'result'));
    }
} 