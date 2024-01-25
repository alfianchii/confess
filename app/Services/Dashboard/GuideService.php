<?php

namespace App\Services\Dashboard;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\{Validator};
use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{User, MasterGuide, MasterRole};
use App\Models\Traits\Helpers\Guideable;

class GuideService extends Service
{
  // ---------------------------------
  // TRAITS
  use Guideable;


  // ---------------------------------
  // PROPERTIES
  protected array $rules = [
    "nav_title" => ["required", "max:255"],
    "title" => ["required", "max:255"],
    "slug" => ["required", "unique:mst_guides"],
    "id_guide_parent" => ["required"],
    "status" => ["required", "in:single,parent"],
    "body" => ["required", "string"],
  ];

  protected array $messages = [
    "nav_title.required" => "Judul navigasi tidak boleh kosong.",
    "nav_title.max" => "Judul navigasi tidak boleh lebih dari :max karakter.",
    "title.required" => "Judul tidak boleh kosong.",
    "title.max" => "Judul tidak boleh lebih dari :max karakter.",
    "slug.required" => "Slug tidak boleh kosong.",
    "slug.unique" => "Slug sudah digunakan.",
    "id_guide_parent.required" => "Panduan tidak boleh kosong.",
    "id_guide_parent.integer" => "Panduan harus berupa angka.",
    "status.required" => "Status tidak boleh kosong.",
    "status.in" => "Status tidak valid.",
    "body.required" => "Isi tidak boleh kosong.",
    "body.string" => "Isi harus berupa string.",
  ];


  // ---------------------------------
  // CORES
  public function index(MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminIndex();

    return view("errors.403");
  }

  public function create(MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminCreate();

    return view("errors.403");
  }

  public function store(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminStore($data, $user);

    return view("errors.403");
  }

  public function show($guide)
  {
    // Data processing
    $guide = MasterGuide::where("id_guide", $guide->id_guide)->childs()->first();

    if (!$guide->childs->count()) return $this->allShow($guide);

    return redirect("/dashboard/guides/" . $guide->childs[0]->url);
  }

  public function edit(MasterRole $userRole, MasterGuide $guide)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminEdit($guide);

    return view("errors.403");
  }

  public function update(Request $request, User $user, MasterRole $userRole, MasterGuide $guide)
  {
    // Data processing
    $data = $request->all();
    $guide = MasterGuide::childs()->firstWhere("slug", $guide->slug);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminUpdate($data, $user, $guide);

    return view("errors.403");
  }

  public function destroy(MasterRole $userRole, $slug)
  {
    // Data processing
    $guide = MasterGuide::childs()->firstWhere("slug", $slug);
    if (!$guide) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroy($guide);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 403);
  }

  public function checkSlug(Request $request, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminCheckSlug($data);

    return view("errors.403");
  }


  // ---------------------------------
  // UTILITIES
  // ALL
  public function allShow($guide)
  {
    $viewVariables = [
      "title" => "Panduan",
      "guide" => $guide,
      "guideUrl" => $guide->url,
      "paths" => explode('/', $guide->url),
    ];
    return view("pages.dashboard.actors.custom.guide.show", $viewVariables);
  }


  // ADMIN
  public function adminIndex()
  {
    $guides = MasterGuide::with(["createdBy"])->childs()->sortBy("id_guide_parent");

    $viewVariables = [
      "title" => "Panduan",
      "guides" => $guides,
    ];
    return view("pages.dashboard.actors.admin.guides.index", $viewVariables);
  }

  public function adminCreate()
  {
    $guides = MasterGuide::all()->sortBy("id_guide_parent");

    $viewVariables = [
      "title" => "Buat Panduan",
      "guides" => $guides,
    ];
    return view("pages.dashboard.actors.admin.guides.create", $viewVariables);
  }

  public function adminStore($data, User $user)
  {
    $credentials = Validator::make($data, $this->rules, $this->messages)->validate();
    $credentials = $this->guideCredentials($user, $credentials);
    $guide = $this->createGuide($credentials);

    return redirect($this->createGuideURL($guide->url))->withSuccess("Panduan aplikasi \"$guide->nav_title\" berhasil dibuat!");
  }

  public function adminEdit(MasterGuide $guide)
  {
    $guides = MasterGuide::all()->sortBy("id_guide_parent");
    $guide = MasterGuide::childs()->firstWhere("slug", $guide->slug);

    $viewVariables = [
      "title" => "Sunting Panduan",
      "guides" => $guides,
      "guide" => $guide,
    ];
    return view("pages.dashboard.actors.admin.guides.edit", $viewVariables);
  }

  public function adminUpdate($data, User $user, MasterGuide $guide)
  {
    $rules = $this->slugRules($this->rules, $data['slug'], $guide->slug);

    // ---------------------------------
    // Rules
    if (!$guide->childs->count())
      return $this->alterGuideChild($user, $guide, $data, $rules, $this->messages);

    if ($guide->childs->count())
      return $this->alterGuideParent($user, $guide, $data, $rules, $this->messages);

    return redirect(self::HOME_URL)
      ->withErrors('Kamu tidak bisa melakukan sunting judul dan isi ketika guide adalah "parent".');
  }

  public function adminDestroy(MasterGuide $guide)
  {
    try {
      // ---------------------------------
      // Rules
      if (!$guide->childs->count()) {
        if (!MasterGuide::destroy($guide->id_guide)) throw new \Exception('Error delete guide.');
      } else return $this->responseJsonMessage('Kamu tidak bisa melakukan hapus ketika guide memiliki "childs".', 422);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Guide telah dihapus!");
  }

  public function adminCheckSlug($data)
  {
    $slug = SlugService::createSlug(MasterGuide::class, "slug", $data['nav_title']);

    return response()->json(["slug" => $slug]);
  }
}
