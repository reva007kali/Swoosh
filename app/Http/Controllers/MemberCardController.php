<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class MemberCardController extends Controller
{
    public function download(Member $member)
    {
        // Generate QR code SVG
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString(route('members.view', $member->qr_code));

        // Load Blade view ke PDF
        $pdf = Pdf::loadView('member-card-pdf', [
            'member' => $member,
            'qrCodeSvg' => $qrCodeSvg,
        ])
        ->setPaper([0, 0, 340, 340]); // ukuran kartu member (px)

        return $pdf->download($member->name . '-member-card.pdf');
    }
}
