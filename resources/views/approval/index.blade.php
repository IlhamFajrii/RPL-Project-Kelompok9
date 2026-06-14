@extends('layouts.app')

@section('title', 'Approval Peminjaman')
@section('page-title', 'Approval Peminjaman')

@section('content')
<div class="space-y-6">
    <!-- Filter Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="GET" action="{{ route('approval.index') }}" class="flex gap-4">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Semua Status --</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                <option value="returned" @selected(request('status') === 'returned')>Returned</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all">
                Filter
            </button>
            <a href="{{ route('approval.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
                Reset
            </a>
        </form>
    </div>

    <!-- Peminjaman List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($peminjaman as $item)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $item->user->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $item->user->email }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if($item->status_approval === 'approved')
                        bg-green-100 text-green-700
                    @elseif($item->status_approval === 'pending')
                        bg-yellow-100 text-yellow-700
                    @elseif($item->status_approval === 'rejected')
                        bg-red-100 text-red-700
                    @else
                        bg-blue-100 text-blue-700
                    @endif
                ">
                    {{ ucfirst($item->status_approval) }}
                </span>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <p class="font-semibold text-gray-800">{{ $item->alat->nama_alat }}</p>
                <p class="text-sm text-gray-600">Kode: {{ $item->alat->kode_alat }}</p>
                <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                    <div>
                        <p class="text-gray-600">Tanggal Pinjam</p>
                        <p class="font-semibold">{{ $item->tanggal_pinjam->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Rencana Kembali</p>
                        <p class="font-semibold">{{ $item->tanggal_rencana_kembali->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            @if($item->status_approval === 'pending')
                <div class="flex gap-2 mb-4">
                    <button 
                        class="btn-approve flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-semibold text-sm"
                        data-id="{{ $item->id }}"
                    >
                        Setuju
                    </button>
                    <button 
                        class="btn-reject flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-semibold text-sm"
                        data-id="{{ $item->id }}"
                    >
                        Tolak
                    </button>
                </div>
            @elseif($item->status_approval === 'approved' && !$item->tanggal_kembali)
                <button 
                    class="btn-return w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold text-sm mb-4"
                    data-id="{{ $item->id }}"
                >
                    Proses Pengembalian
                </button>
            @endif

            <a href="{{ route('approval.show', $item) }}" class="w-full text-center text-blue-600 font-semibold hover:underline text-sm">
                Lihat Detail →
            </a>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">Tidak ada peminjaman</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($peminjaman->hasPages())
        <div class="flex justify-center mt-8">
            {{ $peminjaman->links() }}
        </div>
    @endif
</div>

<script>
// Define functions first (global scope)
function approveModal(id) {
    if (confirm('Setuju dengan peminjaman ini?')) {
        fetch('/approval/' + id + '/approve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Gagal menyetujui peminjaman');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function rejectModal(id) {
    // Create a modal dialog for rejection reason input
    const modal = document.createElement('div');
    modal.id = 'rejectModal_' + id;
    modal.innerHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;">
            <div style="background: white; padding: 2rem; border-radius: 0.5rem; width: 90%; max-width: 400px;">
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Tolak Peminjaman</h3>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Alasan Penolakan: *</label>
                    <textarea id="rejectReason_${id}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem; height: 100px; font-family: inherit;" placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button onclick="confirmReject(${id})" style="flex: 1; background: #dc2626; color: white; padding: 0.5rem; border: none; border-radius: 0.25rem; cursor: pointer; font-weight: 500;">
                        Tolak
                    </button>
                    <button onclick="cancelReject(${id})" style="flex: 1; background: #6b7280; color: white; padding: 0.5rem; border: none; border-radius: 0.25rem; cursor: pointer; font-weight: 500;">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function confirmReject(id) {
    const reason = document.getElementById('rejectReason_' + id).value;
    
    if (!reason || reason.trim() === '') {
        alert('Alasan penolakan harus diisi');
        return;
    }
    
    // Close modal
    const modal = document.getElementById('rejectModal_' + id);
    if (modal) modal.remove();
    
    fetch('/approval/' + id + '/reject', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ alasan_reject: reason })
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Gagal menolak peminjaman');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function cancelReject(id) {
    const modal = document.getElementById('rejectModal_' + id);
    if (modal) modal.remove();
}

function returnModal(id) {
    // Create a modal dialog for return date input
    const today = new Date().toISOString().split('T')[0];
    const modal = document.createElement('div');
    modal.id = 'returnModal_' + id;
    modal.innerHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;">
            <div style="background: white; padding: 2rem; border-radius: 0.5rem; width: 90%; max-width: 400px;">
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Proses Pengembalian Alat</h3>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal Pengembalian:</label>
                    <input type="date" id="returnDate_${id}" value="${today}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Catatan (Opsional):</label>
                    <textarea id="returnNote_${id}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem; height: 80px;"></textarea>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button onclick="confirmReturn(${id})" style="flex: 1; background: #16a34a; color: white; padding: 0.5rem; border: none; border-radius: 0.25rem; cursor: pointer; font-weight: 500;">
                        Simpan
                    </button>
                    <button onclick="cancelReturn(${id})" style="flex: 1; background: #ef4444; color: white; padding: 0.5rem; border: none; border-radius: 0.25rem; cursor: pointer; font-weight: 500;">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function confirmReturn(id) {
    const date = document.getElementById('returnDate_' + id).value;
    const note = document.getElementById('returnNote_' + id).value;
    
    if (!date) {
        alert('Tanggal pengembalian harus diisi');
        return;
    }
    
    // Close modal
    const modal = document.getElementById('returnModal_' + id);
    if (modal) modal.remove();
    
    fetch('/approval/' + id + '/return', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ tanggal_kembali: date, catatan: note || '' })
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Gagal memproses pengembalian');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function cancelReturn(id) {
    const modal = document.getElementById('returnModal_' + id);
    if (modal) modal.remove();
}

// Attach event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Attach event listeners for approve buttons
    document.querySelectorAll('.btn-approve').forEach(button => {
        button.addEventListener('click', function() {
            approveModal(this.dataset.id);
        });
    });

    // Attach event listeners for reject buttons
    document.querySelectorAll('.btn-reject').forEach(button => {
        button.addEventListener('click', function() {
            rejectModal(this.dataset.id);
        });
    });

    // Attach event listeners for return buttons
    document.querySelectorAll('.btn-return').forEach(button => {
        button.addEventListener('click', function() {
            returnModal(this.dataset.id);
        });
    });
});
</script>

@endsection
