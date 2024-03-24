<?php

namespace App\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class ImageService
{

    protected $imageManager;

    public function __construct() {
        $this->imageManager = new Image(new Driver());
    }

    public function saveImage($image, $current,$folder) {
        if ($image) {
            // Read the uploaded image file
            $img = $this->imageManager->read($image->getRealPath());
            // Resize the image to 300x300
            $img->scale(width: 300);
            // Generate a new filename
            $filename = 'lot_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();


            // Check if the folder exists and create it if it doesn't
            if (!file_exists(storage_path('app/'.$folder))) {
                mkdir(storage_path('app/'.$folder), 0777, true);
            }
            //Check if there's a current year subfolder, if not create it
            if (!file_exists(storage_path('app/'.$folder.'/'.date('Y')))) {
                mkdir(storage_path('app/'.$folder.'/'.date('Y')), 0777, true);
            }

            // Check if there's a current month subfolder, if not create it
            if (!file_exists(storage_path('app/'.$folder.'/'.date('Y').'/'.date('m')))) {
                mkdir(storage_path('app/'.$folder.'/'.date('Y').'/'.date('m')), 0777, true);
            }

            // Check if there's a current day subfolder, if not create it
            if (!file_exists(storage_path('app/'.$folder.'/'.date('Y').'/'.date('m').'/'.date('d')))) {
                mkdir(storage_path('app/'.$folder.'/'.date('Y').'/'.date('m').'/'.date('d')), 0777, true);
            }

            // Check if filename exists in the current day folder
            while (file_exists(storage_path('app/'.$folder.'/'.date('Y').'/'.date('m').'/'.date('d').'/' . $filename)) == true) {
                $filename = 'lot_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            }

            // add current year/month/day to the filename
            $filename = date('Y').'/'.date('m').'/'.date('d').'/'.$filename;

            // Delete the old image if it exists

            //Check if the user has an image
            if (file_exists(storage_path('app/'.$folder.'/' . $current))) {
                //Delete the file

                unlink(storage_path('app/'.$folder.'/' . $current));
            }
            // Save the image to the main folder/year/month/day directory

            $img->save(storage_path('app/'.$folder.'/'. $filename));

            // Return the new filename

            return $filename;
        }

        return null;
    }

}
