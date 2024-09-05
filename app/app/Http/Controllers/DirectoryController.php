<?php

namespace App\Http\Controllers;

use App\Http\Requests\Directory\GetDirectoryDataRequest;
use App\Http\Requests\Directory\ShowDirectoryRequest;
use App\Http\Requests\Directory\StoreDirectoryCodeRequest;
use App\Http\Requests\Directory\UpdateDirectoryRequest;
use App\Repositories\DirectoryRepository;
use Inertia\Inertia;

class DirectoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Directories/List');
    }

    public function show(ShowDirectoryRequest $request, DirectoryRepository $repository)
    {
        try {
            $code = $repository->findCode($request->get('id'));

            return Inertia::render('Admin/Directories/Show', [
                'code' => $code,
                'type' => $request->get('type'),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.directory.list');
        }
    }

    public function update(UpdateDirectoryRequest $request, DirectoryRepository $repository)
    {
        $data = $request->validated();
        $repository->updateCode($data['id'], $data);
        return redirect()->route('directory.show', ['type' => $data['type'], 'id' => $data['id']]);
    }

    public function create()
    {
        return Inertia::render('Admin/Directories/Create');
    }

    public function store(StoreDirectoryCodeRequest $request, DirectoryRepository $repository)
    {
        $repository->create($request->validated());
        return redirect()->route('admin.directory.create');
    }

    public function getDirectoryData(GetDirectoryDataRequest $request, DirectoryRepository $repository)
    {
        return response()->json($repository->getDirectory($request->input('search', '')));
    }

    public function getDirectoryFolders(GetDirectoryDataRequest $request, DirectoryRepository $repository)
    {
        return response()->json($repository->getFolders());
    }
}
