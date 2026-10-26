<?php

namespace App\Http\Controllers;

use App\Infrastructure\Service\PackService;
use App\Infrastructure\Service\SiteNewsService;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function index(PackService $packService, SiteNewsService $newsService): View
    {
        return view('index', [
            'latest' => $packService->latest(),
            'news' => $newsService->getLatestNews(),
        ]);
    }
}
