<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

public function users(): LengthAwarePaginator
{
    return User::query()
        ->withAggregate('country', 'name')
        ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
        ->orderBy(...array_values($this->sortBy))
        ->paginate(5); // No more `->get()`
}

new class extends Component
{
    use WithPagination;
}

public function users(): Collection
{
    return User::query()
        ->with(['country'])
        ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
        ->orderBy(...array_values($this->sortBy))
        ->get();
}
