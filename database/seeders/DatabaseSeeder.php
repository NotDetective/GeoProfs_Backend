<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Permission;
use App\Models\Project;
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
            'name' => 'John Doe',
            'email' => 'user@app.com',
        ]);


        $managementDepartment = $this->MakeDepartments(1, [
            'name' => 'Management',
        ]);

        $adminSection = $this->MakeSections(1, [
            'name' => 'Admin',
        ]);

        $managerSection = $this->MakeSections(1, [
            'name' => 'Manager',
        ]);

        $managementDepartment->sections()->attach($adminSection);
        $managementDepartment->sections()->attach($managerSection);

        $admin = $this->MakeUsers(1, [
            'department_id' => $managementDepartment->id,
            'section_id' => $adminSection->id,
            'name' => 'Admin Doe',
            'email' => 'admin@app.com'
        ]);

        $manager = $this->MakeUsers(1, [
            'department_id' => $managementDepartment->id,
            'section_id' => $managerSection->id,
            'name' => 'Manager Doe',
            'email' => 'manager@app.com',
        ]);

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
            'title' => 'Welcome to the app',
            'message' => 'Welcome to the app, we hope you enjoy your stay',
            'priority' => 'low',
        ]);
    }

    private function MakePermissions() : Permission
    {
        return Permission::factory(5)->create();
    }

    private function AddRole(User $user): void
    {
        $this->AddCustomRole($user, 'User');
    }

    private function AddCustomRole(User $user, $name): void
    {
        $user->roles()->create([
            'name' => $name,
        ]);

        $permissions = $this->MakePermissions();

        foreach ($permissions as $permission) {
            $user->permissions()->attach($permission);
        }
    }

    private function AddProject(User $user, Project $project): void
    {
        $user->projects()->attach($project);
    }

    private function MakeProjects(): Project
    {
        return Project::factory(5)->create();
    }

    private function MakeSections(int $count , $customSectionsInfo): Section
    {
        return Section::factory($count)->create($customSectionsInfo);
    }

    private function MakeDepartments(int $count, $customDepartmentInfo): Department
    {
        return Department::factory($count)->create($customDepartmentInfo);
    }

    private function MakeUsers(int $count, $customUserInfo): User
    {
        return User::factory($count)->create($customUserInfo);
    }

    private function MakeLeaves(int $count, User $user, User $manager, LeaveType $leaveType): Leave
    {
        return Leave::factory($count)->create([
            'user_id' => $user->id,
            'manager_id' => $manager->id,
            'leave_type_id' => $leaveType->id,
        ]);
    }

    private function MakeLeaveTypes(int $count, string $name): LeaveType
    {
        return LeaveType::factory($count)->create( $name == '' ? [] : ['name' => $name]);
    }
}
