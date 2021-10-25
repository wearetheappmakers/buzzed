<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $category  = Category::where('name', trim($row['category']))->whereNull('parent_id')->first();
        if(!$category) {
            $category = new Category();
            $category->name = trim($row['category']);            
        }
        $category->status=1;
        $category->deleted_at=NULL;
        $category->save();
        
        $sub_category  = Category::where('name', trim($row['sub_category1']))->where('parent_id', $category['id'])->first();
        if(!$sub_category) {
            $sub_category = new Category();
            $sub_category->name = trim($row['sub_category1']);
        }
        $sub_category->parent_id = $category['id'];
        $sub_category->status=1;
        $sub_category->deleted_at=NULL;
        $sub_category->save();

        $sub_category2  = Category::where('name', trim($row['sub_category2']))->where('parent_id', $sub_category['id'])->first();
        if(!$sub_category2) {
            $sub_category2 = new Category();
            $sub_category2->name = trim($row['sub_category2']);
        }
        $sub_category2->parent_id = $sub_category['id'];
        $sub_category2->status=1;
        $sub_category2->deleted_at=NULL;
        $sub_category2->save();

               // return $Category;
    }

    public function rules(): array
    {
        return [
            '*.category' => 'required',
            '*.sub_category1' => 'required',
            '*.sub_category2'=>'required',
        ];
    }
}