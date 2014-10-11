<?php namespace Suenos\Users;


use Maatwebsite\Excel\Files\NewExcelFile;

class UserExcelExport extends NewExcelFile {

    /**
     * Get file
     * @return string
     */
    public function getFilename()
    {
        return 'Users';
    }
}