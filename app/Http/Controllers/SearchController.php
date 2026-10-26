<?php

namespace App\Http\Controllers;

use App\Domain\QueryDto;
use App\Infrastructure\Service\PackService;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class SearchController extends Controller
{
    public function index(Request $request, PackService $packService): View
    {
        $params = $request->query();
        $rawPage = $params['page'] ?? null;
        $page = ($rawPage !== null && is_numeric($rawPage)) ? (int) $rawPage : 0;
        $query = QueryDto::fromRequest($params);

        $results = null;
        if ($query->isValid() === true) {
            $results = $packService->search($query, $page);
        }

        return view('search', ['query' => $query->getValue(), 'results' => $results]);
    }
}
