<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;
use Faker\Factory as Faker;

class AdminController extends Controller
{
    /** Realistic-sounding task and subtask titles for seeded data */
    private array $taskTitles = [
        'Complete project documentation',
        'Review and merge pull requests',
        'Write unit and integration tests',
        'Refactor the authentication module',
        'Update project dependencies',
        'Investigate and fix reported bugs',
        'Design the new database schema',
        'Prepare presentation slides',
        'Set up CI/CD pipeline',
        'Conduct weekly code review',
        'Write API documentation',
        'Optimise slow database queries',
        'Deploy to staging environment',
        'Create UI wireframes',
        'Implement user profile page',
        'Fix login page layout on mobile',
        'Add CSV export feature',
        'Review security audit report',
        'Schedule team sync meeting',
        'Update README and onboarding guide',
        'Research competitor features',
        'Improve error handling',
        'Add pagination to task list',
        'Set up logging and monitoring',
        'Migrate data to new schema',
    ];

    private array $subtaskTitles = [
        'Draft initial outline',
        'Research existing solutions',
        'Write first draft',
        'Peer review',
        'Apply feedback',
        'Final check',
        'Create test cases',
        'Run linter',
        'Fix failing tests',
        'Update changelog',
        'Test on mobile',
        'Test on desktop',
        'Update screenshots',
        'Get sign-off',
        'Merge and close',
    ];

    // -------------------------------------------------------------------------

    public function index()
    {
        $stats = [
            'total_users'  => User::count(),
            'fake_users'   => User::where('is_fake', true)->count(),
            'admin_users'  => User::where('role', 'admin')->count(),
            'real_users'   => User::where('is_fake', false)->where('role', 'user')->count(),
            'total_tasks'  => Task::count(),
            'fake_tasks'   => Task::whereHas('user', fn($q) => $q->where('is_fake', true))->count(),
        ];

        $users = User::withCount('tasks')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.index', compact('stats', 'users'));
    }

    // -------------------------------------------------------------------------

    public function seed(Request $request)
    {
        $validated = $request->validate([
            'user_count'         => 'required|integer|min:1|max:20',
            'tasks_per_user'     => 'required|integer|min:1|max:10',
            'subtasks_per_task'  => 'required|integer|min:0|max:5',
            'percent_completed'  => 'required|integer|min:0|max:100',
        ]);

        $faker       = Faker::create();
        $userCount   = $validated['user_count'];
        $taskCount   = $validated['tasks_per_user'];
        $subtaskCount = $validated['subtasks_per_task'];
        $pctDone     = $validated['percent_completed'];

        for ($i = 0; $i < $userCount; $i++) {
            $user = User::create([
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role'     => 'user',
                'is_fake'  => true,
            ]);

            for ($j = 0; $j < $taskCount; $j++) {
                $parentDone  = rand(1, 100) <= $pctDone;
                $daysOffset  = rand(-3, 21);
                $hasDate     = (bool) rand(0, 1);
                $hasHours    = (bool) rand(0, 1);

                $parent = $user->tasks()->create([
                    'title'           => $faker->randomElement($this->taskTitles),
                    'description'     => rand(0, 1) ? $faker->sentences(2, true) : null,
                    'due_date'        => $hasDate ? now()->addDays($daysOffset)->format('Y-m-d') : null,
                    'due_time'        => ($hasDate && rand(0, 1)) ? sprintf('%02d:%02d', rand(8, 18), rand(0, 1) * 30) : null,
                    'estimated_hours' => $hasHours ? round(rand(4, 32) / 4, 2) : null,   // 1–8 h in 0.25 steps
                    'is_completed'    => $subtaskCount === 0 ? $parentDone : false,       // let subtasks drive completion
                ]);

                for ($k = 0; $k < $subtaskCount; $k++) {
                    $subDone = rand(1, 100) <= $pctDone;
                    $user->tasks()->create([
                        'title'           => $faker->randomElement($this->subtaskTitles),
                        'description'     => null,
                        'due_date'        => $parent->due_date
                            ? $parent->due_date->format('Y-m-d')
                            : (rand(0, 1) ? now()->addDays(rand(-2, 14))->format('Y-m-d') : null),
                        'estimated_hours' => rand(0, 1) ? round(rand(2, 12) / 4, 2) : null,  // 0.5–3 h
                        'is_completed'    => $subDone,
                        'parent_id'       => $parent->id,
                    ]);
                }

                // Auto-complete parent if all subtasks are done
                if ($subtaskCount > 0) {
                    $allDone = $parent->subtasks()->where('is_completed', false)->count() === 0;
                    $parent->update(['is_completed' => $allDone]);
                }
            }
        }

        return redirect()->route('admin.index')
            ->with('success', "Created {$userCount} fake user(s) with up to {$taskCount} task(s) each.");
    }

    // -------------------------------------------------------------------------

    public function clearFake()
    {
        $fakeUsers = User::where('is_fake', true)->get();
        $count     = $fakeUsers->count();

        foreach ($fakeUsers as $user) {
            // Delete tasks (parent cascade removes subtasks via FK)
            Task::where('user_id', $user->id)->whereNull('parent_id')->delete();
            $user->delete();
        }

        return redirect()->route('admin.index')
            ->with('success', "Removed {$count} fake user(s) and all their tasks.");
    }

    // -------------------------------------------------------------------------

    public function toggleRole(User $user)
    {
        // Prevent demoting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.index')
                ->with('error', 'You cannot change your own role.');
        }

        $user->update(['role' => $user->role === 'admin' ? 'user' : 'admin']);

        return redirect()->route('admin.index')
            ->with('success', "Role updated for {$user->email}.");
    }
}
