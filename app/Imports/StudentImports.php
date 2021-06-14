<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StudentImports implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'studentId'  => $row['student_id'],
            'firstname'   => $row['first_name'],
            'surname'   => $row['surname'],
            'email'    => $row['email'],
            'phone'  => $row['phone'],
            'courseCode'   => $row['course_code']
        ]);
    }
}
