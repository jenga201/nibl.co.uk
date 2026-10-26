<?php

namespace App\Http\Controllers;

use App\Domain\BotQueryDto;
use App\Infrastructure\Service\BotService;
use App\Infrastructure\Service\PackService;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class BotController extends Controller
{
    public function index(BotService $botService): View
    {
        return view('bots', ['bots' => $botService->listAll()]);
    }

    public function show(Request $request, string $name, BotService $botService, PackService $packService): View
    {
        $bot = $botService->findByName($name);
        if ($bot === null) {
            abort(404, 'Bot not found');
        }

        $botQuery = BotQueryDto::fromRequest($request->query());
        $results = null;
        $lastPacks = null;

        if ($botQuery->getQueryDto()->isValid() === true) {
            $results = $packService->searchInBot($bot, $botQuery);
        } else {
            $lastPacks = $packService->latestBotPacks($bot, $botQuery);
        }

        return view('bot', [
            'bot' => $bot,
            'query' => $botQuery->getQueryDto()->getValue(),
            'results' => $results,
            'lastPacks' => $lastPacks,
            'previousPageNumber' => $botQuery->previousPageNumber(),
            'nextPageNumber' => $botQuery->nextPageNumber(),
        ]);
    }
}
