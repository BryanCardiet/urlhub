<?php

namespace Tests\Unit\Controllers;

use App\Url;
use App\UrlStat;
use Tests\TestCase;

class UrlRedirectControllerTest extends TestCase
{
    /**
     * @test
     * @group u-controller
     */
    public function url_redirection()
    {
        $url = factory(Url::class)->create();

        $response = $this->get(route('home').'/'.$url->url_key);
        $response->assertRedirect($url->long_url);
        $response->assertStatus(config('urlhub.redirection_code'));

        $this->assertCount(1, UrlStat::all());
    }
}
