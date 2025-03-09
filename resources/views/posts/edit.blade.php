<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <form method="post" action="{{ route('posts.update', $post->id) }}" class="space-y-6" onsubmit="return validateForm()">
                            @csrf
                            @method('PATCH')
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $post->title }}" required />
                                <x-input-error :messages="''" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="content" :value="__('Content')" />
                                <textarea id="content" name="content" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="6" required>{{ $post->content }}</textarea>
                                <x-input-error :messages="''" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                    <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                                    <option value="scheduled" {{ $post->status == 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                                </select>
                                <x-input-error :messages="''" class="mt-2" />
                            </div>

                            <div id="publish_date_container" style="{{ $post->status == 'scheduled' ? 'display: block;' : 'display: none;' }}">
                                <x-input-label for="publish_date" :value="__('Publish Date')" />
                                <x-text-input id="publish_date" name="publish_date" type="date" class="mt-1 block w-full" value="{{ $post->publish_date ? $post->publish_date->format('Y-m-d') : '' }}" />
                                <x-input-error :messages="''" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4" type="submit">
                                <x-primary-button>{{ __('Update') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('status').addEventListener('change', function() {
        var publishDateContainer = document.getElementById('publish_date_container');
        if (this.value === 'scheduled') {
            publishDateContainer.style.display = 'block';
        } else {
            publishDateContainer.style.display = 'none';
        }
    });

    function validateForm() {
        var status = document.getElementById('status').value;
        var publishDate = document.getElementById('publish_date').value;
        if (status === 'scheduled' && !publishDate) {
            alert('Please select a publish date for scheduled posts.');
            return false;
        }
        return true;
    }
</script>
