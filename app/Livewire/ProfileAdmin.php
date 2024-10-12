<?php
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileAdmin extends Component
{
    public $username, $first_name, $middle_name, $last_name, $email, $password, $user;
    public $isEditing = false;

    public function mount()
    {
        $this->user = Auth::user();
        if ($this->user) {
            $this->username = $this->user->username;
            $this->first_name = $this->user->first_name;
            $this->middle_name = $this->user->middle_name;
            $this->last_name = $this->user->last_name;
            $this->email = $this->user->email;
            $this->password = "";
        }
    }

    public function toggleEditMode()
    {
        $this->isEditing = !$this->isEditing;
    }

    public function save()
    {
        $user = User::find(Auth::id()); 
        $user->username = $this->username;
        $user->first_name = $this->first_name;
        $user->middle_name = $this->middle_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = bcrypt($this->password);
        }

        $user->save();
        $this->isEditing = false;
        session()->flash('message', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile-admin');
    }
}
