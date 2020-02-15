<?php


namespace App\Http\Repositories;

use App\Models\Category;

class CategoryOrderRepository
{
    public $category;

    public $current_category;
    public $max_category;
    public $min_category;
    public $next_category;

    public function __construct($id)
    {
        $this->category = new Category();
        $this->current_category = $this->category->find($id);
        $this->max_category = $this->category->orderBy('order', 'desc')->first();
        $this->min_category = $this->category->orderBy('order', 'asc')->first();
    }

    public function increment()
    {
        // check if current category exists
        if (!$this->current_category) {
            return false;
        }
        // check if the current category is not the max in order
        if ($this->current_category->order <= $this->min_category->order) {
            return false;
        }
        // get the next element in line
        $this->next_category = $this->category->where('order', '<', $this->current_category->order)->orderBy('order', 'desc')->first();
        if (!$this->next_category) {
            return false;
        }

        $current_order = $this->current_category->order;
        // then swap orders
        $this->current_category->update(['order' => $this->next_category->order]);
        $this->next_category->update(['order' => $current_order]);

        return true;
    }

    public function decrement()
    {

        // check if current category exists
        if (!$this->current_category) {
            return false;
        }
        // check if the current category is not the max in order
        if ($this->current_category->order >= $this->max_category->order) {
            return false;
        }

        // get the next element in line
        $this->next_category = $this->category->where('order', '>', $this->current_category->order)->orderBy('order', 'asc')->first();

        if (!$this->next_category) {
            return false;
        }

        $current_order = $this->current_category->order;
        // then swap orders
        $this->current_category->update(['order' => $this->next_category->order]);
        $this->next_category->update(['order' => $current_order]);

        return true;
    }
}
