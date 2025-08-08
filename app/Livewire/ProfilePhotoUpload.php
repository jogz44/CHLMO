<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Logs\ActivityLogs;

class ProfilePhotoUpload extends Component
{
    use WithFileUploads;

    public $photo;
    public $user;

    public function mount()
    {
        // Fetch authenticated user
        $this->user = Auth::user();
    }

    // Handle the photo upload and validation when the file input changes
    public function updatedPhoto()
    {

        // Validate that the uploaded file is an image and is less than 1MB
        $this->validate([
            'photo' => 'image|max:20048', // Max size of 1MB
        ]);
    }

    // Save the uploaded photo and update the user's profile
    public function save()
    {
        // Check if a valid photo is uploaded
        if (!$this->photo || is_array($this->photo)) {
            session()->flash('error', 'No valid photo uploaded.');
            return;
        }

        // Store the uploaded file in the 'profile_photos' directory in the 'public' disk
        $path = $this->photo->store('profile_photos', 'public');

        // Get the authenticated user
        $user = Auth::user();

        // Update the user's profile photo path
        if ($user instanceof \App\Models\User) {
            $user->profile_photo_path = $path;
            $user->save();

            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Updated Profile Photo', $user);

            // Provide a success message after updating the profile photo
            $this->dispatch('profile-updated');
        } else {
            session()->flash('error', 'User is not an instance of User model.');
        }
    }

    // Render the Livewire component
    public function render()
    {
        return view('livewire.profile-photo-upload');
    }
}
