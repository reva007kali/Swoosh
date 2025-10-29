<?php

namespace App\Livewire\Members;

use App\Models\TopUp;
use App\Models\Member;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

class ViewMember extends Component
{
    use WithFileUploads;

    public $member;
    public $photo;
    public $amount;
    public $service_id;
    public $vehicle_id;
    public $showAddVehicle = false;

    public $newVehicle = [
        'plate_number' => '',
        'type' => '',
        'color' => '',
    ];

    public $quantity = 1;
    public $discount = 0;
    public $tax = 0;
    public $payment_method_id;
    public $qrCodeSvg;

    public function mount($qr_code)
    {
        $this->member = Member::with('vehicles')->where('qr_code', $qr_code)->firstOrFail();

        // Generate QR Code
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $this->qrCodeSvg = $writer->writeString(route('members.view', $this->member->qr_code));
    }

    // ------------------- FOTO PROFIL -------------------
    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048', // maksimal 2MB
        ]);

        if ($this->member->user && $this->member->user->image) {
            Storage::disk('public')->delete($this->member->user->image);
        }

        $path = $this->photo->store('profile', 'public');
        $this->member->user->update(['image' => $path]);
        $this->member->refresh();

        session()->flash('message', 'Foto profil berhasil diperbarui!');
    }

    // ------------------- TOP UP -------------------
    public function topUp()
    {
        // Validasi input
        $this->validate([
            'amount' => 'required|numeric|min:1000',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        // Simpan nilai amount ke variabel lokal
        $amount = $this->amount;

        // Tambahkan saldo ke member
        $this->member->increment('balance', $amount);

        // Simpan ke tabel top_ups
        $topUp = TopUp::create([
            'member_id' => $this->member->id,
            'user_id' => auth()->id(),
            'payment_method_id' => $this->payment_method_id,
            'amount' => $amount,
        ]);

        // Reset input form agar bersih kembali
        $this->reset(['amount', 'payment_method_id', 'amountFormatted']);

        // Ambil nama metode pembayaran dari relasi TopUp
        $paymentName = optional($topUp->paymentMethod)->name ?? 'metode tidak diketahui';

        // Tampilkan notifikasi sukses
        Notification::make()
            ->title('Top Up Berhasil')
            ->body('Saldo berhasil ditambahkan sebesar Rp ' . number_format($amount, 0, ',', '.') .
                ' melalui ' . $paymentName)
            ->success()
            ->send();

        // Optional: refresh data member agar saldo langsung update di UI
        $this->member->refresh();
    }


    public $amountFormatted;

    public function updatedAmountFormatted($value)
    {
        // Hapus semua karakter non-angka
        $numeric = preg_replace('/[^0-9]/', '', $value);

        // Simpan angka murni ke $amount
        $this->amount = (int) $numeric;

        // Format ulang untuk tampilan (Rp 12.345)
        $this->amountFormatted = 'Rp ' . number_format($this->amount, 0, ',', '.');
    }


    // ------------------- TRANSAKSI -------------------
    public function makeTransaction()
    {
        $this->validate([
            'service_id' => 'required|exists:services,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ]);

        $service = Service::find($this->service_id);
        $vehicle = $this->member->vehicles->find($this->vehicle_id);
        $paymentMethod = PaymentMethod::find($this->payment_method_id);

        if (!$vehicle) {
            Notification::make()
                ->title('Gagal')
                ->body('Kendaraan tidak valid.')
                ->danger()
                ->send();
            return;
        }

        $totalAmount = $service->price * $this->quantity;
        $grandTotal = $totalAmount - ($this->discount ?? 0) + ($this->tax ?? 0);

        // 🔹 Kurangi saldo hanya jika metode pembayaran adalah Balance/Saldo
        if ($paymentMethod && in_array(strtolower($paymentMethod->name), ['saldo member', 'saldo'])) {

            // Pastikan saldo cukup
            if ($this->member->balance < $grandTotal) {
                Notification::make()
                    ->title('Gagal')
                    ->body('Saldo tidak cukup untuk melakukan transaksi ini.')
                    ->danger()
                    ->send();
                return;
            }

            // Kurangi saldo member
            $this->member->balance -= $grandTotal;
        }

        // Tambahkan poin loyalti
        $this->member->member_point += 10000;
        $this->member->save();

        // Simpan transaksi
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'vehicle_id' => $vehicle->id,
            'cashier_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'discount' => $this->discount ?? 0,
            'tax' => $this->tax ?? 0,
            'grand_total' => $grandTotal,
            'payment_method_id' => $this->payment_method_id,
            'status' => 'completed',
        ]);

        // Simpan detail item transaksi
        $transaction->items()->create([
            'service_id' => $service->id,
            'quantity' => $this->quantity,
            'price' => $service->price,
            'subtotal' => $totalAmount,
        ]);

        Notification::make()
            ->title('Transaksi Berhasil')
            ->body('Transaksi selesai! +10.000 point')
            ->success()
            ->send();

        // Reset form
        $this->reset(['service_id', 'vehicle_id', 'quantity', 'discount', 'tax', 'payment_method_id']);
        $this->quantity = 1;
    }

    // ------------------- TAMBAH KENDARAAN -------------------
    public function addVehicle()
    {
        $this->validate([
            'newVehicle.plate_number' => 'required|string|max:50',
            'newVehicle.type' => 'nullable|string|max:50',
            'newVehicle.color' => 'nullable|string|max:30',
        ]);

        $vehicle = $this->member->vehicles()->create($this->newVehicle);

        $this->newVehicle = [
            'plate_number' => '',
            'type' => '',
            'color' => '',
        ];

        $this->showAddVehicle = false;
        $this->vehicle_id = $vehicle->id;
        $this->member->refresh();

        Notification::make()
            ->title('Kendaraan Ditambahkan')
            ->body('Kendaraan baru berhasil ditambahkan ke member.')
            ->success()
            ->send();
    }

    // ------------------- RENDER -------------------
    public function render()
    {
        $topUps = TopUp::where('member_id', $this->member->id)
            ->latest()
            ->take(10)
            ->get();

        $services = Service::all();
        $paymentMethods = PaymentMethod::all();
        $latestTransactions = $this->member->transactions()
            ->latest()
            ->take(5)
            ->with('items.service', 'vehicle')
            ->get();

        return view('livewire.members.view-member', compact(
            'services',
            'paymentMethods',
            'latestTransactions',
            'topUps'
        ));
    }
}
