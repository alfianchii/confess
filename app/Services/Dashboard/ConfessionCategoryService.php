<?php

namespace App\Services\Dashboard;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\{Storage, Validator};
use Illuminate\Http\Request;
use App\Services\Service;
use App\Models\{MasterConfessionCategory, User, MasterRole};
use App\Models\Traits\{Exportable};
use App\Exports\Confessions\Categories\{ConfessionCategoriesExport};

class ConfessionCategoryService extends Service
{
  // ---------------------------------
  // TRAITS
  use Exportable;


  // ---------------------------------
  // PROPERTIES
  protected array $rules = [
    "category_name" => ["required", "max:255"],
    "image" => ["image", "file", "max:5120"],
    "description" => ["required"],
    "slug" => ["required", "unique:mst_confession_categories,slug"],
  ];

  protected array $messages = [
    "category_name.required" => "Nama kategori harus diisi.",
    "category_name.max" => "Nama kategori maksimal :max karakter",
    "image.image" => "Gambar kategori harus berupa :file.",
    "image.file" => "File harus berupa :file.",
    "image.max" => "Ukuran gambar maksimal :max KiB.",
    "description.required" => "Deskripsi harus diisi.",
    "slug.required" => "Slug harus diisi.",
    "slug.unique" => "Slug sudah digunakan.",
  ];


  // ---------------------------------
  // CORES
  public function index(User $user, MasterRole $userRole)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminIndex($user);

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

  public function edit(MasterRole $userRole, MasterConfessionCategory $confessionCategory)
  {
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminEdit($confessionCategory);

    return view("errors.403");
  }

  public function update(Request $request, User $user, MasterRole $userRole, MasterConfessionCategory $confessionCategory)
  {
    // Data processing
    $data = $request->all();

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminUpdate($data, $user, $confessionCategory);

    return view("errors.403");
  }

  public function destroy(User $user, MasterRole $userRole, string $slug)
  {
    // Data processing
    $confessionCategory = MasterConfessionCategory::where("slug", $slug)->first();
    if (!$confessionCategory) $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroy($user, $confessionCategory);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }

  public function export(Request $request, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();
    $validator = $this->exportValidates($data);
    if ($validator->fails()) return view("errors.403");
    $creds = $validator->validate();

    $fileName = $this->getExportFileName($creds["type"]);
    $writterType = $this->getWritterType($creds["type"]);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminExport($creds["table"], $fileName, $writterType);

    return view("errors.403");
  }

  public function destroyImage(User $user, MasterRole $userRole, string $slug)
  {
    // Data processing
    $confessionCategory = MasterConfessionCategory::where("slug", $slug)->first();
    if (!$confessionCategory->image) return $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroyImage($user, $confessionCategory);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }

  public function activate(User $user, MasterRole $userRole, string $slug)
  {
    // Data processing
    $confessionCategory = MasterConfessionCategory::where("slug", $slug)->first();
    if (!$confessionCategory) $this->responseJsonMessage("The data you are looking not found.", 404);

    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminActivate($user, $confessionCategory);

    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
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
  // ADMIN
  private function adminIndex()
  {
    $confessionCategories = MasterConfessionCategory::with(["confessions"])
      ->orderBy("category_name", "asc")
      ->get();

    $viewVariables = [
      "title" => "Kategori Pengakuan",
      "confessionCategories" => $confessionCategories,
    ];
    return view("pages.dashboard.actors.admin.confession-categories.index", $viewVariables);
  }

  private function adminCreate()
  {
    $viewVariables = [
      "title" => "Buat Kategori",
    ];
    return view("pages.dashboard.actors.admin.confession-categories.create", $viewVariables);
  }

  private function adminStore($data, User $user)
  {
    $credentials = Validator::make($data, $this->rules, $this->messages)->validate();
    $credentials = $this->imageCropping($data["image"] ?? null, $credentials, "image", "confession/category/images");
    $credentials["created_by"] = $user->id_user;

    try {
      MasterConfessionCategory::create($credentials);
    } catch (\Exception $e) {
      return redirect(self::DASHBOARD_URL)->withErrors($e->getMessage());
    }

    return redirect('/dashboard/confessions/confession-categories')->withSuccess('Kategori pengakuan berhasil dibuat!');
  }

  private function adminEdit(MasterConfessionCategory $confessionCategory)
  {
    $viewVariables = [
      "title" => "Sunting Kategori",
      "confessionCategory" => $confessionCategory,
    ];
    return view("pages.dashboard.actors.admin.confession-categories.edit", $viewVariables);
  }

  private function adminUpdate($data, User $user, MasterConfessionCategory $confessionCategory)
  {
    $rules = $this->slugRules($this->rules, $data['slug'], $confessionCategory->slug);

    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials = $this->imageCropping($confessionCategory->image, $credentials, "image", "confession/category/images");

    return $this->modify($confessionCategory, $credentials, $user->id_user, "kategori pengakuan", "/dashboard/confessions/confession-categories");
  }

  private function adminDestroy(User $user, $confessionCategory)
  {
    try {
      $this->isActiveData($confessionCategory->flag_active);

      if ($confessionCategory->confessions()->count() > 0) throw new \Exception("Pengakuan dalam kategori ini mencegah penghapusan kategori.");
      if (!MasterConfessionCategory::destroy($confessionCategory->id_confession_category)) throw new \Exception("Error deleting confession's category.");
      $confessionCategory->refresh();
      $confessionCategory->update(["updated_by" => $user->id_user, "flag_active" => "N", "deleted_at" => null]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Kategori pengakuan $confessionCategory->category_name telah dinonaktifkan!");
  }

  public function adminExport(string $table, string $fileName, $writterType)
  {
    if ($table === "confession-categories")
      return $this->exports((new ConfessionCategoriesExport), $fileName, $writterType);

    return view("errors.404");
  }

  private function adminDestroyImage(User $user, $confessionCategory)
  {
    try {
      $this->isActiveData($confessionCategory->flag_active);

      if ($confessionCategory->image) Storage::delete($confessionCategory->image);
      $confessionCategory->update(["updated_by" => $user->id_user, "image" => null]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Foto kategori pengakuan telah dihapus!");
  }

  private function adminActivate(User $user, $confessionCategory)
  {
    try {
      $this->isNonActiveData($confessionCategory->flag_active);

      $confessionCategory->update(["updated_by" => $user->id_user, "flag_active" => "Y", "deleted_at" => null]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    return $this->responseJsonMessage("Kategori pengakuan telah diaktivasi!");
  }

  public function adminCheckSlug($data)
  {
    $slug = SlugService::createSlug(MasterConfessionCategory::class, "slug", $data['category_name']);

    return response()->json(["slug" => $slug]);
  }
}