<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\AssetChange;
use Illuminate\Validation\Rule;
use App\Models\AssetVerification;
use App\Models\AssetPhotoChange;
use App\Services\ActivityLogger;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Services\ImageService;

class AssetController extends Controller
{

public function index(Request $request)
{
    $query = Asset::query()
        ->with('pendingChange');

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('property_number', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('serial_number', 'like', "%{$search}%")
              ->orWhere('assigned_to', 'like', "%{$search}%");

        });

    }

    $sort = $request->input('sort', 'property_number');
    $direction = $request->input('direction', 'asc');

    $query->orderBy($sort, $direction);

    if ($request->filled('status') && $request->status !== 'All') {
    $query->where('status', $request->status);
    }
    return Inertia::render('Assets', [
        'assets' => $query->paginate(10)->withQueryString(),
        'search' => $request->search,
    ]);
}


public function qr(Asset $asset)
{
    $url = route('assets.qr', $asset);

    $qr = (string) QrCode::format('svg')
    ->size(250)
    ->generate($url);

    return Inertia::render('Assets/PrintQr', [
        'asset' => $asset,
        'qr' => $qr,
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Asset Information
            'property_number' => [
    'required',
    'string',
    'max:255',
    Rule::unique('assets', 'property_number'),
],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'max:5120'],

            // Specifications
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],

            // Assignment
            'assigned_to' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],

            // Acquisition
            'acquisition_date' => ['nullable', 'date'],
            'acquisition_cost' => ['nullable', 'numeric'],
            'supplier' => ['nullable', 'string', 'max:255'],
            'warranty_expiry' => ['nullable', 'date'],

            // Linked
            'parent_asset_id' => ['nullable', 'exists:assets,id'],
        ]);


if ($request->hasFile('photo')) {

    $image = app(ImageService::class)
        ->storeAssetPhoto($request->file('photo'));

    $validated['photo_path'] = $image['photo_path'];
    $validated['photo_thumb_path'] = $image['photo_thumb_path'];
}



if (auth()->user()->isAdmin()) {
    Asset::create($validated);
} else {


if (
    AssetChange::pending()
        ->where('action', AssetChange::ACTION_CREATE)
        ->where('data->property_number', $validated['property_number'])
        ->exists()
) {
    return back()->with(
        'error',
        'A pending request already exists for this property number.'
    );
}


if (
    Asset::where('property_number', $validated['property_number'])
        ->exists()
) {
    return back()->with(
        'error',
        'An asset with this property number already exists.'
    );
}


$change = AssetChange::create([
    'user_id' => auth()->id(),
    'action' => AssetChange::ACTION_CREATE,
    'data' => $validated,
]);

app(\App\Services\ActivityLogger::class)->logAsset(
    ActivityLogger::ACTION_SUBMIT_CREATE,
    'Submitted creation request for asset ' . $validated['property_number'],
    null,
    $change
);

}


return redirect()
    ->route('assets')
    ->with('success', 'Asset submitted for approval.');





    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            // Asset Information
            'property_number' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'max:5120'],

            // Specifications
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],

            // Assignment
	    'assigned_to' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],

            // Acquisition
            'acquisition_date' => ['nullable', 'date'],
            'acquisition_cost' => ['nullable', 'numeric'],
            'supplier' => ['nullable', 'string', 'max:255'],
            'warranty_expiry' => ['nullable', 'date'],

            // Linked
            'parent_asset_id' => ['nullable', 'exists:assets,id'],
        ]);




