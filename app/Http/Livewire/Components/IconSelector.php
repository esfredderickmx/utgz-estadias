<?php

namespace App\Http\Livewire\Components;

use App\Models\Icon;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class IconSelector extends Component {

  use WithPagination;

  private $categories;
  private $icons;
  public $selection;
  public $icon_search;
  public $category_search;
  public $iconsPage;
  public $entity_type;
  public $entity_id;

  protected $paginationTheme = 'simple-fomantic';

  protected function rules() {
    return [
      'selection' => 'required|string|exists:icons,name'
    ];
  }

  public function render() {
    if ($this->icons && $this->icons->count() === 0) {
      $this->resetPage('iconsPage');
    }

    $query = Icon::query();

    if ($this->icon_search) {
      $query->where('name', 'like', "%$this->icon_search%");
    }

    if ($this->category_search) {
      $query->whereHas('categories', function ($categoryQuery) {
        $categoryQuery->where('value', 'like', "%$this->category_search%");
      });
    }

    $query->orderBy('name');

    $this->categories = Category::query()->orderBy('name')->get();
    $this->icons = $query->paginate(102, ['*'], 'iconsPage');

    if ($this->icons->currentPage() > $this->icons->lastPage()) {
      $this->resetPage('iconsPage');
      $this->render();
    }

    return view('livewire.components.icon-selector', ['categories' => $this->categories, 'icons' => $this->icons /* 'data' => $json_data */]);
  }

  public function updated($propertyName) {
    $this->validateOnly($propertyName);
  }

  public function updatedCategorySearch() {
    $this->resetPage('iconsPage');
  }

  public function selectIcon() {
    $this->validate();

    $this->emitUp('icon-selection', $this->selection);
    $this->emit('selected-icon', $this->entity_type, $this->entity_id ?? null);

    return $this->resetForm();
  }

  public function handleSearch() {
    $this->resetPage('iconsPage');
  }

  public function clearSearch() {
    $this->reset('icon_search');
  }

  public function resetForm() {
    $this->resetPage('iconsPage');
    $this->reset('icon_search', 'category_search', 'selection');
    $this->resetErrorBag();
  }
}
