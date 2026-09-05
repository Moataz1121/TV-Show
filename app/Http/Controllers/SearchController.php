<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    public function index(Request $request): View
    {
        $query = (string) $request->input('q', '');
        $results = $this->searchService->search($query);

        return view('search.index', [
            'query' => $results['query'],
            'shows' => $results['shows'],
            'episodes' => $results['episodes'],
        ]);
    }
}
