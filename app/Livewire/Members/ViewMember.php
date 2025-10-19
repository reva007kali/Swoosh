<?php

namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\Member;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use Filament\Notifications\Notification;


class ViewMember extends Component
{
    public $member;
    public $amount; // top up
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

        // QR code generation
        $renderer = new ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $this->qrCodeSvg = $writer->writeString(route('members.view', $this->member->qr_code));
    }

    // ------------------- TOP UP -------------------
    public function topUp()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        $this->member->balance += $this->amount;
        $this->member->save();

        Notification::make()
            ->title('Top Up Berhasil')
            ->body('Saldo berhasil ditambahkan: Rp ' . number_format($this->amount, 0, ',', '.'))
            ->success()
            ->send();
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

        if ($this->member->balance < $grandTotal) {
            Notification::make()
                ->title('Gagal')
                ->body('Saldo tidak cukup.')
                ->danger()
                ->send();
            return;
        }

        // Kurangi saldo & tambah point
        $this->member->balance -= $grandTotal;
        $this->member->member_point += 10000;
        $this->member->save();

        // Buat transaksi
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
        $this->service_id = null;
        $this->vehicle_id = null;
        $this->quantity = 1;
        $this->discount = 0;
        $this->tax = 0;
        $this->payment_method_id = null;
    }

    public function addVehicle()
    {
        $this->validate([
            'newVehicle.plate_number' => 'required|string|max:50',
            'newVehicle.type' => 'nullable|string|max:50',
            'newVehicle.color' => 'nullable|string|max:30',
        ]);

        $vehicle = $this->member->vehicles()->create($this->newVehicle);

        // Reset form
        $this->newVehicle = [
            'plate_number' => '',
            'type' => '',
            'color' => '',
        ];

        $this->showAddVehicle = false;

        // Pilih kendaraan baru langsung
        $this->vehicle_id = $vehicle->id;

        // Refresh member vehicles
        $this->member->refresh();


         $this->successMessage = 'Kendaraan berhasil ditambahkan!';
    }
    public function render()
    {
        $services = Service::all();
        $paymentMethods = PaymentMethod::all();
        $latestTransactions = $this->member->transactions()->latest()->take(5)->with('items.service', 'vehicle')->get();

        return view('livewire.members.view-member', compact(
            'services',
            'paymentMethods',
            'latestTransactions'
        ));
    }
}
