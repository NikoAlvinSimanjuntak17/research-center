<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Histories;
use App\Models\Profile;
use App\Models\VisionMission;
use App\Models\OrganizationStructure;


class AboutController extends Controller
{
    // Method to display "Sejarah" page
    public function sejarah()
    {
        $history = Profile::where('key', 'sejarah')->where('active', true)->first();

        return view('sejarah', compact('history'));
    }

    // Method to display "Visi & Misi" page
    public function visimisi()
    {
        $visi = VisionMission::where('type', 'visi')->value('content');
        $misi = VisionMission::where('type', 'misi')->value('content');
        
        return view('visimisi', compact('visi', 'misi'));
    }

    // Method to display "Organisasi" page
    // public function organisasi()
    // {
    //     // You can add logic here to fetch organization data if needed
    //     // For now, we will just return the view
    //     $organization = OrganizationStructure::all();
    //     return view('organisasi', compact('organization'));
    // }
    public function organisasi()
{
    $organization = Profile::where('key', 'organisasi')->where('active', true)->get();
    return view('organisasi', compact('organization'));
}
}