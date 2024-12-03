<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $departments = $this->MakeDepartments(5, []);
        $sections = $this->MakeSections(5, []);

        $user = $this->MakeUsers(1, [
            'department_id' => $departments->random()->id,
            'section_id' => $sections->random()->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'user@app.com',
        ])->first();


        $managementDepartment = $this->MakeDepartments(1, [
            'name' => 'Management',
        ])->first();

        $adminSection = $this->MakeSections(1, [
            'name' => 'Admin',
        ])->first();

        $managerSection = $this->MakeSections(1, [
            'name' => 'Manager',
        ])->first();

        $managementDepartment->sections()->sync($adminSection, $managerSection);

        $admin = $this->MakeUsers(1, [
            'department_id' => $managementDepartment->id,
            'section_id' => $adminSection->id,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'admin@app.com',
        ])->first();

        $manager = $this->MakeUsers(1, [
            'department_id' => $managementDepartment->id,
            'section_id' => $managerSection->id,
            'first_name' => 'Jack',
            'last_name' => 'Doe',
            'email' => 'manager@app.com',
        ])->first();

        $users = $this->MakeUsers(5, [
            'department_id' => $departments->random()->id,
            'section_id' => $sections->random()->id,
        ]);

        $allUsers = array_merge([$user, $admin, $manager]);

        foreach ($allUsers as $user) {
            $this->AddNotifications($user);
        }

        foreach ($users as $user) {
            $this->AddRole($user);
        }

        $this->AddCustomRole($admin, 'Admin');

        $this->AddCustomRole($manager, 'Manager');

        $projects = $this->MakeProjects();

        foreach ($allUsers as $user) {
            $this->AddProject($user, $projects->random());
        }

        $leaveTypes = $this->MakeLeaveTypes(5, '');

        foreach ($users as $user) {
            $this->MakeLeaves(5, $user, $manager, $leaveTypes->random());
        }
    }

    private function AddNotifications(User $user): void
    {
        $user->notifications()->create([
            'message' => 'Welcome to the app, we hope you enjoy your stay',
            'type' => 'low',
        ]);
    }

    private function MakePermissions()
    {
        return Permission::factory(5)->create();
    }

    private function AddRole(User $user): void
    {
        $role = null;
        if (Role::where('name', 'User')->exists()) {
            $role = Role::where('name', 'User')->first();
        } else {
            $role = Role::create([
                'name' => 'User',
            ]);
            $permissions = $this->MakePermissions();
            $role->permissions()->sync($permissions);
        }

        $user->roles()->attach($role);
    }

    private function AddCustomRole(User $user, $name): void
    {

        $role = $user->roles()->create([
            'name' => $name,
        ]);

        $permissions = $this->MakePermissions();

        $role->permissions()->sync($permissions);
    }

    private function AddProject(User $user, Project $project): void
    {
        $user->projects()->attach($project);
    }

    private function MakeProjects()
    {
        return Project::factory(5)->create();
    }

    private function MakeSections(int $count, $customSectionsInfo)
    {
        return Section::factory($count)->create($customSectionsInfo);
    }

    private function MakeDepartments(int $count, $customDepartmentInfo)
    {
        return Department::factory($count)->create($customDepartmentInfo);
    }

    private function MakeUsers(int $count, $customUserInfo)
    {
        return User::factory($count)->create($customUserInfo);
    }

    private function MakeLeaves(int $count, User $user, User $manager, LeaveType $leaveType)
    {
        return Leave::factory($count)->create([
            'user_id' => $user->id,
            'manager_id' => $manager->id,
            'leave_type_id' => $leaveType->id,
        ]);
    }

    private function MakeLeaveTypes(int $count, string $name)
    {
        return LeaveType::factory($count)->create($name == '' ? [] : ['name' => $name]);
    }
}
