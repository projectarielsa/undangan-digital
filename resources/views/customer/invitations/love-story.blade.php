@extends('layouts.dashboard')
@section('page-title', 'Love Story Timeline')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Edit
        </a>
        <span class="px-3 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Premium Feature</span>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Love Story Timeline</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Ceritakan perjalanan cinta kalian berdua dari pertama bertemu hingga saat ini. Maksimal 10 momen spesial.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('customer.invitations.love-story.update', $invitation) }}" enctype="multipart/form-data" x-data="loveStoryForm()">
        @csrf
        @method('PUT')

        <div class="space-y-4" id="story-container">
            <template x-for="(story, index) in stories" :key="index">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 relative">
                    <div class="absolute -left-3 top-6 w-6 h-6 bg-amber-500 rounded-full flex items-center justify-center text-white text-xs font-bold" x-text="index + 1"></div>
                    
                    <button type="button" @click="removeStory(index)" class="absolute top-4 right-4 p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>

                    <div class="grid md:grid-cols-3 gap-4 pr-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal/Waktu</label>
                            <input type="text" :name="`love_story[${index}][date]`" x-model="story.date" placeholder="Contoh: Januari 2020" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Momen *</label>
                            <input type="text" :name="`love_story[${index}][title]`" x-model="story.title" required placeholder="Contoh: Pertama Kali Bertemu" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cerita *</label>
                        <textarea :name="`love_story[${index}][description]`" x-model="story.description" required rows="3" placeholder="Ceritakan momen spesial ini..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto (Opsional)</label>
                        <div class="flex items-center gap-4">
                            <template x-if="story.image">
                                <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100">
                                    <img :src="story.image.startsWith('data:') ? story.image : `/storage/${story.image}`" class="w-full h-full object-cover">
                                </div>
                            </template>
                            <input type="file" :name="`love_story[${index}][image]`" accept="image/*" @change="previewImage($event, index)" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="mt-4">
            <button type="button" @click="addStory()" x-show="stories.length < 10" class="w-full py-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl text-gray-500 hover:text-amber-600 hover:border-amber-400 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Momen (<span x-text="stories.length"></span>/10)
            </button>
        </div>

        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all hover:shadow-xl">
                Simpan Love Story
            </button>
            <a href="{{ route('customer.invitations.edit', $invitation) }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium">Batal</a>
        </div>
    </form>
</div>

<script>
function loveStoryForm() {
    return {
        stories: @json($loveStory ?: []),
        
        init() {
            if (this.stories.length === 0) {
                this.addStory();
            }
        },
        
        addStory() {
            if (this.stories.length < 10) {
                this.stories.push({
                    date: '',
                    title: '',
                    description: '',
                    image: null
                });
            }
        },
        
        removeStory(index) {
            if (confirm('Hapus momen ini?')) {
                this.stories.splice(index, 1);
            }
        },
        
        previewImage(event, index) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.stories[index].image = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }
}
</script>
@endsection
