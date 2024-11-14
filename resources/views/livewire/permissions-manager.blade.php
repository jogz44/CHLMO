<div>
    <h1>Permissions Manager</h1>

    <div>
        <label for="role">Select Role:</label>
        <select wire:model="roleId">
            <option value="">Select a role</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <h2>Permissions</h2>
        @foreach($permissions as $permission)
            <div>
                <label>
                    <input type="checkbox" wire:model="permissions" value="{{ $permissions }}">
                    {{ $permission }}
                </label>
            </div>
        @endforeach
    </div>

    <button wire:model="assignPermissions">Save Permissions</button>
</div>
/**
This view displays a dropdown to select a role, a list of all permissions with checkboxes, and a button to save the selected permissions for the chosen role.
*/
