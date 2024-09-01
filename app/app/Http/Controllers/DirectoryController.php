<?php

namespace App\Http\Controllers;

use App\Http\Requests\Directory\GetDirectoryDataRequest;
use App\Http\Requests\Directory\StoreDirectoryCodeRequest;
use App\Models\DefectCode;
use App\Models\SymptomCode;
use App\Repositories\DirectoryRepository;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DirectoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Directories/List');
    }

//    public function show($id)
//    {
//        $directory = Directory::find($directoryId);
//    }

    public function getDirectoryData(GetDirectoryDataRequest $request, DirectoryRepository $repository)
    {
        return response()->json($repository->getDirectory($request->input('search', '')));
    }

    public function getDirectoryFolders(GetDirectoryDataRequest $request, DirectoryRepository $repository)
    {
        return response()->json($repository->getFolders());
    }

    public function create()
    {
        return Inertia::render('Admin/Directories/Create');
    }

    public function store(StoreDirectoryCodeRequest $request, DirectoryRepository $repository)
    {
        $repository->create($request->input('name'), $request->input('folder'));
        return Redirect::route('directory.create');
    }
}
