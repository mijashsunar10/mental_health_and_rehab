<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    //
     public function index()
    {
        $teamMembers = TeamMember::orderBy('order')->get();
        return view('frontend.about.team.index', compact('teamMembers'));
    }

public function create()
    {
        return view('frontend.about.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            
        ]);
        
        $imagePath = $request->file('image')->store('team-images', 'public');
        
        TeamMember::create([
            'name' => $validated['name'],
            'position' => $validated['position'],
            'image_path' => $imagePath,
        ]);
        
        return redirect()->route('team.index')->with('success', 'Team member added successfully');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('frontend.about.team.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
          
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($teamMember->image_path);
            // Store new image
            $imagePath = $request->file('image')->store('team-images', 'public');
            $teamMember->image_path = $imagePath;
        }

        $teamMember->update([
            'name' => $validated['name'],
            'position' => $validated['position'],
            
        ]);

        return redirect()->route('team.index')->with('success', 'Team member updated successfully');
    }

    public function destroy(TeamMember $teamMember)
    {
        Storage::disk('public')->delete($teamMember->image_path);
        $teamMember->delete();
        return redirect()->route('team.index')->with('success', 'Team member deleted successfully');
    }

}
