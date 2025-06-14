<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Http\Traits\FileTrait;
use App\Http\Traits\TableColumnTrait;
use Illuminate\Http\RedirectResponse;
use App\Http\Traits\BooleanTableTrait;
use Livewire\Features\SupportRedirects\Redirector;

class ProductsController extends Component
{
    use WithPagination, BooleanTableTrait, FileTrait;

    public string $search = '';
    public string $showDataPerPage = '10';

    public function mount(): void
    {
        // $this->tableColumnTrait(
        //     ['Image', 'Name', 'SKU', 'Qty', 'Sub Category', 'Sale', 'Original', 'Stock', 'Status', 'Action'],
        //     ['image', 'name', 'sku', 'qty_in_stock', 'sub_category_id', 'sale_price', 'original_price', 'stock_status', 'status']
        // );

        // $this->booleanTrait(
        //     ['stock_status', 'status'],
        //     [['Out Of Stock', 'InStock'], ['Unpublish', 'Publish']],
        //     [
        //         ['badge text-bg-danger', 'badge text-bg-success'],
        //         ['badge text-bg-warning', 'badge text-bg-primary'],
        //     ]
        // );
    }

    public function updatingSearch(): void
    {
        $this->resetPage(); // ensures pagination resets on search
    }

    public function update(int $productId): Redirector
    {
        return redirect(route('products.update', $productId));
    }

    public function destroy(int $id): void
    {
        $product = Product::findOrFail($id);

        $images = explode(' ', $product->all_images ?? '');
        $images[] = $product->image;

        $this->fileDestroy($images, 'products');

        $product->delete();

        $this->dispatch('success-toast', ['message' => 'Deleted product!']);
    }

    public function render(): View
    {
        $products = Product::query()
            ->when(
                $this->search,
                fn($query) =>
                $query->where('name', 'like', '%' . $this->search . '%')
            )
            ->paginate($this->showDataPerPage, ['id', 'image', 'name', 'sku', 'qty_in_stock', 'sub_category_id', 'sale_price', 'original_price', 'stock_status', 'status', 'created_at']);

        return view('livewire.products.products', compact('products'));
    }
}
