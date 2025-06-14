@push('title')
    Products Create
@endpush

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .form-control,
        .form-select {
            border-radius: 0 !important;
        }
    </style>
@endpush
<div>
    <!-- Header -->
    <div wire:ignore>
        @livewire('layouts.header')
    </div>
    <hr>
    <!-- End Header -->

    <!--  Sidebar  -->
    @livewire('layouts.sidebar')
    <!-- End Sidebar-->
    <main id="main" class="main bg-light">
        <form wire:submit="update" enctype="multipart/form-data" class="container-fluid py-4">
            <h2 class="mb-4">Create Product</h2>
            <div class="row g-3">
                <!-- Product Name & Slug -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" placeholder="Product Name"
                            wire:model="name">
                        <label for="name">Product Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="slug" placeholder="Slug" wire:model="slug">
                        <label for="slug">Slug</label>
                    </div>
                </div>

                <!-- SKU, Sale, Original, Stock -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="sku" placeholder="SKU" wire:model="sku">
                        <label for="sku">SKU</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="sale_price" placeholder="Sale Price"
                            wire:model="sale_price">
                        <label for="sale_price">Sale Price</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="original_price" placeholder="Original Price"
                            wire:model="original_price">
                        <label for="original_price">Original Price</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="qty_in_stock" placeholder="Qty In Stock"
                            wire:model="qty_in_stock">
                        <label for="qty_in_stock">Qty In Stock</label>
                    </div>
                </div>

                <!-- Status & Stock -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="stock_status" wire:model="stock_status">
                            <option value="">Select Stock Status</option>
                            @foreach ($stockStatusOption as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <label for="stock_status">Stock Status</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="status" wire:model="status">
                            <option value="">Select Status</option>
                            @foreach ($statusOption as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>

                <!-- Relations -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="section" wire:model="selectedSection">
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                        <label for="section">Section</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="category" wire:model="selectedCategory">
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <label for="category">Category</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="sub_category" wire:model="sub_category_id">
                            <option value="">Select Sub Category</option>
                            @foreach ($subCategories as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                        <label for="sub_category">Sub Category</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="brand" wire:model="brand_id">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <label for="brand">Brand</label>
                    </div>
                </div>

                <!-- Description & Specification -->
                <div class="col-md-12" wire:ignore>
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div>

                <!-- Tags -->
                <div class="col-md-12" wire:ignore>
                    <label for="select-tag" class="form-label">Tags</label>
                    <select id="select-tag" class="form-select p-0" name="state[]" multiple
                        placeholder="Select Tags">
                        @foreach ($allTags as $tag)
                            <option @selected(str_contains($tags, $tag->keyword)) value="{{ $tag->keyword }}">{{ $tag->keyword }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedTags')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Attributes -->
                @foreach ($allAttributes as $attribute)
                    <div class="col-md-12" wire:ignore>
                        <label for="select-{{ $attribute->name }}" class="form-label">{{ $attribute->name }}</label>
                        <select id="select-{{ $attribute->name }}" class="form-select" name="state[]" multiple>
                            @foreach ($attribute->attributeOption as $option)
                                <option @selected(str_contains($productAttribute, $option->value)) value="{{ $option->value }}">
                                    {{ $option->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('selectedSize')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                @endforeach

                <!-- Main Image -->
                {{-- <div class="col-md-6">
                    <label for="image" class="form-label">Main Image</label>
                    <input type="file" class="form-control" id="image" wire:model="image">
                    @if ($oldImage)
                        <img src="{{ asset('storage/products/' . $oldImage) }}" class="img-thumbnail h-150 mt-2"
                            width="150">
                    @endif
                </div> --}}
                <div x-data x-ref="filepondWrapper" class="col-md-6">
                    <label for="image" class="form-label">Main Image</label>
                    <input type="file" id="mainImageInput" class="filepond" name="filepond" />

                    @if ($oldImage)
                        <img src="{{ asset('storage/products/' . $slug . '/' . $oldImage) }}"
                            class="img-thumbnail mt-2" width="150">
                    @endif

                    @push('script')
                        <script>
                            Livewire.hook('message.processed', () => {
                                const input = document.getElementById('mainImageInput');
                                if (input && window.FilePond && !input._pond) {
                                    FilePond.create(input, {
                                        acceptedFileTypes: ['image/png', 'image/jpeg'],
                                        server: {
                                            process: (fieldName, file, metadata, load, error, progress, abort) => {
                                                @this.upload('image', file, load, error, progress);
                                            },
                                            revert: (filename, load) => {
                                                @this.set('image', null);
                                                load();
                                            }
                                        }
                                    });
                                }
                            });
                        </script>
                    @endpush
                </div>


                <!-- Gallery -->
                <div class="col-md-6">
                    <label for="gallery" class="form-label">Gallery Images</label>
                    <input type="file" class="form-control" id="gallery" wire:model="gallery" multiple>
                    @if ($oldGallery)
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach (explode(' ', $oldGallery) as $img)
                                <img src="{{ asset('storage/products/' . $img) }}" class="img-thumbnail h-150"
                                    width="150">
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-md-12" wire:ignore>
                    <label for="editor" class="form-label">Specification</label>
                    <textarea name="edit" id="editor" class="form-control" rows="4"></textarea>
                </div>
                @error('specification')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <!-- Submit -->
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Save Product</button>
                </div>
            </div>
        </form>
    </main>
    <!-- End #main -->

    <!-- Footer -->
    @livewire('layouts.footer')
    <!-- End Footer -->
</div>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
    <script>
        new TomSelect("#select-tag", {
            plugins: ['remove_button'],
            create: true,
            onChange: function(value) {
                @this.set('selectedTags', value)
            }
        });

        for (const attribute in @js($allAttributes)) {
            new TomSelect(`#select-${@js($allAttributes)[attribute].name}`, {
                plugins: ['remove_button'],
                create: true,
                onChange: function(value) {
                    @this.set(`selectedProductAttribute.${@js($allAttributes)[attribute].id}`, value)
                }
            });
        }

        ClassicEditor
            .create(document.querySelector('#editor'), {

            })
            .then(newEditor => {
                let editor = newEditor;
                editor.setData(@js($this->specification));
                editor.model.document.on('change:data', () => {
                    @this.set('specification', editor.getData());
                });
            })

        ClassicEditor
            .create(document.querySelector('#description'), {

            })
            .then(newEditor => {
                let editor = newEditor;
                editor.setData(@js($this->description));
                editor.model.document.on('change:data', () => {
                    @this.set('description', editor.getData());
                });
            })
    </script>
@endpush
