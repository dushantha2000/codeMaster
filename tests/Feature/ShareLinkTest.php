<?php

namespace Tests\Feature;

use App\Models\ShareLink;
use App\Models\Snippet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ShareLinkTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'password' => Hash::make('password123'),
            'is_verified' => 1,
        ], $attributes));
    }

    private function createSnippet(User $user, array $attributes = []): Snippet
    {
        return Snippet::create(array_merge([
            'user_id' => $user->id,
            'title' => 'Test Snippet',
            'description' => 'Test description',
            'language' => 'php',
        ], $attributes));
    }

    private function createLink(Snippet $snippet, array $attributes = []): ShareLink
    {
        return ShareLink::create(array_merge([
            'snippet_id' => $snippet->id,
            'token_hash' => hash('sha256', 'known-token-abc123'),
            'password' => null,
            'expires_at' => null,
        ], $attributes));
    }

    private function token(): string
    {
        return 'known-token-abc123';
    }

    public function test_owner_can_create_share_link()
    {
        $owner = $this->createUser();
        $snippet = $this->createSnippet($owner);

        $response = $this->actingAs($owner)->postJson('/snippets/'.$snippet->id.'/share-links', [
            'expires_in_days' => 7,
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['id', 'url']);

        $this->assertDatabaseHas('share_links', ['snippet_id' => $snippet->id]);
    }

    public function test_non_owner_cannot_create_share_link()
    {
        $owner = $this->createUser();
        $other = $this->createUser();
        $snippet = $this->createSnippet($owner);

        $this->actingAs($other)
            ->postJson('/snippets/'.$snippet->id.'/share-links')
            ->assertForbidden();
    }

    public function test_guest_can_view_public_share_link()
    {
        $owner = $this->createUser();
        $snippet = $this->createSnippet($owner);
        $snippet->files()->create([
            'file_name' => 'example.php',
            'content' => '<?php echo "hello";',
            'extension' => 'php',
        ]);
        $this->createLink($snippet);

        $response = $this->get('/s/'.$this->token());

        $response->assertOk();
        $response->assertSee('Test Snippet');
        $response->assertSee('example.php');
    }

    public function test_password_protected_link_requires_password()
    {
        $owner = $this->createUser();
        $snippet = $this->createSnippet($owner);
        $this->createLink($snippet, ['password' => Hash::make('secret123')]);

        // First visit shows the password gate, not the snippet
        $this->get('/s/'.$this->token())
            ->assertOk()
            ->assertSee('Protected Snippet');

        // Wrong password -> error
        $this->post('/s/'.$this->token(), ['password' => 'wrongpass'])
            ->assertSessionHas('error');

        // Correct password -> redirected to the snippet
        $this->post('/s/'.$this->token(), ['password' => 'secret123'])
            ->assertRedirect('/s/'.$this->token());

        $this->get('/s/'.$this->token())
            ->assertOk()
            ->assertSee('Test Snippet');
    }

    public function test_expired_link_is_unavailable()
    {
        $owner = $this->createUser();
        $snippet = $this->createSnippet($owner);
        $this->createLink($snippet, ['expires_at' => now()->subDay()]);

        $this->get('/s/'.$this->token())
            ->assertNotFound()
            ->assertSee('no longer available');
    }

    public function test_revoked_link_is_unavailable()
    {
        $owner = $this->createUser();
        $snippet = $this->createSnippet($owner);
        $link = $this->createLink($snippet);
        $link->delete();

        $this->get('/s/'.$this->token())
            ->assertNotFound()
            ->assertSee('no longer available');
    }

    public function test_deleting_snippet_revokes_its_links()
    {
        $owner = $this->createUser();
        $snippet = $this->createSnippet($owner);
        $this->createLink($snippet);

        $snippet->delete();

        $this->assertDatabaseMissing('share_links', ['snippet_id' => $snippet->id]);
        $this->get('/s/'.$this->token())->assertNotFound();
    }

    public function test_snippet_api_requires_ownership()
    {
        $owner = $this->createUser();
        $other = $this->createUser();
        $snippet = $this->createSnippet($owner);

        // Owner can read it
        $this->actingAs($owner)->getJson('/api/snippets/'.$snippet->id)->assertOk();

        // Other authenticated users cannot (IDOR regression)
        $this->actingAs($other)->getJson('/api/snippets/'.$snippet->id)->assertNotFound();

        // Guests cannot either (separate method so no actingAs state leaks)
    }

    public function test_guest_cannot_view_snippet_api()
    {
        $owner = $this->createUser();
        $snippet = $this->createSnippet($owner);

        $this->getJson('/api/snippets/'.$snippet->id)->assertUnauthorized();
    }
}
