<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-10 sm:px-6 lg:px-8">

            @guest
            {{-- for guest users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                    <a href="{{ route('register') }}" class="text-blue-500">register</a>.</p>
                </div>
            </div>
            @endguest

            @auth
            {{-- for authenticated users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-6 p-6">
                    <div class="flex justify-between">
                        <h2 class="text-lg font-semibold">Your Posts</h2>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('posts.create') }}">
                                <x-primary-button>{{ __('Create New Post') }}</x-primary-button>
                            </a>
                        </div>
                    </div>
                    @foreach ($posts as $post)
                    <div class="rounded-md border p-5 shadow">
                        <div class="flex justify-between items-center gap-2">
                            <h3><a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">{{ $post->title }}</a></h3>
                            <span class="flex-none rounded bg-{{ $post->status_color }}-100 px-2 py-1 text-{{ $post->status_color }}-1000 font-bold">{{ ucfirst($post->status) }}</span>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Published: {{ $post->publish_date ?? '-' }}</div>
                                <div>Updated: {{ $post->updated_at->diffForHumans() ?? $post->created_at->diffForHumans()  }}</div>
                            </div>
                            <div>
                                {{-- @if ($post->status === 'published') --}}
                                <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">Detail</a> /
                                {{-- @endif --}}
                                <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500">Edit</a> /
                                <button onclick="showDeleteModal({{ $post->id }})" class="text-red-500">Delete</button>
                                <form id="delete-form-{{ $post->id }}" action="{{ route('posts.destroy', $post->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div>{{ $posts->links() }}</div>
                </div>
            </div>
            @endauth
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 hidden">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this post?</p>
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" class="btn btn-secondary" onclick="hideDeleteModal()">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>

    <script>
        let postIdToDelete;

        function showDeleteModal(postId) {
            postIdToDelete = postId;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            document.getElementById('delete-form-' + postIdToDelete).submit();
        });
    </script>
</x-app-layout>
