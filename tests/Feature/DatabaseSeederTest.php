<?php

namespace Tests\Feature;

use App\Models\About;
use App\Models\Formation;
use App\Models\Link;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_le_seed_recharge_le_contenu_du_cv(): void
    {
        Storage::fake('public');

        $this->seed();

        $this->assertSame(1, About::count());
        $this->assertSame(25, Skill::count());
        $this->assertSame(10, Project::count());
        $this->assertSame(5, Formation::count());
        $this->assertSame(6, Link::count());
        $this->assertSame(1, User::count());
    }

    public function test_le_seed_preserve_les_identifiants_et_les_relations(): void
    {
        Storage::fake('public');

        $this->seed();

        // Les identifiants de production ne sont pas contigus : les preserver est
        // ce qui garde les liens project_skill valides.
        $this->assertSame(24, Skill::min('id'));
        $this->assertSame(59, Skill::max('id'));
        $this->assertSame(135, DB::table('project_skill')->count());

        $project = Project::with('skills')->findOrFail(11);
        $this->assertSame('D&D Personal Character Sheet', $project->title);
        $this->assertCount(15, $project->skills);
        $this->assertTrue($project->skills->contains('title', 'Laravel'));
    }

    public function test_le_seed_conserve_les_dates_d_origine(): void
    {
        Storage::fake('public');

        $this->seed();

        $this->assertSame(
            '2024-02-21 12:29:34',
            About::firstOrFail()->created_at->format('Y-m-d H:i:s')
        );
    }

    public function test_chaque_image_referencee_existe_sur_le_disque_public(): void
    {
        Storage::fake('public');

        $this->seed();

        $references = collect()
            ->merge(Skill::pluck('img'))
            ->merge(Link::pluck('img'))
            ->push(About::firstOrFail()->img)
            ->merge(Project::pluck('logo'))
            ->merge(Project::pluck('illustration_1'))
            ->merge(Project::pluck('illustration_2'))
            ->merge(Project::pluck('illustration_3'))
            ->merge(Project::pluck('illustration_4'))
            ->filter(fn (?string $path) => is_string($path) && str_starts_with($path, '/storage/'))
            ->unique();

        $this->assertGreaterThan(60, $references->count());

        foreach ($references as $reference) {
            $relative = str_replace('/storage/', '', $reference);

            $this->assertTrue(
                Storage::disk('public')->exists($relative),
                "Image referencee en base mais absente du disque public : {$reference}"
            );
        }
    }

    public function test_la_page_d_accueil_affiche_les_donnees_seedees(): void
    {
        Storage::fake('public');

        $this->seed();

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Front/Welcome')
                ->has('skills', 25)
                ->has('projects', 10)
                ->has('formations', 5)
                ->has('links', 6)
                ->where('about.title', 'Vincent Vuillemin')
            );
    }
}
