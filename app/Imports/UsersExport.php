<?php

namespace App\Imports;
  
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
  
class UsersExport implements FromCollection, WithHeadings
{
   
    public function collection()
    {
    	$users = User::select('fname','lname','email','b_date','number','favourite','image','amount','payment_type','validity_duration')->get();

    	if (!empty($users)) {
    		foreach ($users as $key => $value) {
    			$value->image = env('APP_URL').'/storage/uploads/users/Big/'.$value->image;
    		}
    	}
        return $users;
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Birthdate',
            'Number',
            'Favourite',
            'Image',
            'Membership Amount',
            'Payment Type',
            'Validity Duration(In Months)',
        ];
    }
}