@extends('layouts.app')

@section('title', isset($item) ? 'Редагувати предмет' : 'Додати предмет')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 shadow shadow-gray-600/60 rounded-[2rem] border border-gray-100">
        <h2 class="text-2xl font-black mb-6 text-gray-800">
            {{ isset($item) ? 'Редагувати предмет' : 'Додати предмет до колекції' }}
        </h2>

        @if(isset($item) && $item->images->count() > 0)
            <div class="grid grid-cols-4 gap-4 mb-6">
                @foreach($item->images as $image)
                    <div class="relative aspect-square rounded-xl overflow-hidden border border-gray-100 group shadow-sm">
                        <img src="{{ $image->url }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <button type="submit" form="delete-photo-{{ $image->id }}" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <form id="delete-photo-{{ $image->id }}" action="{{ route('items.photo.destroy', $image->id) }}" method="POST" class="hidden" onsubmit="return confirm('Видалити фото?')">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </div>
        @endif

        <form action="{{ isset($item) ? route('items.update', $item->id) : route('items.store', $collection->id) }}"
            method="POST" enctype="multipart/form-data" id="main-form">
            @csrf
            @if(isset($item))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-black text-gray-600 uppercase tracking-wider">Назва предмета</label>
                    <input type="text" name="name" class="input-main w-full" placeholder="Наприклад: Копійка 1800 року"
                        value="{{ old('name', $item->name ?? '') }}" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black text-gray-600 uppercase tracking-wider">Стан</label>
                    <select name="condition" class="input-main w-full appearance-none bg-no-repeat bg-right"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%23718096%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3E%3Cpolyline points=%276 9 12 15 18 9%27%3E%3C/polyline%3E%3C/svg%3E'); background-position: right 0.75rem center; background-size: 1.2em;">
                        @foreach([1 => 'Ідеальний', 2 => 'Гарний', 3 => 'Середній', 4 => 'Поганий'] as $val => $label)
                            <option value="{{ $val }}" {{ old('condition', $item->condition ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 space-y-2">
                <label class="text-sm font-black text-gray-600 uppercase tracking-wider">Опис та деталі</label>
                <textarea name="description" rows="4" class="input-main w-full resize-none"
                    placeholder="Опишіть особливості, дефекти чи історію...">{{ old('description', $item->description ?? '') }}</textarea>
            </div>

            <div class="mt-6 space-y-2">
                <label class="text-sm font-black text-gray-600 uppercase tracking-wider">Фотографії</label>

                <div class="relative group" id="drop-zone">
                    <input type="file" id="file-input" name="images[]" multiple accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center group-hover:border-cyan-400 group-hover:bg-cyan-50/30 transition-all bg-gray-50/50">
                        <p class="text-gray-500 font-medium">Перетягніть фото або <span class="text-cyan-600 font-black">натисніть тут</span></p>
                    </div>
                </div>
                <div id="preview-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-gray-50 pt-6">
                <button type="submit" class="btn-primary px-12 shadow-lg shadow-cyan-600/20">
                    {{ isset($item) ? 'Оновити предмет' : 'Зберегти предмет' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        const fileInput = document.getElementById('file-input');
        const previewGrid = document.getElementById('preview-grid');
        const dropZone = document.getElementById('drop-zone');
        let dt = new DataTransfer();

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('bg-cyan-50'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('bg-cyan-50'), false);
        });

        dropZone.addEventListener('drop', e => {
            handleFiles(e.dataTransfer.files);
        }, false);

        fileInput.addEventListener('change', function () {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                dt.items.add(file);
                const reader = new FileReader();
                reader.onload = e => renderPreview(e.target.result, file.name, dt.items.length - 1);
                reader.readAsDataURL(file);
            });
            fileInput.files = dt.files;
        }

        function renderPreview(src, name, index) {
            const div = document.createElement('div');
            div.className = 'preview-item relative aspect-square rounded-xl overflow-hidden border border-cyan-100 group shadow-sm';
            div.dataset.index = index;
            div.innerHTML = `
                <img src="${src}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <button type="button" onclick="removeFile(${index})" class="bg-red-500 text-white text-xs font-black px-3 py-1.5 rounded-lg hover:bg-red-600 transition-colors">ВИДАЛИТИ</button>
                </div>
            `;
            previewGrid.appendChild(div);
        }

        function removeFile(index) {
            const newDt = new DataTransfer();
            Array.from(fileInput.files).forEach((file, i) => {
                if (i !== index) newDt.items.add(file);
            });
            fileInput.files = newDt.files;
            dt = newDt;
            previewGrid.innerHTML = '';
            Array.from(fileInput.files).forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = e => renderPreview(e.target.result, file.name, i);
                reader.readAsDataURL(file);
            });
        }
    </script>
@endsection