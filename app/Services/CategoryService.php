<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Создание категории в таблице
     */
    public function store(array $data): Category
    {

        return Category::create($data);
    }

    /**
     * Поиск категории по ID, его обновление и вывод на экран + обработка ошибок
     */
    public function update(int $id, array $data)
    {
        $category = Category::find($id);
        if (!$category) {

            return null;
        }
        $category->update($data);

        return $category;
    }

    /**
     * Поиск категории по ID, его удаление и вывод на экран сообщения об успехе или неудаче
     */
    public function destroy(int $id): bool
    {
        $category = Category::find($id);
        if (!$category) {

            return false;
        }
        $category->delete();

        return true;
    }
}
