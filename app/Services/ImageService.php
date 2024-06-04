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
            // Resize the image to 400x300
            $img->cover(400,300,'center');
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

            //Check if the current image is not empty
            if (!empty($current)) {
                //Check if the file exists
                if (file_exists(storage_path('app/'.$folder.'/' . $current))) {
                    //Delete the file

                    unlink(storage_path('app/'.$folder.'/' . $current));
                }
            }

            // Save the image to the main folder/year/month/day directory

            $img->save(storage_path('app/'.$folder.'/'. $filename));

            // Return the new filename

            return $filename;
        }

        return null;
    }

    public function saveBulkImages($images,$folder,$subfolder,$currentImages)
    {
        $filenames = [];
        if (!empty($images)) {
            foreach ($images as $image) {
                // Read the uploaded image file
                $img = $this->imageManager->read($image->getRealPath());
                // Resize the image to 300x300
                $img->cover(400,300,'center');
                // Generate a new filename
                $filename = 'item_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();

                // Check if the folder exists and create it if it doesn't
                if (!file_exists(storage_path('app/' . $folder))) {
                    mkdir(storage_path('app/' . $folder), 0777, true);
                }
                //Check if subfolder exists, if not create it
                if (!file_exists(storage_path('app/' . $folder . '/' . $subfolder))) {
                    mkdir(storage_path('app/' . $folder . '/' . $subfolder), 0777, true);
                }

                // Check if currentImages is not empty
                if (!empty($currentImages)) {
                    // Check if the file exists
                    if (file_exists(storage_path('app/' . $folder . '/' . $subfolder . '/' . $currentImages))) {
                        // Delete the file
                        unlink(storage_path('app/' . $folder . '/' . $subfolder . '/' . $currentImages));
                    }
                }

                //Update the filename with the subfolder
                $filename = $subfolder . '/' . $filename;

                // Save the image to the main folder/subfolder directory
                $img->save(storage_path('app/' . $folder . '/' . $filename));

                // Add the filename to the array
                $filenames[] = $filename;
            }
            // Return the array of filenames
            return $filenames;
        }
        return null;
    }

    public function deleteImage($image,$folder)
    {
        //Check if the file exists
        if (file_exists(storage_path('app/'.$folder.'/' . $image))) {
            //Delete the file
            unlink(storage_path('app/'.$folder.'/' . $image));
        }
    }

    public function deleteBulkImages($images,$folder)
    {
       //Decode the images
        $images = json_decode($images);
        //flatten the array
        if($this->isArrayOfArrays($images)) {
            $images = array_reduce($images, 'array_merge', array());
        }

        if (!empty($images)) {
            //Loop through the images and delete the images, delete the subfolder at the end
            //Get the subfolder
            $subfolder = explode('/',$images[0])[0];

            foreach ($images as $image) {
                //Check if the file exists
                if (file_exists(storage_path('app/' . $folder . '/' . $image))) {
                    //Delete the file
                    unlink(storage_path('app/' . $folder . '/' . $image));
                }
            }

            //Check if the subfolder exists
            if (file_exists(storage_path('app/' . $folder . '/' . $subfolder))) {
                //Delete the subfolder
                rmdir(storage_path('app/' . $folder . '/' . $subfolder));
            }
        }
    }

    function isArrayOfArrays(array $array): bool
    {
        foreach ($array as $element) {
            if (!is_array($element)) {
                return false;
            }
        }

        return true;
    }

}