if (auth()->user()->isAdmin()) {

    if ($request->hasFile('photo')) {

        if ($asset->photo_path) {
            Storage::disk('public')->delete($asset->photo_path);
        }

        $image = app(ImageService::class)
            ->storeAssetPhoto($request->file('photo'));

        $validated['photo_path'] = $image['photo_path'];
        $validated['photo_thumb_path'] = $image['photo_thumb_path'];
    }

    $asset->update($validated);

} else {

    if ($request->hasFile('photo')) {

        // Do NOT delete the current photo.
        // Just upload the new one for approval.
        $image = app(ImageService::class)
            ->storeAssetPhoto($request->file('photo'));

        $validated['photo_path'] = $image['photo_path'];
        $validated['photo_thumb_path'] = $image['photo_thumb_path'];
    }

    // existing AssetChange::create(...) code





$change = AssetChange::create([
    'asset_id' => $asset->id,
    'user_id' => auth()->id(),
    'action' => AssetChange::ACTION_UPDATE,
    'data' => $validated,
]);

app(ActivityLogger::class)->logAsset(
    ActivityLogger::ACTION_SUBMIT_UPDATE,
    'Submitted update request for asset ' . $asset->property_number,
    $asset,
    $change
);



}

return redirect()->route('assets.show', $asset);




    }

    public function destroy(Asset $asset)
    {


if (auth()->user()->isAdmin()) {

    if ($asset->photo_path) {
        Storage::disk('public')->delete($asset->photo_path);
    }

    $asset->delete();

} else {

if (
    AssetChange::pending()
        ->where('asset_id', $asset->id)
        ->exists()
) {
    return back()->with(
        'error',
        'This asset already has a pending request.'
    );
}



$change = AssetChange::create([
    'asset_id' => $asset->id,
    'user_id' => auth()->id(),
    'action' => AssetChange::ACTION_DELETE,
    'data' => $asset->toArray(),
]);

app(\App\Services\ActivityLogger::class)->logAsset(
    ActivityLogger::ACTION_SUBMIT_DELETE,
    'Submitted delete request for asset ' . $asset->property_number,
    $asset,
    $change
);



}



        return redirect()->route('assets');
    }

    public function show(Asset $asset)
{

$asset->load([
    'history.photos',
    'pendingChange',
    'pendingVerification',
    'photos',
    'maintenanceSchedule',
    'parent',
    'children',
]);

$asset->photos->each(function ($photo) {
    $photo->has_pending_request = \App\Models\AssetPhotoChange::where(
        'asset_photo_id',
        $photo->id
    )
    ->where('status', \App\Models\AssetPhotoChange::STATUS_PENDING)
    ->exists();
});

$approvedPhotoCount = $asset->photos->count();

$pendingPhotoCount = AssetPhotoChange::where('asset_id', $asset->id)
    ->where('action', AssetPhotoChange::ACTION_UPLOAD)
    ->where('status', AssetPhotoChange::STATUS_PENDING)
    ->count();

$maxPhotoCount = config('cmms.asset_photos.max_per_asset');

$asset->loadCount('children');

$asset->is_parent = $asset->children_count > 0;

return Inertia::render('Assets/Show', [
    'asset' => $asset,
    'approvedPhotoCount' => $approvedPhotoCount,
    'pendingPhotoCount' => $pendingPhotoCount,
    'maxPhotoCount' => $maxPhotoCount,
]);


}

public function verify(Asset $asset)
{
    $asset->update([
        'verified_at' => now(),
        'verified_by' => auth()->id(),
    ]);

    return redirect()
        ->route('assets.show', $asset)
        ->with('success', 'Asset verified successfully.');
}
public function search(Request $request)
{
    $search = trim($request->q ?? '');

    if ($search === '') {
        return response()->json([]);
    }

    $assets = Asset::query()
        ->where(function ($query) use ($search) {
            $query->where('property_number', 'like', "%{$search}%")
                ->orWhere('brand', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%");
        })
        ->select('id', 'property_number', 'type', 'brand', 'model')
        ->orderBy('property_number')
        ->limit(10)
        ->get();

    return response()->json($assets);
}
public function linkParent(Request $request, Asset $asset)
{
    $request->validate([
        'parent_asset_id' => ['required', 'exists:assets,id'],
    ]);

    $asset->update([
        'parent_asset_id' => $request->parent_asset_id,
    ]);

    return back();
}
public function showQr(Asset $asset)
{
    $asset->load([
        'history',
        'maintenanceSchedule',
    ]);

    return Inertia::render('Assets/QrShow', [
        'asset' => $asset,
    ]);
}


}
