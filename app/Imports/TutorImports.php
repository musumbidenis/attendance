<?php

namespace App\Imports;

use App\Tutor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class TutorImports implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tutor([
            'tutorId'  => $row['tutor_id'],
            'firstname'   => $row['first_name'],
            'surname'   => $row['surname'],
            'email'    => $row['email'],
            'phone'  => $row['phone'],
            'courseCode'   => $row['course_code']
        ]);
    }
}
