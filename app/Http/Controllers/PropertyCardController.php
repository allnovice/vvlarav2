<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Asset;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PropertyCardController extends Controller
{
    public function print(Request $request)
    {
        $ids = explode(',', $request->ids);

        $assets = Asset::whereIn('id', $ids)->get();

$assets = Asset::whereIn('id', $ids)
    ->orderBy('property_number')
    ->get();

$assets->transform(function ($asset) {
    $asset->qr = (string) QrCode::format('svg')
        ->size(180)
        ->generate(route('assets.qr', $asset));

    return $asset;
});

        return Inertia::render('PropertyCards/Print', [
            'assets' => $assets,
        ]);
    }
}
