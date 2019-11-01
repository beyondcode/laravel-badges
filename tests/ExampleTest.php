<?php

namespace Beyondcode\LaravelBadges\Tests;

use Beyondcode\LaravelBadges\Badge;
use Beyondcode\LaravelBadges\BadgeProvider;
use Beyondcode\LaravelBadges\Traits\HasBadges;
use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        require_once __DIR__.'/../database/migrations/create_badges_table.php';

        (new \CreateBadgesTable())->up();

        $this->loadLaravelMigrations();
    }

    protected function getPackageAliases($app)
    {
        return [
            'BadgeProvider' => \Beyondcode\LaravelBadges\Facades\BadgeProvider::class,
        ];
    }

    /** @test */
    public function it_can_create_badges()
    {
        $badge = Badge::create([
            'name' => 'one-year-membership',
            'description' => 'Granted to users that are members for more than a year.'
        ]);

        $this->assertTrue($badge->exists);
    }

    /** @test */
    public function it_can_associate_badges()
    {
        Badge::create([
            'name' => 'one-year-membership',
            'description' => 'Granted to users that are members for more than a year.'
        ]);

        \BadgeProvider::grant('one-year-membership')
            ->to(TestUser::class)
            ->when(function ($user) {
                return $user->created_at->lt(now()->subYear());
            });

        $user = TestUser::create([
            'name' => 'Marcel',
            'email' => 'marcel@beyondco.de',
            'password' => 'secret',
            'created_at' => now()->subMonths(12)
        ]);

        $this->assertCount(1, $user->badges);
    }
}

class TestUser extends User {
    use HasBadges;

    protected $guarded = [];
    protected $table = 'users';
}
