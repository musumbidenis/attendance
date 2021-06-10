<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'studentId'  => $row[0],
            'firstname'   => $row[1],
            'surname'   => $row[2],
            'email'    => $row[3],
            'phone'  => $row[4],
            'courseCode'   => $row[5]
        ]);
    }
}
