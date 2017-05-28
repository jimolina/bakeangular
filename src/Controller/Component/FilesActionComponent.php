<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Filesystem\File;

class FilesActionComponent extends Component
{
	/**
	 * Set an error if the $file don't exist 
	 * @param  [string] $file
	 * @param  [string] $route default value is set to look the Uploads/img folder
	 * @return [bool]
	 */
    public function setFileError($file, $route = "upload/img/") 
    {
        $fileError = ($this->verifyFileExist($file, $route)) ? false : true;
        return $fileError;
    }

    /**
     * Verify if a $file Exist in a specify $route
     * @param  [string] $file
     * @param  [string] $route default value is set to look the Uploads/img folder
     * @return [bool]
     */
    public function verifyFileExist($file, $route = "upload/img/") 
    {
        if ($file) {
            $file = new File(WWW_ROOT . $route . $file);
            $fileExist = ($file->exists()) ? true : false;
            $file->close();
        } else {
            $fileExist = false;
        }

        return $fileExist;
    }

    /**
     * Delete a $file (if exist) in a specify $route
     * @param  [string] $file
     * @param  [string] $route default value is set to look the Uploads/img folder
     * @return [bool]
     */
    public function deleteFile($file, $route = "upload/img/")
    {
        $fileExist = $this->verifyFileExist($file, $route);

    	if ($fileExist) {
            $file = new File(WWW_ROOT . $route . $file);
            $file->delete();
            $file->close();

            return true;
        } else {
            return false;
        }
    }
}