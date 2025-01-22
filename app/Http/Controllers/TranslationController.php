<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        try {
            $translations = Translation::query();

            if ($request->has('locale')) {
                $translations->where('locale', $request->locale);
            }

            if ($request->has('tags')) {
                $translations->whereJsonContains('tags', $request->tags);
            }

            if ($request->has('key')) {
                $translations->where('key', $request->key);
            }

            return response()->json($translations->paginate(50));
        } catch (\Exception $e) {
            throw new \Exception("An unexpected error occurred.");
        }
    }

    public function store(Request $request){

        $data = $request->validate([
            'locale' => 'required|string',
            'key' => 'required|string|unique:translations,key',
            'content' => 'required|string',
            'tags' => 'nullable|array',
        ]);

        try {
            $translation = Translation::create($data);
            return response()->json($translation, 201);
        } catch (\Exception $e) {
            throw new \Exception("Failed to create the translation.");
        }
    }

    public function update(Request $request, $id){

        $data = $request->validate([
            'locale' => 'required|string',
            'key' => 'required|string|unique:translations,key,' . $id,
            'content' => 'required|string',
            'tags' => 'nullable|array',
        ]);

        try {
            $translation = Translation::findOrFail($id);
            $translation->update($data);
            return response()->json($translation);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception("Failed to update the translation.");
        }
    }

    public function destroy($id){

        try {
            $translation = Translation::findOrFail($id); 
            $translation->delete();
            return response()->json(['message' => 'Deleted']);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete the translation.");
        }
    }

    // public function export()
    // {
    //     $translations = Cache::remember('translations_export', 3600, function () {
    //         return Translation::all(['locale', 'key', 'content'])->groupBy('locale');
    //     });

    //     return response()->json($translations);  
    // }

    public function export(Request $request){

        try {
            $locale = $request->get('locale');
            $perPage = $request->get('per_page', 100);

            $translations = Cache::remember("translations_export_{$locale}_page_{$request->get('page', 1)}", 3600, function () use ($locale, $perPage) {
                $query = Translation::select(['id', 'tags', 'locale', 'key', 'content'])->orderBy('locale');

                if ($locale) {
                    $query->where('locale', $locale);
                }

                return $query->paginate($perPage);
            });

            return response()->json($translations);
        } catch (\Exception $e) {
            throw new \Exception("Failed to export translations.");
        }
    }




    // public function export(Request $request){

    // $locale = $request->get('locale');
    // $perPage = $request->get('per_page', 100);

    // $translations = Cache::remember("translations_export_{$locale}_page_{$request->get('page', 1)}", 3600, function () use ($locale, $perPage) {
    //     $query = Translation::select(['id', 'locale', 'key', 'content', 'tags'])->orderBy('locale');

    //     if ($locale) {
    //         $query->where('locale', $locale);
    //     }

    //     $paginated = $query->paginate($perPage);

    //     foreach ($paginated->items() as $item) {
    //         if (is_string($item->tags)) {
    //             $item->tags = json_decode($item->tags, true);
    //         }
    //     }

    //     return $paginated;
    // });

    // return response()->stream(function () use ($translations) {
    //     echo json_encode($translations);
    // });

    // }



    public function getTranslations(Request $request){

        try {
            $page = $request->query('page', 1);
            $translations = Cache::remember("translations_page_{$page}", 3600, function () {
                return Translation::paginate(100);
            });

            return response()->json($translations);
        } catch (\Exception $e) {
            throw new \Exception("Failed to retrieve translations.");
        }
    }
}
