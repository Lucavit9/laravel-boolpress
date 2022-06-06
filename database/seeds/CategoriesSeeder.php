<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Genres', 'Artists', 'Albums', 'Songs'];
        //Nelle categorie vado a mettere valori univoci
        foreach ($categories as $category) {
            $newCategory_obj = new Category;
            $newCategory_obj->name = $category;
            $newCategory_obj->slug = Str::slug($category);
            $newCategory_obj->save();
        }
    }
}
