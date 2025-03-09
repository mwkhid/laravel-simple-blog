<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <form method="post" action="{{ route('posts.store') }}" class="space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" />
                                <x-input-error :messages="''" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="content" :value="__('Content')" />
                                <textarea id="content" name="content" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="6"></textarea>
                                <x-input-error :messages="''" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="draft">{{ __('Draft') }}</option>
                                    <option value="published">{{ __('Published') }}</option>
                                    <option value="scheduled">{{ __('Scheduled') }}</option>
                                </select>
                                <x-input-error :messages="''" class="mt-2" />
                            </div>

                            <div id="publish_date_container" style="display: none;">
                                <x-input-label for="publish_date" :value="__('Publish Date')" />
                                <x-text-input id="publish_date" name="publish_date" type="date" class="mt-1 block w-full" />
                                <x-input-error :messages="''" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4" type="submit">
                                <x-primary-button>{{ __('Post') }}</x-primary-button>
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
</script>
