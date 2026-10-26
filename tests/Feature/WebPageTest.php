<?php

namespace Tests\Feature;

use App\Models\Bot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\XdccData;
use Tests\TestCase;

class WebPageTest extends TestCase
{
    use RefreshDatabase;
    use XdccData;

    private Bot $bot;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->bot = $this->createBot('Web|Bot');
        $this->createPack($this->bot, 1, '[Group] Web Show - 01 [1080p].mkv', modified: '2026-01-01 00:00:00');
        $this->createPack($this->bot, 2, '[Group] Web Show - 02 [1080p].mkv', modified: '2026-01-02 00:00:00');
    }

    public function test_home_page_lists_latest_packs(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('[Group] Web Show - 02 [1080p].mkv')
            ->assertSee('Web|Bot');
    }

    public function test_bots_page_lists_bots(): void
    {
        $this->get('/bots')
            ->assertOk()
            ->assertSee('Web|Bot')
            ->assertSee('2');
    }

    public function test_bot_page_shows_packs(): void
    {
        $this->get('/bots/Web|Bot')
            ->assertOk()
            ->assertSee('[Group] Web Show - 01 [1080p].mkv')
            ->assertSee('[Group] Web Show - 02 [1080p].mkv');
    }

    public function test_bot_page_search_filters_packs(): void
    {
        $this->get('/bots/Web|Bot?query=web show - 01')
            ->assertOk()
            ->assertSee('[Group] Web Show - 01 [1080p].mkv')
            ->assertDontSee('[Group] Web Show - 02 [1080p].mkv');
    }

    public function test_unknown_bot_page_is_not_found(): void
    {
        $this->get('/bots/DoesNotExist')->assertNotFound();
    }

    public function test_search_page_finds_packs_across_bots(): void
    {
        $this->get('/search?query=web show')
            ->assertOk()
            ->assertSee('[Group] Web Show - 01 [1080p].mkv')
            ->assertSee('[Group] Web Show - 02 [1080p].mkv');
    }

    public function test_search_page_without_query_shows_no_results(): void
    {
        $this->get('/search')
            ->assertOk()
            ->assertDontSee('[Group] Web Show - 01 [1080p].mkv');
    }

    public function test_packs_of_inactive_bots_are_not_listed(): void
    {
        $inactive = $this->createBot('Dead|Bot', statusId: Bot::STATUS_ACTIVE + 1);
        $this->createPack($inactive, 1, '[Group] Dead Show - 01.mkv', modified: '2026-03-01 00:00:00');

        $this->get('/')->assertOk()->assertDontSee('[Group] Dead Show - 01.mkv');
        $this->get('/bots')->assertOk()->assertDontSee('Dead|Bot');
        $this->get('/search?query=dead show')->assertOk()->assertDontSee('[Group] Dead Show - 01.mkv');
    }
}
