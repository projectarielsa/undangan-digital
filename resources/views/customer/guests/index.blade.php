@extends('layouts.dashboard')
@section('page-title', 'Kelola Tamu')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <div class="mb-6"><a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali ke Undangan</a></div>

    <!-- RSVP Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border text-center"><p class="text-2xl font-bold">{{ $rsvpStats['total'] }}</p><p class="text-xs text-gray-500">Total</p></div>
        <div class="bg-green-50 rounded-xl p-4 border border-green-200 text-center"><p class="text-2xl font-bold text-green-600">{{ $rsvpStats['attending'] }}</p><p class="text-xs text-green-600">Hadir</p></div>
        <div class="bg-red-50 rounded-xl p-4 border border-red-200 text-center"><p class="text-2xl font-bold text-red-600">{{ $rsvpStats['not_attending'] }}</p><p class="text-xs text-red-600">Tidak</p></div>
        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200 text-center"><p class="text-2xl font-bold text-yellow-600">{{ $rsvpStats['maybe'] }}</p><p class="text-xs text-yellow-600">Mungkin</p></div>
        <div class="bg-gray-50 rounded-xl p-4 border text-center"><p class="text-2xl font-bold text-gray-500">{{ $rsvpStats['pending'] }}</p><p class="text-xs text-gray-500">Pending</p></div>
    </div>

    <!-- Add Guest -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tambah Tamu</h3>
        <form method="POST" action="{{ route('customer.guests.store', $invitation) }}" class="flex flex-wrap gap-3">
            @csrf
            <input type="text" name="name" required placeholder="Nama tamu" class="flex-1 min-w-[200px] px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
            <input type="text" name="phone" placeholder="No. HP (08xxx)" class="w-48 px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
            <input type="text" name="invited_by" placeholder="Turut Mengundang (opsional)" class="w-56 px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
            <button type="submit" class="px-5 py-2.5 bg-amber-600 text-white text-sm font-medium rounded-xl hover:bg-amber-700 transition">Tambah</button>
        </form>
        <p class="text-xs text-gray-400 mt-2">Contoh "Turut Mengundang": Bapak Ahmad, Ibu Siti, Keluarga Besar Surya</p>
    </div>

    <!-- Import -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Import dari CSV/Excel</h3>
        <form method="POST" action="{{ route('customer.guests.import', $invitation) }}" enctype="multipart/form-data" class="flex items-center gap-3">
            @csrf
            <input type="file" name="file" accept=".csv,.xlsx,.xls" required class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700">
            <button type="submit" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition">Import</button>
        </form>
        <p class="text-xs text-gray-400 mt-2">Format: Nama, No HP, Turut Mengundang (satu baris per tamu)</p>
    </div>

    <!-- Share All -->
    @if(!$guests->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Kirim Undangan</h3>
        <div class="flex flex-wrap gap-3">
            <button onclick="copyAllLinks()" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                Copy Semua Link
            </button>
            <button onclick="copyAllWaMessages()" class="px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Copy Semua Pesan WA
            </button>
        </div>
        <p class="text-xs text-gray-400 mt-2">Pesan WA akan menggunakan template undangan lengkap</p>
    </div>
    @endif

    <!-- Guest List -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border">
        <div class="p-6 border-b"><h3 class="font-semibold text-gray-900 dark:text-white">Daftar Tamu ({{ $guests->total() }})</h3></div>
        @if($guests->isEmpty())
        <div class="p-8 text-center text-gray-500">Belum ada tamu yang ditambahkan.</div>
        @else
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($guests as $guest)
            <div class="p-4 flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 dark:text-white">{{ $guest->name }}</p>
                    <p class="text-xs text-gray-500">{{ $guest->phone }}</p>
                    @if($guest->invited_by)
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-0.5">Turut Mengundang: {{ $guest->invited_by }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-1">
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $guest->rsvp_status === 'attending' ? 'bg-green-100 text-green-700' : ($guest->rsvp_status === 'not_attending' ? 'bg-red-100 text-red-700' : ($guest->rsvp_status === 'maybe' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600')) }}">{{ ucfirst(str_replace('_', ' ', $guest->rsvp_status)) }}</span>
                    <!-- Copy Link -->
                    <button onclick="copyGuestLink('{{ urlencode($guest->name) }}')" class="p-1.5 text-gray-400 hover:text-amber-600 transition" title="Copy Link">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </button>
                    <!-- Share WA -->
                    <button onclick="shareViaWa('{{ urlencode($guest->name) }}', '{{ $guest->phone }}')" class="p-1.5 text-gray-400 hover:text-green-600 transition" title="Share via WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </button>
                    <!-- Delete -->
                    <form method="POST" action="{{ route('customer.guests.destroy', [$invitation, $guest]) }}" onsubmit="return confirm('Hapus tamu ini?')">@csrf @method('DELETE')<button class="p-1.5 text-gray-400 hover:text-red-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="p-4">{{ $guests->links() }}</div>
        @endif
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-medium transition-all duration-300 opacity-0 translate-y-4 pointer-events-none z-50">
    <span id="toast-message">Link berhasil disalin!</span>
</div>

@push('scripts')
<script>
const invitationUrl = "{{ $invitation->getUrl() }}";
const groomName = "{{ $invitation->groom_name }}";
const brideName = "{{ $invitation->bride_name }}";
const eventDate = "{{ $invitation->event_date->format('d/m/Y') }}";
const eventTimeStart = "{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }}";
const eventTimeEnd = "{{ $invitation->event_time_end ? \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }}";

function generateWaText(guestName) {
    const timeRange = eventTimeEnd ? `${eventTimeStart} - ${eventTimeEnd} WIB` : `${eventTimeStart} WIB`;
    const decodedName = decodeURIComponent(guestName);
    const guestLink = `${invitationUrl}?to=${decodedName.replace(/ /g, '%20')}`;
    
    return `Yth. Bapak/Ibu/Saudara/i
*${decodeURIComponent(guestName)}*
Di Tempat
---------------------------
_Assalamualaikum Wr. Wb._
Dengan segala kerendahan hati,
kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara,
=============
*The Wedding Of ${groomName.toUpperCase()} & ${brideName.toUpperCase()}*
=============
*♥️Save The Date♥️*
----------------
_Pada_
📅 Tanggal : *${eventDate}*
🕘 Pukul : *${timeRange}*
_Tempat_
🏠 *Lihat pada link undangan dibawah.*
-----------------
Untuk detail acaranya, bisa kunjungi link berikut.👇

${guestLink}

Kami sangat berharap Bapak/Ibu/Saudara/i dapat menghadiri acara tersebut,
--------------------------------
Wassalamualaikum Wr. Wb,
🙏 Hormat Kami,
*${groomName} & ${brideName}*`;
}

function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toast-message');
    toastMsg.textContent = message;
    toast.classList.remove('opacity-0', 'translate-y-4');
    toast.classList.add('opacity-100', 'translate-y-0');
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 2500);
}

function copyGuestLink(guestName) {
    const link = `${invitationUrl}?to=${decodeURIComponent(guestName).replace(/ /g, '%20')}`;
    navigator.clipboard.writeText(link).then(() => showToast('Link berhasil disalin! 📋'));
}

function copyAllLinks() {
    const guests = @json($guests->pluck('name'));
    const links = guests.map(name => `${name}: ${invitationUrl}?to=${name.replace(/ /g, '%20')}`).join('\n');
    navigator.clipboard.writeText(links).then(() => showToast(`${guests.length} link berhasil disalin! 📋`));
}

function copyAllWaMessages() {
    const guests = @json($guests->pluck('name'));
    const messages = guests.map(name => {
        return `--- ${name} ---\n` + generateWaText(name.replace(/ /g, '%20')) + '\n';
    }).join('\n\n');
    navigator.clipboard.writeText(messages).then(() => showToast(`${guests.length} pesan WA berhasil disalin! 📱`));
}

function shareViaWa(guestName, phone) {
    const message = generateWaText(guestName);
    let waUrl;
    
    if (phone) {
        // Format phone: remove non-digits, convert 08xx to 628xx
        let formattedPhone = phone.replace(/[^0-9]/g, '');
        if (formattedPhone.startsWith('0')) {
            formattedPhone = '62' + formattedPhone.substring(1);
        }
        waUrl = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`;
    } else {
        // No phone number, open WA without number (user picks contact)
        waUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
    }
    
    window.open(waUrl, '_blank');
}
</script>
@endpush
</div>
@endsection
