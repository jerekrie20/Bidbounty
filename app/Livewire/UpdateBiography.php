<?php

namespace App\Livewire;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateBiography extends Component
{
    use WithFileUploads;

    public $bio;
    public $currentAvatar; // This will hold the filename of the current avatar
    public $image; // This will be used for the uploaded image
    public $defaultAvatars = ['cow.png', 'pig.png', 'sheep.png', 'tools.png'];

    public function rules()
    {
        return [
            'bio' => 'required|string|max:255',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ];
    }

    public function mount()
    {
        // Initialize properties, for example:
        $this->currentAvatar = auth()->user()->image;
        $this->bio = auth()->user()->bio;
    }

    public function setDefaultAvatar($avatarFilename)
    {
        $this->currentAvatar = $avatarFilename;
        $this->reset('image'); // This will clear the uploaded image
    }

    public function updatedImage()
    {
        $this->currentAvatar = null; // Clear the default avatar when an image is uploaded
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();

        //If image is set, change the size to 300x300 and change the name to the users name plus random number

        // Check if an image was uploaded
        if ($this->image) {
            // Instantiate the image manager
            $manager = new ImageManager(new Driver());

            // Read the uploaded image file
            $img = $manager->read($this->image->getRealPath());

            // Resize the image to 300x300
            $img->scale(width: 300);

            // Generate a new filename
            $filename = 'avatar_' . rand(1000, 9999) . '.' . $this->image->getClientOriginalExtension();

            // Delete the old image if it exists

            //Check if the file exists
            if (file_exists(storage_path('app/avatars/' . $user->image))) {
                //Delete the file
                unlink(storage_path('app/avatars/' . $user->image));
            }

            // Save the image to the 'avatars' directory
            $img->save(storage_path('app/avatars/' . $filename));

            // Update the user's image attribute with the new filename
            $user->image = $filename;
        } else {
            // If no new image was uploaded, retain the current avatar
            $user->image = $this->currentAvatar;
        }

        // Update user data
        $user->bio = $this->bio;
        $user->save();

        session()->flash('success', 'Updated successfully!');

    }

    public function render()
    {
        return view('livewire.update-biography');
    }
}
