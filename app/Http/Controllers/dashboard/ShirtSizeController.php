<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShirtSizes;

class ShirtSizeController extends Controller
{
  public function showShirtSizes()
  {
    $data = ShirtSizes::All();
    return view('content.dashboard.dashboards-shirts',compact('data'));
  }
  public function storeShirtSize(Request $request)
  {
    try {
    $shirtSizes = new ShirtSizes();
    $shirtSizes->size = $request->input('size');
    $shirtSizes->save();
    return redirect()->back()->with('success', "Přidání proběhlo úspěšně!");
  } catch (Exception $e)
  {
    return redirect()->back()->with('error', "Nastala chyba při přidávání!" . $e);
  }
  }
  public function deleteShirtSize($id)
  {
    try {
      $shirtSize = ShirtSizes::where('id',$id);
      if ($shirtSize)
      {
        $shirtSize->delete();
        return redirect()->back()->with('success', "Velikost úspěšně smazána!");
      }

    } catch(Exception $e)
    {
      return redirect()->back()->with('error', "Nastala chyba při mazání!" . $e);
    }
  }
}
